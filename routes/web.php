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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::resource('users', UserController::class);
});

// ================== ADMIN DAN GURU MI==================
Route::middleware(['auth', 'role:admin|guru_mi'])->group(function () {
    Route::resource('siswa-mi', SiswaMiController::class);
    Route::resource('guru-mi', GuruMiController::class);
    Route::resource('pembayaran-mi', PembayaranMiController::class)->except(['show']);
    Route::get('pembayaran-mi/{id}/kwitansi-pdf', [PembayaranMiController::class, 'kwitansiPdf'])
            ->name('pembayaran-mi.kwitansi-pdf');
    Route::get('/pembayaran-mi/export-pdf', [PembayaranMiController::class, 'exportPdf'])
            ->name('pembayaran-mi.export-pdf');
    Route::get('/naik-kelas', [SiswaMiController::class, 'naikKelas'])->name('siswa.naikKelas');
    Route::get('/get-siswa-detail/{id}', [PembayaranMiController::class, 'getSiswaDetail']);
});

// ================== ADMIN DAN GURU TK==================
Route::middleware(['auth', 'role:admin|guru_tk'])->group(function () {
    Route::resource('siswa-tk', SiswaTkController::class);
    Route::resource('guru-tk', GuruTkController::class);
    Route::resource('pembayaran-tk', PembayaranTkController::class)->except(['show']);
    Route::get('pembayaran-tk/{id}/kwitansi-pdf', [PembayaranTkController::class, 'kwitansiPdf'])
            ->name('pembayaran-tk.kwitansi-pdf');
    Route::get('/pembayaran-tk/export-pdf', [PembayaranTkController::class, 'exportPdf'])
            ->name('pembayaran-tk.export-pdf');
});
// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';