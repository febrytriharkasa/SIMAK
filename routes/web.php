<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaMiController;
use App\Http\Controllers\GuruMiController;
use App\Http\Controllers\PembayaranMiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaTkController;
use App\Http\Controllers\GuruTkController;
use App\Http\Controllers\PembayaranTkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\GuruMiDbController;
use App\Http\Controllers\GuruTkDbController;
use App\Http\Controllers\EvaluasiKinerjaController;
use App\Http\Controllers\PasswordResetController;

// =======================================
// DEFAULT REDIRECT
// =======================================
Route::get('/', function () {
    return redirect()->route('login');
});

// =======================================
// DASHBOARD
// =======================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// Guru TK dashboard
Route::middleware(['auth', 'role:guru_tk'])->group(function () {
    Route::get('/guru/tk/dashboard', [GuruTkDbController::class, 'index'])->name('guru-tk.dashboard');
});

// Guru MI dashboard
Route::middleware(['auth', 'role:guru_mi'])->group(function () {
    Route::get('/guru/mi/dashboard', [GuruMiDbController::class, 'index'])->name('guru-mi.dashboard');
});

// =======================================
// PROFILE
// =======================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/foto/{id}', [ProfileController::class, 'avatar'])->name('profile.avatar');
});

// =======================================
// REGISTER (GUEST)
/// =======================================
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// =======================================
// ADMIN ROUTES
// =======================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

    // User approvals
    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('user.approvals.index');
    Route::post('/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/user-approvals/{id}/reject', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');

    // Password reset requests (admin view)
    Route::get('/admin/password-requests', [PasswordResetController::class, 'adminIndex'])->name('admin.password-requests');
    Route::post('/admin/password-requests/{id}/approve', [PasswordResetController::class, 'approveRequest'])->name('admin.password-requests.approve');
    Route::post('/admin/password-requests/{id}/reject', [PasswordResetController::class, 'rejectRequest'])->name('admin.password-requests.reject');

    // Evaluasi
    Route::resource('evaluasi', EvaluasiKinerjaController::class);
});

// =======================================
// ADMIN + GURU MI
// =======================================
Route::middleware(['auth', 'role:admin|guru_mi'])->group(function () {
    Route::resource('siswa-mi', SiswaMiController::class);
    Route::resource('guru-mi', GuruMiController::class);
    Route::resource('pembayaran-mi', PembayaranMiController::class)->except(['show']);
});

// =======================================
// ADMIN + GURU TK
// =======================================
Route::middleware(['auth', 'role:admin|guru_tk'])->group(function () {
    Route::resource('siswa-tk', SiswaTkController::class);
    Route::resource('guru-tk', GuruTkController::class);
    Route::resource('pembayaran-tk', PembayaranTkController::class)->except(['show']);

    Route::get('pembayaran-tk/{id}/kwitansi-pdf', [PembayaranTkController::class, 'kwitansiPdf'])->name('pembayaran-tk.kwitansi-pdf');
    Route::get('/pembayaran-tk/export-pdf', [PembayaranTkController::class, 'exportPdf'])->name('pembayaran-tk.export-pdf');
    Route::get('/naik-kelas-tk', [SiswaTkController::class, 'naikKelasTk'])->name('siswa.naikKelasTk');
    Route::get('/get-siswa-detail/{id}', [PembayaranTkController::class, 'getSiswaDetail']);
    Route::get('/siswa-tk/{id}', [SiswaTkController::class, 'show'])->name('siswa-tk.show');
});

// =======================================
// FORGOT PASSWORD (CUSTOM)
// =======================================
Route::middleware('guest')->group(function () {
    Route::get('/password-reset-request', [PasswordResetController::class, 'showForm'])
        ->name('forgot-password.form');
    Route::post('/password-reset-request', [PasswordResetController::class, 'submitRequest'])
        ->name('forgot-password.submit');
});

// =======================================
// INCLUDE AUTH.LARAVEL DEFAULT
// =======================================
require __DIR__.'/auth.php';
