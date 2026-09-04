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
        $totalVoters = Voter::count();
        $votedCount = Voter::where('has_voted', true)->count();
        $unvotedCount = $totalVoters - $votedCount;

        return view('admin.dashboard', compact('candidates', 'totalVoters', 'votedCount', 'unvotedCount'));
    }

    // --- VOTER MANAGEMENT ---

    public function voters()
    {
        $voters = Voter::orderBy('class_name')->get();
        return view('admin.voters', compact('voters'));
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
        ]);

        $voterData = [
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
        $voter->update(['has_voted' => false]);
        return back()->with('success', 'Status pemilihan siswa berhasil direset.');
    }

    public function resetAllVoters()
    {
        Voter::truncate();
        return back()->with('success', 'Seluruh data pemilih berhasil dihapus.');
    }

    public function importVoters(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new VoterImport, $request->file('file'));
            return back()->with('success', 'Data pemilih berhasil diimpor dari Excel.');
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
        $request->validate([
            'name' => 'required|string',
            'class_name' => 'required|string',
            'organization' => 'nullable|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = $request->file('photo')->store('candidates', 'public');

        Candidate::create([
            'name' => $request->name,
            'class_name' => $request->class_name,
            'organization' => $request->organization,
            'vision' => $request->vision,
            'mission' => $request->mission,
            'photo' => '/storage/' . $photoPath,
            'votes' => 0,
        ]);

        return back()->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function updateCandidate(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'class_name' => 'required|string',
            'organization' => 'nullable|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'class_name' => $request->class_name,
            'organization' => $request->organization,
            'vision' => $request->vision,
            'mission' => $request->mission,
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidates', 'public');
            $data['photo'] = '/storage/' . $photoPath;
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
        $setting = \App\Models\Setting::first();
        
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
            'login_method' => 'nullable|string|in:access_code,username_password',
            'voting_start_time' => 'nullable|date',
            'voting_end_time' => 'nullable|date',
            'osim_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        
        $data['use_gradient'] = $request->has('use_gradient');

        // Handle File Uploads
        if ($request->hasFile('osim_logo')) {
            $data['osim_logo'] = '/storage/' . $request->file('osim_logo')->store('settings', 'public');
        }
        if ($request->hasFile('school_logo')) {
            $data['school_logo'] = '/storage/' . $request->file('school_logo')->store('settings', 'public');
        }
        if ($request->hasFile('main_image')) {
            $data['main_image'] = '/storage/' . $request->file('main_image')->store('settings', 'public');
        }

        $setting->update($data);

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

        return back()->with('success', 'Password admin berhasil diubah.');
    }
}
