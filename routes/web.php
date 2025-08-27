<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaMiController;
use App\Http\Controllers\GuruMiController;
use App\Http\Controllers\PembayaranMiController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== ADMIN DAN GURU MI==================
Route::middleware(['auth', 'role:admin|guru_mi'])->group(function () {
    Route::resource('siswa-mi', SiswaMiController::class);
    Route::resource('guru-mi', GuruMiController::class);
    Route::resource('pembayaran-mi', PembayaranMiController::class);
    Route::get('pembayaran-mi/{id}/kwitansi', [PembayaranMiController::class, 'kwitansi'])->name('pembayaran-mi.kwitansi');

});


// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';