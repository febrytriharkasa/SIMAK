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

Route::get('/', function () {
    return redirect()->route('login');
});

// ================== DASHBOARD ==================
// Dashboard umum → bisa redirect otomatis sesuai role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Dashboard khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin'); // file: resources/views/dashboard/admin.blade.php
    })->name('admin.dashboard');
});

// Dashboard khusus Guru (MI & TK)
Route::middleware(['auth', 'role:guru_mi|guru_tk'])->group(function () {
    Route::get('/guru/dashboard', function () {
        return view('dashboard.guru'); // file: resources/views/dashboard/guru.blade.php
    })->name('guru.dashboard');
});

// ================== REGISTER (PUBLIC) ==================
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);

    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('user.approvals.index');
    Route::post('/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/user-approvals/{id}/reject', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');
});

// ================== ADMIN DAN GURU MI ==================
Route::middleware(['auth', 'role:admin|guru_mi'])->group(function () {
    Route::resource('siswa-mi', SiswaMiController::class);
    Route::resource('guru-mi', GuruMiController::class);
    Route::resource('pembayaran-mi', PembayaranMiController::class)->except(['show']);
    
    // Route::get('pembayaran-mi/{id}/kwitansi-pdf', [PembayaranMiController::class, 'kwitansiPdf'])->name('pembayaran-mi.kwitansi-pdf');
    // Route::get('/pembayaran-mi/export-pdf', [PembayaranMiController::class, 'exportPdf'])->name('pembayaran-mi.export-pdf');
    // Route::get('/naik-kelas-mi', [SiswaMiController::class, 'naikKelas'])->name('siswa.naikKelas');
    // Route::get('/get-siswa-detail/{id}', [PembayaranMiController::class, 'getSiswaDetail']);
    // Route::get('/siswa-mi/{id}', [SiswaMiController::class, 'show'])->name('siswa-mi.show');
});

// ================== ADMIN DAN GURU TK ==================
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

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
