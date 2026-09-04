<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voter;

class AuthController extends Controller
{
    // Voter Auth
    public function showVoterLogin()
    {
        return view('auth.voter_login');
    }

    public function voterLogin(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        $voter = Voter::where('access_code', strtoupper($request->access_code))->first();

        if ($voter) {
            if ($voter->has_voted) {
                return back()
                    ->with('error', 'Maaf, Anda sudah pernah memberikan suara pemilihan dengan kode ini.')
                    ->with('timer', 10000);
            }
            
            session(['voter_id' => $voter->id]);
            return redirect()->route('voting.index')->with('success', 'Berhasil login! Silakan pilih kandidat Anda.');
        }

        return back()->with('error', 'Kode Akses tidak ditemukan.');
    }

    public function voterLogout()
    {
        session()->forget('voter_id');
        return redirect('/');
    }

    // Admin Auth
    public function showAdminLogin()
    {
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai Admin.');
        }

        return back()->with('error', 'Username atau Password salah.');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
