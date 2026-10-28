<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\PasienPoliController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Pasien\RiwayatController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Pasien\DashboardController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
});


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])
        ->name('periksa-pasien.index');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])
        ->name('periksa-pasien.store');
    Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])
        ->name('periksa-pasien.create');

    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
});


Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');

    Route::post('/daftar', [PasienPoliController::class, 'submit'])
        ->name('pasien.daftar.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::middleware(['auth'])->group(function () {
    // Export untuk Admin
    Route::get('/admin/export/dokter', [ExportController::class, 'exportDokter'])->name('admin.export.dokter');
    Route::get('/admin/export/pasien', [ExportController::class, 'exportPasien'])->name('admin.export.pasien');
    Route::get('/admin/export/obat', [ExportController::class, 'exportObat'])->name('admin.export.obat');

    // Export untuk Dokter
    Route::get('/dokter/export/jadwal', [ExportController::class, 'exportJadwal'])->name('dokter.export.jadwal');
    Route::get('/dokter/export/riwayat', [ExportController::class, 'exportRiwayatPasien'])->name('dokter.export.riwayat');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pasien/riwayat', [RiwayatController::class, 'index'])->name('pasien.riwayat.index');
    Route::get('/pasien/riwayat/{id}', [RiwayatController::class, 'show'])->name('pasien.riwayat.show');
});

Route::middleware(['auth'])->group(function () {
    // Rute Pembayaran Pasien
    Route::get('/pasien/pembayaran', [PembayaranController::class, 'indexPasien'])->name('pasien.pembayaran.index');
    Route::post('/pasien/pembayaran/{id}/upload', [PembayaranController::class, 'uploadBukti'])->name('pasien.pembayaran.upload');

    // Rute Verifikasi Pembayaran Admin
    Route::get('/admin/pembayaran', [PembayaranController::class, 'indexAdmin'])->name('admin.pembayaran.index');
    Route::put('/admin/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasiAdmin'])->name('admin.pembayaran.konfirmasi');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pasien/dashboard', [DashboardController::class, 'index'])->name('pasien.dashboard');
});