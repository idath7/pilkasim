<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!file_exists(storage_path('installed'))) {
            // Cek apakah aplikasi sebenarnya sudah terinstal sebelumnya (misal saat update production)
            // Jika tabel settings sudah ada, anggap sudah terinstal dan buat file penanda.
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                    file_put_contents(storage_path('installed'), 'Auto-detected existing installation at: ' . now());
                    return $next($request);
                }
            } catch (\Exception $e) {
                // Abaikan error (misal DB belum terkoneksi), lanjut ke mode installer
            }

            // Force file session driver during installation to prevent 
            // "sessions table not found" errors when SESSION_DRIVER=database
            config(['session.driver' => 'file']);
            
            if (!$request->is('install*')) {
                return redirect()->route('install.index');
            }
        }
        
        return $next($request);
    }
}
