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
        if (session()->has('voter_id')) {
            return redirect()->route('scanner');
        }
        
        return view('auth.voter_login');
    }

    public function voterLogin(Request $request)
    {
        $setting = \App\Models\Setting::first();
        $loginMethod = $setting->login_method ?? 'access_code';

        $voter = null;

        if ($loginMethod === 'username_password') {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $voter = Voter::where('username', $request->username)->first();
            
            if (!$voter || !\Illuminate\Support\Facades\Hash::check($request->password, $voter->password)) {
                return back()->with('error', 'Username atau Password salah.');
            }
        } else {
            $request->validate([
                'access_code' => 'required|string',
            ]);

            $voter = Voter::where('access_code', strtoupper($request->access_code))->first();
            
            if (!$voter) {
                return back()->with('error', 'Kode Akses tidak ditemukan.');
            }
        }

        if ($voter) {
            if ($voter->has_voted) {
                return back()
                    ->with('error', 'Maaf, Anda sudah pernah memberikan suara pemilihan dengan akun ini.')
                    ->with('timer', 10000);
            }
            
            session(['voter_id' => $voter->id]);
            return redirect()->route('scanner')->with('success', 'Berhasil login! Silakan scan QR Code di Kiosk.');
        }

        return back()->with('error', 'Terjadi kesalahan saat login.');
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
