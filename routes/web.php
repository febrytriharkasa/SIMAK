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
use App\Http\Controllers\AbsensiMIController;
use App\Http\Controllers\AbsensiTKController;
use App\Http\Controllers\PendaftaranMIController;
use App\Http\Controllers\PendaftaranTKController;

Route::get('/', fn() => redirect()->route('login'));

Route::get(
    '/pendaftaran-mi',
    [PendaftaranMIController::class, 'create']
)->name('pendaftaran.mi.create');

Route::post(
    '/pendaftaran-mi',
    [PendaftaranMIController::class, 'store']
)->name('pendaftaran.mi.store');

Route::get(
    '/pendaftaran-tk',
    [PendaftaranTKController::class, 'create']
)->name('pendaftaran.tk.create');
Route::post(
    '/pendaftaran-tk',
    [PendaftaranTKController::class, 'store']
)->name('pendaftaran.tk.store');

// ================== DASHBOARD ==================
// Dashboard umum → redirect otomatis sesuai role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('role:admin')->name('admin.dashboard');
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

    Route::get(
        '/pendaftaran-mi-approvel',
        [PendaftaranMIController::class, 'index']
    )->name('admin.pendaftaran-mi-approvel.mi.index');

    Route::post(
        '/pendaftaran-mi-approvel/{id}/approve',
        [PendaftaranMIController::class, 'approve']
    )->name('admin.pendaftaran.mi.approve');

    Route::post(
        '/pendaftaran-mi-approvel/{id}/reject',
        [PendaftaranMIController::class, 'reject']
    )->name('admin.pendaftaran.mi.reject');

    Route::get(
        '/pendaftaran-tk-approvel',
        [PendaftaranTKController::class, 'index']
    )->name('admin.pendaftaran-tk-approvel.tk.index');
    Route::post(
        '/pendaftaran-tk-approvel/{id}/approve',
        [PendaftaranTKController::class, 'approve']
    )->name('admin.pendaftaran.tk.approve');
    Route::post(
        '/pendaftaran-tk-approvel/{id}/reject',
        [PendaftaranTKController::class, 'reject']
    )->name('admin.pendaftaran.tk.reject');

    Route::resource('siswa-mi', SiswaMiController::class);
    Route::resource('guru-mi', GuruMiController::class);
    Route::resource('siswa-tk', SiswaTkController::class);
    Route::resource('guru-tk', GuruTkController::class);
});

Route::middleware(['auth', 'role:admin|guru_mi|guru_tk'])->group(function () {
    // ✅ Users
    Route::resource('siswa-mi', SiswaMiController::class);
    Route::resource('guru-mi', GuruMiController::class);
    Route::resource('siswa-tk', SiswaTkController::class);
    Route::resource('guru-tk', GuruTkController::class);
    Route::get('/siswa-mi/{id}', [SiswaMiController::class, 'show'])->name('siswa-mi.show');
    Route::get('/siswa-tk/{id}', [SiswaTkController::class, 'show'])->name('siswa-tk.show');
});

// ================== GURU MI==================
Route::middleware(['auth', 'role:guru_mi'])->group(function () {
    Route::resource('pembayaran-mi', PembayaranMiController::class)->except(['show']);
    Route::get('pembayaran-mi/{id}/kwitansi-pdf', [PembayaranMiController::class, 'kwitansiPdf'])
        ->name('pembayaran-mi.kwitansi-pdf');
    Route::get('/pembayaran-mi/export-pdf', [PembayaranMiController::class, 'exportPdf'])
        ->name('pembayaran-mi.export-pdf');
    Route::get('/naik-kelas-mi', [SiswaMiController::class, 'naikKelas'])->name('siswa.naikKelas');
    Route::get('/get-siswa-detail-mi/{id}', [PembayaranMiController::class, 'getSiswaDetail']);
    Route::get('/pembayaran-mi/generate-mi', [PembayaranMiController::class, 'generateFormMI'])->name('pembayaran-mi.generateForm-mi');
    Route::post('/pembayaran-mi/generate-mi', [PembayaranMiController::class, 'generateSPPMI'])->name('pembayaran-mi.generate-mi');
    Route::post('/pembayaran-mi/{id}/approve', [PembayaranMIController::class, 'approvePembayaran'])
        ->name('pembayaran-mi.approve');
    Route::resource('nilai', NilaiMiController::class);
    Route::get('/laporan-pembayaran-mi', [LaporanPembayaranMIController::class, 'index'])
        ->name('laporan-pembayaran-mi.index');
    Route::get('nilai/siswa/{siswaId}', [NilaiMiController::class, 'show'])->name('nilai.show');
    Route::resource('absensi-mi', AbsensiMIController::class);
    Route::get('/absensi-mi/siswa/{kelas}', [AbsensiMIController::class, 'getSiswaByKelas']);
    Route::get('/nilai/rapor/{siswa}', [NilaiMiController::class, 'cetakRaporPdfAllKelas'])
        ->name('nilai.cetakRaporPdfAllKelas');
});





// ================== GURU TK==================
Route::middleware(['auth', 'role:guru_tk'])->group(function () {
    Route::resource('pembayaran-tk', PembayaranTkController::class)->except(['show']);
    Route::get('pembayaran-tk/{id}/kwitansi-pdf', [PembayaranTkController::class, 'kwitansiPdf'])
        ->name('pembayaran-tk.kwitansi-pdf');
    Route::get('/pembayaran-tk/export-pdf', [PembayaranTkController::class, 'exportPdf'])
        ->name('pembayaran-tk.export-pdf');
    Route::get('/naik-kelas-tk', [SiswaTkController::class, 'naikKelasTk'])->name('siswa.naikKelasTk');
    Route::get('/get-siswa-detail-tk/{id}', [PembayaranTkController::class, 'getSiswaDetail']);
    
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

    Route::resource('absensi-tk', AbsensiTKController::class);
    Route::get('/absensi-tk/siswa/{kelas}', [AbsensiTKController::class, 'getSiswaByKelas']);
    Route::get('/nilai-tk/rapor/{siswa}', [NilaiTkController::class, 'cetakRaporPdfAllKelas'])
        ->name('nilai-tk.cetakRaporPdfAllKelas');
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

require __DIR__ . '/auth.php';
