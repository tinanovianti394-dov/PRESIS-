<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\RekapController as AdminRekapController;

use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\ScannerController as GuruScannerController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

// ============================================================
// HALAMAN GUEST (BELUM LOGIN) — Portal Login Multi-Role
// ============================================================
Route::middleware('guest')->group(function () {
    // Halaman utama & portal login (3 kartu role)
    Route::get('/', [LoginController::class, 'portal']);
    Route::get('/login', [LoginController::class, 'portal'])->name('login.portal');
    Route::get('/login/portal', [LoginController::class, 'portal'])->name('login');

    // Form login spesifik per role
    Route::get('/login/admin', [LoginController::class, 'showAdminLogin'])->name('login.admin');
    Route::get('/login/guru', [LoginController::class, 'showGuruLogin'])->name('login.guru');
    Route::get('/login/siswa', [LoginController::class, 'showSiswaLogin'])->name('login.siswa');

    // Proses autentikasi (POST)
    Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

// Logout (bisa diakses via GET maupun POST oleh siapa saja yang sudah login)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Route /dashboard global yang otomatis mengarahkan ke halaman sesuai peran user
Route::get('/dashboard', function () {
    if (\Illuminate\Support\Facades\Auth::guard('siswa')->check()) {
        return redirect()->route('siswa.portal');
    }
    $user = \Illuminate\Support\Facades\Auth::guard('web')->user();
    if ($user?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user?->role === 'guru') {
        return redirect()->route('guru.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');

// ============================================================
// HALAMAN ADMIN (Guard: web, Role: admin)
// ============================================================
Route::middleware(['auth:web', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Ringkasan
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // 2. CRUD Data Siswa & Cetak QR
    Route::get('/siswa/{siswa}/qrcode', [AdminSiswaController::class, 'qrcode'])->name('siswa.qrcode');
    Route::get('/siswa/{siswa}/cetak-kartu', [AdminSiswaController::class, 'cetakKartu'])->name('siswa.cetak-kartu');
    Route::resource('siswa', AdminSiswaController::class);

    // 3. CRUD Data Guru
    Route::resource('guru', AdminGuruController::class);

    // 4. Manajemen Absensi (Manual Input & Koreksi)
    Route::resource('absensi', AdminAbsensiController::class);

    // 5. Rekap Laporan & Cetak Dokumen
    Route::get('/rekap', [AdminRekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/export-pdf', [AdminRekapController::class, 'exportPdf'])->name('rekap.exportPdf');
});

// ============================================================
// HALAMAN GURU (Guard: web, Role: guru)
// ============================================================
Route::middleware(['auth:web', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // 1. Dashboard Guru
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // 2. Scanner Kamera QR Code & Proses AJAX
    Route::get('/scanner', [GuruScannerController::class, 'index'])->name('scanner');
    Route::post('/scanner/process', [GuruScannerController::class, 'processScan'])->name('scanner.process');

    // 3. Data Absensi Harian
    Route::get('/absensi', [GuruAbsensiController::class, 'index'])->name('absensi');

    // 4. Rekapitulasi Harian Per Kelas
    Route::get('/rekap', [GuruAbsensiController::class, 'rekap'])->name('rekap');
    Route::get('/rekap/export-pdf', [GuruAbsensiController::class, 'exportPdf'])->name('rekap.exportPdf');
});

// ============================================================
// HALAMAN SISWA (Guard: siswa)
// ============================================================
Route::middleware('auth:siswa')->prefix('siswa')->name('siswa.')->group(function () {
    // 1. Portal Utama Siswa (support alias dashboard & portal)
    Route::get('/portal', [SiswaDashboardController::class, 'index'])->name('portal');
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // 2. Kartu QR Code Presensi (Terenkripsi AES-128-CBC)
    Route::get('/qrcode', [SiswaDashboardController::class, 'showQrCode'])->name('qrcode');

    // 3. Cetak Kartu ID CR80 Presensi
    Route::get('/cetak-kartu', [SiswaDashboardController::class, 'cetakKartu'])->name('cetak-kartu');

    // 4. Riwayat Lengkap Absensi
    Route::get('/riwayat', [SiswaDashboardController::class, 'riwayat'])->name('riwayat');
});
