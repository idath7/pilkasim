<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Voter Auth
Route::get('/login', [AuthController::class, 'showVoterLogin'])->name('voter.login')->middleware('check.user.agent');
Route::post('/login', [AuthController::class, 'voterLogin']);
Route::post('/logout', [AuthController::class, 'voterLogout'])->name('voter.logout');

// Voting
Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
Route::post('/voting/{id}', [VotingController::class, 'vote'])->name('voting.vote');

// Admin Auth
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

Route::get('/kiosk', function () {
    $appSetting = \App\Models\Setting::first();
    return view('kiosk.index', compact('appSetting'));
})->name('kiosk');

Route::get('/scanner', function () {
    $appSetting = \App\Models\Setting::first();
    return view('scanner.index', compact('appSetting'));
})->name('scanner');

Route::get('/api/kiosk-token', function() {
    $duration = \App\Models\Setting::first()->token_duration ?? 30;
    $timeWindow = floor(time() / $duration);
    $appKey = env('APP_KEY', 'default_key');
    $token = substr(md5($appKey . $timeWindow), 0, 8);
    $remaining = $duration - (time() % $duration);
    return response()->json([
        'token' => $token,
        'url' => route('voter.login', ['token' => $token]),
        'remaining' => $remaining,
        'duration' => $duration
    ]);
})->name('kiosk.token');

// Admin Dashboard
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Voter Management
    Route::get('/admin/voters', [AdminController::class, 'voters'])->name('admin.voters');
    Route::post('/admin/voters', [AdminController::class, 'storeVoter'])->name('admin.voters.store');
    Route::post('/admin/voters/{id}/reset', [AdminController::class, 'resetVoterStatus'])->name('admin.voters.reset');
    Route::post('/admin/voters/reset-all', [AdminController::class, 'resetAllVoters'])->name('admin.voters.reset_all');
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
