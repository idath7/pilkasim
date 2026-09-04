<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Voter Auth
Route::get('/login', [AuthController::class, 'showVoterLogin'])->name('voter.login');
Route::post('/login', [AuthController::class, 'voterLogin']);
Route::post('/logout', [AuthController::class, 'voterLogout'])->name('voter.logout');

// Voting
Route::middleware('check.user.agent')->group(function () {
    Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/voting/{id}', [VotingController::class, 'vote'])->name('voting.vote');
});

// Admin Auth
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

Route::get('/kiosk/login', [AuthController::class, 'showKioskLogin'])->name('kiosk.login');
Route::post('/kiosk/login', [AuthController::class, 'kioskLogin']);

Route::get('/kiosk', function () {
    $appSetting = \App\Models\Setting::first();
    if ($appSetting && $appSetting->kiosk_pin && !session()->has('kiosk_authenticated')) {
        return redirect()->route('kiosk.login');
    }
    return view('kiosk.index', compact('appSetting'));
})->name('kiosk');

Route::get('/scanner', function () {
    $appSetting = \App\Models\Setting::first();
    return view('scanner.index', compact('appSetting'));
})->name('scanner');

Route::get('/api/kiosk-token', function() {
    $setting = \App\Models\Setting::first();
    $duration = $setting->token_duration ?? 30;
    $token = \Illuminate\Support\Str::random(12);
    \Illuminate\Support\Facades\Cache::put('kiosk_token_' . $token, 'pending', now()->addMinutes(60));
    
    return response()->json([
        'token' => $token,
        'url' => route('voting.index', ['token' => $token]),
        'remaining' => (int) $duration
    ]);
})->name('kiosk.token');

Route::get('/api/kiosk-status', function(\Illuminate\Http\Request $request) {
    $token = $request->query('token');
    $status = $token ? \Illuminate\Support\Facades\Cache::get('kiosk_token_' . $token) : null;
    
    return response()->json([
        'status' => $status ?? 'invalid'
    ]);
})->name('kiosk.status');

// Admin Dashboard
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');
    
    // Database Migration Route for Shared Hosting
    Route::get('/admin/run-migrations', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $output = \Illuminate\Support\Facades\Artisan::output();
            return response("<pre>Migrasi berhasil dijalankan:\n" . $output . "</pre><br><a href='" . route('admin.dashboard') . "'>Kembali ke Dashboard</a>");
        } catch (\Exception $e) {
            return response("<pre>Terjadi kesalahan saat migrasi:\n" . $e->getMessage() . "</pre>");
        }
    });

    // Storage Link Route for Shared Hosting
    Route::get('/admin/run-storage-link', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            $output = \Illuminate\Support\Facades\Artisan::output();
            return response("<pre>Storage link berhasil dibuat:\n" . $output . "</pre><br><a href='" . route('admin.dashboard') . "'>Kembali ke Dashboard</a>");
        } catch (\Exception $e) {
            return response("<pre>Terjadi kesalahan saat membuat storage link:\n" . $e->getMessage() . "</pre>");
        }
    });
    
    // Voter Management (Siswa)
    Route::get('/admin/voters', [AdminController::class, 'voters'])->name('admin.voters');
    
    // Voter Management (Guru)
    Route::get('/admin/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');

    // Print Cards
    Route::get('/admin/voters/print', [AdminController::class, 'printCards'])->name('admin.voters.print');

    Route::post('/admin/voters', [AdminController::class, 'storeVoter'])->name('admin.voters.store');
    Route::post('/admin/voters/{id}/reset', [AdminController::class, 'resetVoterStatus'])->name('admin.voters.reset');
    Route::post('/admin/voters/reset-all', [AdminController::class, 'resetAllVoters'])->name('admin.voters.reset_all');
    Route::post('/admin/voters/reset-votes', [AdminController::class, 'resetVotes'])->name('admin.voters.reset_votes');
    Route::post('/admin/voters/import', [AdminController::class, 'importVoters'])->name('admin.voters.import');
    Route::get('/admin/voters/template', [AdminController::class, 'downloadVoterTemplate'])->name('admin.voters.template');
    
    // Candidate Management
    Route::get('/admin/candidates', [AdminController::class, 'candidates'])->name('admin.candidates');
    Route::post('/admin/candidates', [AdminController::class, 'storeCandidate'])->name('admin.candidates.store');
    Route::post('/admin/candidates/{id}/update', [AdminController::class, 'updateCandidate'])->name('admin.candidates.update');
    Route::post('/admin/candidates/{id}/delete', [AdminController::class, 'destroyCandidate'])->name('admin.candidates.destroy');

    // App Settings
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});
