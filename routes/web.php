<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaMiController;
use App\Http\Controllers\GuruMiController;
use App\Http\Controllers\PembayaranMiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaTkController;
use App\Http\Controllers\GuruTkController;
use App\Http\Controllers\PembayaranTkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NilaiMiController;
use App\Http\Controllers\NilaiTkController;
use App\Http\Controllers\Admin\EvaluasiKinerjaController;
use App\Http\Controllers\GuruMiDbController;
use App\Http\Controllers\GuruTkDbController;
use App\Http\Controllers\LaporanPembayaranMIController;
use App\Http\Controllers\LaporanPembayaranTKController;
use App\Http\Controllers\PasswordResetController;

Route::get('/', fn () => redirect()->route('login'));

// ================== DASHBOARD ==================
// Dashboard umum → redirect otomatis sesuai role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('/guru/tk/dashboard', [GuruTkDbController::class, 'index'])->middleware('role:guru_tk')->name('guru-tk.dashboard');
    Route::get('/guru/mi/dashboard', [GuruMiDbController::class, 'index'])->middleware('role:guru_mi')->name('guru-mi.dashboard');
});

// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // ✅ Users
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

    // ✅ User approvals
    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('user.approvals.index');
    Route::post('/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/user-approvals/{id}/reject', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');

    // ✅ Password reset requests
    Route::get('/admin/password-requests', [PasswordResetController::class, 'adminIndex'])->name('admin.password-requests');
    Route::post('/admin/password-requests/{id}/approve', [PasswordResetController::class, 'approveRequest'])->name('admin.password-requests.approve');
    Route::post('/admin/password-requests/{id}/reject', [PasswordResetController::class, 'rejectRequest'])->name('admin.password-requests.reject');

    // ✅ Evaluasi
    Route::resource('evaluasi', EvaluasiKinerjaController::class);
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
    Route::get('/naik-kelas-mi', [SiswaMiController::class, 'naikKelas'])->name('siswa.naikKelas');
    Route::get('/get-siswa-detail-mi/{id}', [PembayaranMiController::class, 'getSiswaDetail']);
    Route::get('/siswa-mi/{id}', [SiswaMiController::class, 'show'])->name('siswa-mi.show');
    Route::get('/pembayaran-mi/generate-mi', [PembayaranMiController::class, 'generateFormMI'])->name('pembayaran-mi.generateForm-mi');
    Route::post('/pembayaran-mi/generate-mi', [PembayaranMiController::class, 'generateSPPMI'])->name('pembayaran-mi.generate-mi');
    Route::post('/pembayaran-mi/{id}/approve', [PembayaranMIController::class, 'approvePembayaran'])
            ->name('pembayaran-mi.approve');
    Route::resource('nilai', NilaiMiController::class);
    Route::get('/laporan-pembayaran-mi', [LaporanPembayaranMIController::class, 'index'])
            ->name('laporan-pembayaran-mi.index');
    Route::get('nilai/siswa/{siswaId}', [NilaiMiController::class, 'show'])->name('nilai.show');
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
    Route::get('/naik-kelas-tk', [SiswaTkController::class, 'naikKelasTk'])->name('siswa.naikKelasTk');
    Route::get('/get-siswa-detail-tk/{id}', [PembayaranTkController::class, 'getSiswaDetail']);
    Route::get('/siswa-mi/{id}', [SiswaTkController::class, 'show'])->name('siswa-tk.show');
    Route::get('/pembayaran-tk/generate-tk', [PembayaranTkController::class, 'generateFormTK'])->name('pembayaran-tk.generateForm-tk');
    Route::post('/pembayaran-tk/generate-tk', [PembayaranTkController::class, 'generateSPPTK'])->name('pembayaran-tk.generate-tk');
     Route::post('/pembayaran-tk/{id}/approve', [PembayaranTkController::class, 'approvePembayaran'])
            ->name('pembayaran-tk.approve');
    Route::get('/laporan-pembayaran-tk', [LaporanPembayaranTKController::class, 'index'])
            ->name('laporan-pembayaran-tk.index');
    Route::resource('nilai-tk', NilaiTkController::class)->parameters([
        'nilai-tk' => 'nilai'
    ]);

    Route::get('nilai-tk/siswa/{siswaId}', [NilaiTkController::class, 'show'])->name('nilai-tk.show');
});

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ✅ Avatar (Blob Preview)
    Route::get('/profile/foto/{id}', [ProfileController::class, 'avatar'])->name('profile.avatar');

    // ✅ Tambah route ganti password
    Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // ✅ Forgot Password Custom
    Route::get('/password-reset-request', [PasswordResetController::class, 'showForm'])->name('password-request.form');
    Route::post('/password-reset-request', [PasswordResetController::class, 'submitRequest'])->name('password-request.submit');
});

require __DIR__.'/auth.php';










