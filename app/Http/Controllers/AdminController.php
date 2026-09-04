<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Voter;
use Illuminate\Support\Str;
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
        $voters = Voter::where('type', 'student')->orderBy('class_name')->get();
        return view('admin.voters', compact('voters'));
    }

    public function teachers()
    {
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
            'access_code' => $request->filled('access_code') ? strtoupper($request->access_code) : strtoupper(Str::random(6)),
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

    public function resetAllVoters()
    {
        Voter::truncate();
        Candidate::query()->update(['votes' => 0]);
        return back()->with('success', 'Seluruh data pemilih dihapus dan semua hasil perolehan suara di-reset ke 0.');
    }

    public function resetVotes()
    {
        Candidate::query()->update(['votes' => 0]);
        Voter::query()->update(['has_voted' => false, 'voted_candidate_id' => null]);
        
        return back()->with('success', 'Hasil perolehan suara dan status pemilihan siswa berhasil dikosongkan (kembali ke 0).');
    }

    public function importVoters(Request $request)
    {
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
        $candidates = Candidate::all();
        $existingCandidates = $candidates->map(function($c) { return $c->name . '|' . $c->class_name; })->toArray();
        $voters = Voter::orderBy('name')->get()->filter(function($voter) use ($existingCandidates) {
            return !in_array($voter->name . '|' . $voter->class_name, $existingCandidates);
        });
        
        return view('admin.candidates', compact('candidates', 'voters'));
    }

    public function storeCandidate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'chairman_name' => 'nullable|string',
            'vice_chairman_name' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'order_number' => 'required|integer',
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
        $candidate = Candidate::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'chairman_name' => 'nullable|string',
            'vice_chairman_name' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'order_number' => 'required|integer',
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
        ]);
        
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

        $filename = \Illuminate\Support\Str::random(40) . '.jpg';
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

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            
            $tmpImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Handle transparency to white
            $white = imagecolorallocate($tmpImage, 255, 255, 255);
            imagefill($tmpImage, 0, 0, $white);
            
            imagecopyresampled($tmpImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $tmpImage;
        }

        imagejpeg($image, $fullPath, 75); // Compress quality 75%
        imagedestroy($image);

        return '/storage/' . $folder . '/' . $filename;
    }
}

