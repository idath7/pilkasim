<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Voter;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VoterImport;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $candidates = Candidate::all();
        $totalStudentVoters = Voter::where('type', 'student')->count();
        $votedStudentCount = Voter::where('type', 'student')->where('has_voted', true)->count();
        $unvotedStudentCount = $totalStudentVoters - $votedStudentCount;

        $totalTeacherVoters = Voter::where('type', 'teacher')->count();
        $votedTeacherCount = Voter::where('type', 'teacher')->where('has_voted', true)->count();
        $unvotedTeacherCount = $totalTeacherVoters - $votedTeacherCount;

        $votedCount = Voter::where('has_voted', true)->count(); // Overall voted count for percentages

        return view('admin.dashboard', compact(
            'candidates', 
            'totalStudentVoters', 'votedStudentCount', 'unvotedStudentCount',
            'totalTeacherVoters', 'votedTeacherCount', 'unvotedTeacherCount',
            'votedCount'
        ));
    }

    // --- VOTER MANAGEMENT ---

    public function voters()
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $voters = Voter::where('type', 'student')->orderBy('class_name')->get();
        return view('admin.voters', compact('voters'));
    }

    public function teachers()
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $voters = Voter::where('type', 'teacher')->orderBy('class_name')->get();
        return view('admin.teachers', compact('voters'));
    }

    public function printCards(Request $request)
    {
        $type = $request->query('type', 'student');
        $voters = Voter::where('type', $type)->orderBy('class_name')->orderBy('name')->get();
        $appSetting = \App\Models\Setting::getCached();
        
        return view('admin.print_cards', compact('voters', 'type', 'appSetting'));
    }

    public function storeVoter(Request $request)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $request->validate([
            'nis' => 'nullable|string',
            'name' => 'required|string',
            'class_name' => 'required|string',
            'gender' => 'required|string|in:L,P',
            'access_code' => 'nullable|string|unique:voters,access_code',
            'username' => 'nullable|string|unique:voters,username',
            'password' => 'nullable|string|min:4',
            'type' => 'nullable|string|in:student,teacher',
        ]);

        $voterData = [
            'type' => $request->input('type', 'student'),
            'nis' => $request->nis,
            'name' => $request->name,
            'class_name' => $request->class_name,
            'gender' => $request->gender,
            'access_code' => $request->filled('access_code') ? strtoupper($request->access_code) : strtoupper(Str::random(8)),
            'has_voted' => false,
        ];

        if ($request->filled('username') && $request->filled('password')) {
            $voterData['username'] = $request->username;
            $voterData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        Voter::create($voterData);

        return back()->with('success', 'Pemilih berhasil ditambahkan.');
    }

    public function resetVoterStatus($id)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $voter = Voter::findOrFail($id);
        
        // Decrement candidate vote if they had voted
        if ($voter->has_voted && $voter->voted_candidate_id) {
            $candidate = Candidate::find($voter->voted_candidate_id);
            if ($candidate && $candidate->votes > 0) {
                $candidate->decrement('votes');
            }
        }
        
        $voter->update([
            'has_voted' => false,
            'voted_candidate_id' => null
        ]);
        
        return back()->with('success', 'Status pemilihan siswa berhasil direset (Suara kandidat otomatis dikurangi).');
    }

    public function generateAccessCodes(Request $request)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $type = $request->input('type', 'student');
        $forceAll = $request->input('force_all', false); // true means replace existing codes
        
        $query = Voter::where('type', $type);
        
        if (!$forceAll) {
            $query->where(function($q) {
                $q->whereNull('access_code')
                  ->orWhere('access_code', '')
                  ->orWhereRaw('LENGTH(access_code) < 8');
            });
        }
        
        $voters = $query->get();
        $count = 0;
        
        foreach ($voters as $voter) {
            $voter->access_code = strtoupper(Str::random(8));
            $voter->save();
            $count++;
        }
        
        return back()->with('success', "Berhasil me-generate {$count} kode akses (8 karakter) untuk tipe {$type}.");
    }

    public function regenerateSingleCode($id)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $voter = Voter::findOrFail($id);
        $voter->access_code = strtoupper(Str::random(8));
        $voter->save();
        
        return back()->with('success', "Berhasil membuat kode akses baru untuk pemilih: {$voter->name}");
    }

    public function resetAllVoters()
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        Voter::truncate();
        Candidate::query()->update(['votes' => 0]);
        return back()->with('success', 'Seluruh data pemilih dihapus dan semua hasil perolehan suara di-reset ke 0.');
    }

    public function resetVotes()
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        Candidate::query()->update(['votes' => 0]);
        Voter::query()->update(['has_voted' => false, 'voted_candidate_id' => null]);
        
        return back()->with('success', 'Hasil perolehan suara dan status pemilihan siswa berhasil dikosongkan (kembali ke 0).');
    }

    public function importVoters(Request $request)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'type' => 'nullable|string|in:student,teacher'
        ]);

        $type = $request->input('type', 'student');

        try {
            Excel::import(new VoterImport($type), $request->file('file'));
            return back()->with('success', 'Data pemilih (' . ($type == 'teacher' ? 'Guru' : 'Siswa') . ') berhasil diimpor dari Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }

    public function downloadVoterTemplate()
    {
        $filePath = public_path('template_pemilih.xlsx');
        
        // If template doesn't exist, we can dynamically generate or just expect it to be in public
        // I will create a simple way to return the template.
        if (!file_exists($filePath)) {
            return back()->with('error', 'File template belum tersedia.');
        }
        
        return response()->download($filePath);
    }

    // --- CANDIDATE MANAGEMENT ---

    public function candidates()
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $candidates = Candidate::all();
        $existingCandidates = $candidates->map(function($c) { return $c->name . '|' . $c->class_name; })->toArray();
        $voters = Voter::orderBy('name')->get()->filter(function($voter) use ($existingCandidates) {
            return !in_array($voter->name . '|' . $voter->class_name, $existingCandidates);
        });
        
        return view('admin.candidates', compact('candidates', 'voters'));
    }

    public function storeCandidate(Request $request)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $data = $request->validate([
            'name' => 'required|string',
            'class_name' => 'nullable|string',
            'organization' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->compressImage($request->file('photo'), 'candidates', 800);
        }

        Candidate::create($data);

        return back()->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function updateCandidate(Request $request, $id)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $candidate = Candidate::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'class_name' => 'nullable|string',
            'organization' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->compressImage($request->file('photo'), 'candidates', 800);
        }

        $candidate->update($data);

        return back()->with('success', 'Data kandidat berhasil diperbarui.');
    }

    public function destroyCandidate($id)
    {
        if (auth('admin')->user()->role === 'pembina') abort(403);
        $candidate = \App\Models\Candidate::findOrFail($id);
        
        // Optional: Delete photo if exists
        // if ($candidate->photo && file_exists(public_path($candidate->photo))) {
        //     unlink(public_path($candidate->photo));
        // }

        $candidate->delete();

        return back()->with('success', 'Kandidat berhasil dihapus.');
    }

    public function settings()
    {
        if (auth('admin')->user()->role !== 'admin') abort(403);
        $setting = \App\Models\Setting::firstOrCreate([
            'id' => 1
        ], [
            'school_name' => 'Nama Sekolah Anda',
            'instructions' => 'Masukkan Kode Akses unik yang telah diberikan oleh panitia (KPO) untuk melakukan pemilihan Ketua OSIM, lalu pilih Calon Ketua OSIM dengan menekan tombol PILIH pada kandidat pilihan Anda.',
        ]);

        return view('admin.settings', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        if (auth('admin')->user()->role !== 'admin') abort(403);
        $setting = \App\Models\Setting::getCached();
        
        $data = $request->validate([
            'school_name' => 'nullable|string',
            'instructions' => 'nullable|string',
            'theme_color_1' => 'nullable|string',
            'theme_color_2' => 'nullable|string',
            'theme_color_3' => 'nullable|string|max:20',
            'theme_color_4' => 'nullable|string|max:20',
            'theme_color_5' => 'nullable|string|max:20',
            'theme_color_6' => 'nullable|string|max:20',
            'use_gradient' => 'nullable|boolean',
            'token_duration' => 'nullable|integer|min:5|max:3600',
            'kiosk_pin' => 'nullable|string|max:6',
            'login_method' => 'nullable|string|in:access_code,username_password',
            'timezone' => 'nullable|string|in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura',
            'voting_start_time' => 'nullable|date',
            'voting_end_time' => 'nullable|date',
            'osim_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:10240',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:10240',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:10240',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'seo_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'dynamic_color_tags' => 'nullable|array',
            'dynamic_color_tags.*.tag' => 'required_with:dynamic_color_tags|string',
            'dynamic_color_tags.*.bg_color' => 'nullable|string',
            'dynamic_color_tags.*.text_color' => 'nullable|string',
        ]);
        
        // Ensure dynamic_color_tags are cleaned up (empty items removed)
        if (isset($data['dynamic_color_tags'])) {
            $data['dynamic_color_tags'] = array_values(array_filter($data['dynamic_color_tags'], function($item) {
                return !empty($item['tag']);
            }));
        } else {
            $data['dynamic_color_tags'] = []; // Clear them if not sent
        }
        
        $data['use_gradient'] = $request->has('use_gradient');

        // Handle File Uploads (Auto Compress)
        if ($request->hasFile('osim_logo')) {
            $data['osim_logo'] = $this->compressImage($request->file('osim_logo'), 'settings', 600);
        }
        if ($request->hasFile('school_logo')) {
            $data['school_logo'] = $this->compressImage($request->file('school_logo'), 'settings', 600);
        }
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->compressImage($request->file('main_image'), 'settings', 1600);
        }
        if ($request->hasFile('seo_image')) {
            $data['seo_image'] = $this->compressImage($request->file('seo_image'), 'settings', 1200);
        }

        $setting->update($data);

        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('app_settings_v2');

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:4'
        ]);

        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        $admin->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function optimize()
    {
        if (auth('admin')->user()->role !== 'admin') abort(403);
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        \Illuminate\Support\Facades\Artisan::call('optimize');
        return back()->with('success', 'Sistem berhasil dioptimalkan (Cache Cleared & Re-cached).');
    }

    /**
     * Helper untuk kompresi dan resize gambar otomatis
     */
    private function compressImage($file, $folder, $maxWidth = 1600)
    {
        if ($file->getMimeType() == 'image/svg+xml') {
            return '/storage/' . $file->store($folder, 'public');
        }

        $extension = $file->extension();
        if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
            $extension = 'jpg';
        }
        $filename = \Illuminate\Support\Str::random(40) . '.' . strtolower($extension);
        $path = storage_path('app/public/' . $folder);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $fullPath = $path . '/' . $filename;
        
        $mime = $file->getMimeType();
        $image = null;

        if ($mime == 'image/jpeg') {
            $image = @imagecreatefromjpeg($file->getRealPath());
        } elseif ($mime == 'image/png') {
            $image = @imagecreatefrompng($file->getRealPath());
        } elseif ($mime == 'image/webp') {
            $image = @imagecreatefromwebp($file->getRealPath());
        }

        if (!$image) {
            return '/storage/' . $file->store($folder, 'public');
        }

        if ($mime == 'image/png' || $mime == 'image/webp') {
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            
            $tmpImage = imagecreatetruecolor($newWidth, $newHeight);
            
            if ($mime == 'image/png' || $mime == 'image/webp') {
                imagealphablending($tmpImage, false);
                imagesavealpha($tmpImage, true);
                $transparent = imagecolorallocatealpha($tmpImage, 255, 255, 255, 127);
                imagefill($tmpImage, 0, 0, $transparent);
            } else {
                $white = imagecolorallocate($tmpImage, 255, 255, 255);
                imagefill($tmpImage, 0, 0, $white);
            }
            
            imagecopyresampled($tmpImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $tmpImage;
        }

        if ($mime == 'image/png') {
            imagepng($image, $fullPath, 8);
        } elseif ($mime == 'image/webp') {
            imagewebp($image, $fullPath, 80);
        } else {
            imagejpeg($image, $fullPath, 80);
        }
        
        imagedestroy($image);

        return '/storage/' . $folder . '/' . $filename;
    }

    // ==========================================
    // USER MANAGEMENT (ADMIN / PETUGAS / PEMBINA)
    // ==========================================
    
    public function users()
    {
        // Hanya admin utama yang boleh mengakses halaman ini
        if (auth('admin')->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $users = Admin::all();
        return view('admin.users', compact('users'));
    }
    
    public function storeUser(Request $request)
    {
        if (auth('admin')->user()->role !== 'admin') {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:4',
            'role' => 'required|in:admin,panitia,pembina',
        ]);
        
        Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin.users')->with('success', 'Akun berhasil ditambahkan!');
    }
    
    public function updateUser(Request $request, $id)
    {
        if (auth('admin')->user()->role !== 'admin') {
            abort(403);
        }
        
        $user = Admin::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,'.$id,
            'email' => 'required|email|max:255|unique:admins,email,'.$id,
            'password' => 'nullable|string|min:4',
            'role' => 'required|in:admin,panitia,pembina',
        ]);
        
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'Akun berhasil diperbarui!');
    }
    
    public function destroyUser($id)
    {
        if (auth('admin')->user()->role !== 'admin') {
            abort(403);
        }
        
        $user = Admin::findOrFail($id);
        
        // Mencegah admin menghapus dirinya sendiri
        if ($user->id === auth('admin')->id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'Akun berhasil dihapus!');
    }
}

