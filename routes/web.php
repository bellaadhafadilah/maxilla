<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SettingController;
use App\Models\Setting;
use App\Http\Controllers\Superadmin\JadwalDokterController as SuperadminJadwalController;
use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\PerformaCabangController;



Route::get('/', function () {
    $setting = Setting::first();
    return view('landing', compact('setting'));
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Notification Routes (Polling API)
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread']);
    Route::post('/api/notifications/mark-as-read/{id}', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('/api/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
});


Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Custom Email Verification Routes
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/resend', [AuthController::class, 'resendVerification'])->name('verification.resend');
Route::get('/email/check-verification', [AuthController::class, 'checkVerification'])->name('verification.check');

// Password Reset Routes
Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'request'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'email'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'update'])->middleware('guest')->name('password.update');

// Superadmin Dashboard Route
Route::get('/superadmin/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard')->middleware('auth');
Route::get('/api/superadmin/stats', [SuperadminDashboardController::class, 'apiStats'])->name('api.superadmin.stats')->middleware('auth');

// Superadmin Cabang Routes
Route::get('/superadmin/cabang', function () {
    return redirect('/superadmin/cabang/slawi');
});

// Superadmin Jadwal Routes
Route::get('/superadmin/jadwal-dokter', [SuperadminJadwalController::class, 'index'])->name('superadmin.jadwal.index')->middleware('auth');

// Superadmin Pengguna Routes
Route::get('/superadmin/pengguna/dokter', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'index'])->name('superadmin.dokter.index')->middleware('auth');
Route::get('/superadmin/pengguna/dokter/create', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'create'])->name('superadmin.dokter.create')->middleware('auth');
Route::post('/superadmin/pengguna/dokter', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'store'])->name('superadmin.dokter.store')->middleware('auth');
Route::get('/superadmin/pengguna/dokter/{id}', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'show'])->name('superadmin.dokter.show')->middleware('auth');
Route::get('/superadmin/pengguna/dokter/{id}/edit', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'edit'])->name('superadmin.dokter.edit')->middleware('auth');
Route::put('/superadmin/pengguna/dokter/{id}', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'update'])->name('superadmin.dokter.update')->middleware('auth');
Route::delete('/superadmin/pengguna/dokter/{id}', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'destroy'])->name('superadmin.dokter.destroy')->middleware('auth');
Route::patch('/superadmin/pengguna/dokter/{id}/toggle-status', [\App\Http\Controllers\Superadmin\AkunDokterController::class, 'toggleStatus'])->name('superadmin.dokter.toggle-status')->middleware('auth');

use App\Http\Controllers\Superadmin\AdminCabangController;
use App\Http\Controllers\Superadmin\AdminPasienController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\JadwalDokterController;

Route::get('/superadmin/pengguna/admin', [AdminCabangController::class, 'index'])->middleware('auth');
Route::get('/superadmin/pengguna/admin/create', [AdminCabangController::class, 'create'])->middleware('auth');
Route::post('/superadmin/pengguna/admin/create', [AdminCabangController::class, 'store'])->middleware('auth');
Route::post('/superadmin/pengguna/admin', [AdminCabangController::class, 'store'])->name('superadmin.admin.store')->middleware('auth');
Route::get('/superadmin/pengguna/admin/{id}', [AdminCabangController::class, 'show'])->name('superadmin.admin.show')->middleware('auth');
Route::get('/superadmin/pengguna/admin/{id}/edit', [AdminCabangController::class, 'edit'])->name('superadmin.admin.edit')->middleware('auth');
Route::put('/superadmin/pengguna/admin/{id}', [AdminCabangController::class, 'update'])->name('superadmin.admin.update')->middleware('auth');
Route::delete('/superadmin/pengguna/admin/{id}', [AdminCabangController::class, 'destroy'])->name('superadmin.admin.destroy')->middleware('auth');
Route::patch('/superadmin/pengguna/admin/{id}/toggle-status', [AdminCabangController::class, 'toggleStatus'])->name('superadmin.admin.toggle-status')->middleware('auth');

Route::get('/superadmin/pengguna/pasien', [AdminPasienController::class, 'index'])->name('superadmin.pasien.index')->middleware('auth');
Route::get('/superadmin/pengguna/pasien/{id}', [AdminPasienController::class, 'show'])->name('superadmin.pasien.show')->middleware('auth');
Route::delete('/superadmin/pengguna/pasien/{id}', [AdminPasienController::class, 'destroy'])->name('superadmin.pasien.destroy')->middleware('auth');
Route::patch('/superadmin/pengguna/pasien/{id}/toggle-status', [AdminPasienController::class, 'toggleStatus'])->name('superadmin.pasien.toggle-status')->middleware('auth');

// Superadmin Akun Apoteker & Kasir
use App\Http\Controllers\Superadmin\AkunApotekerController;
use App\Http\Controllers\Superadmin\AkunKasirController;

Route::get('/superadmin/pengguna/apoteker', [AkunApotekerController::class, 'index'])->name('superadmin.apoteker.index')->middleware('auth');
Route::get('/superadmin/pengguna/apoteker/create', [AkunApotekerController::class, 'create'])->name('superadmin.apoteker.create')->middleware('auth');
Route::post('/superadmin/pengguna/apoteker', [AkunApotekerController::class, 'store'])->name('superadmin.apoteker.store')->middleware('auth');
Route::get('/superadmin/pengguna/apoteker/{id}/edit', [AkunApotekerController::class, 'edit'])->name('superadmin.apoteker.edit')->middleware('auth');
Route::put('/superadmin/pengguna/apoteker/{id}', [AkunApotekerController::class, 'update'])->name('superadmin.apoteker.update')->middleware('auth');
Route::delete('/superadmin/pengguna/apoteker/{id}', [AkunApotekerController::class, 'destroy'])->name('superadmin.apoteker.destroy')->middleware('auth');
Route::patch('/superadmin/pengguna/apoteker/{id}/toggle-status', [AkunApotekerController::class, 'toggleStatus'])->name('superadmin.apoteker.toggle-status')->middleware('auth');

Route::get('/superadmin/pengguna/kasir', [AkunKasirController::class, 'index'])->name('superadmin.kasir.index')->middleware('auth');
Route::get('/superadmin/pengguna/kasir/create', [AkunKasirController::class, 'create'])->name('superadmin.kasir.create')->middleware('auth');
Route::post('/superadmin/pengguna/kasir', [AkunKasirController::class, 'store'])->name('superadmin.kasir.store')->middleware('auth');
Route::get('/superadmin/pengguna/kasir/{id}/edit', [AkunKasirController::class, 'edit'])->name('superadmin.kasir.edit')->middleware('auth');
Route::put('/superadmin/pengguna/kasir/{id}', [AkunKasirController::class, 'update'])->name('superadmin.kasir.update')->middleware('auth');
Route::delete('/superadmin/pengguna/kasir/{id}', [AkunKasirController::class, 'destroy'])->name('superadmin.kasir.destroy')->middleware('auth');
Route::patch('/superadmin/pengguna/kasir/{id}/toggle-status', [AkunKasirController::class, 'toggleStatus'])->name('superadmin.kasir.toggle-status')->middleware('auth');


// Admin Cabang Routes
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/admin/booking', [BookingController::class, 'index'])->name('admin.booking.index')->middleware('auth');
Route::get('/admin/riwayat', [BookingController::class, 'riwayat'])->name('admin.booking.riwayat')->middleware('auth');
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/admin/booking/store', [BookingController::class, 'store'])
    ->name('admin.booking.store')
    ->middleware('auth');

Route::get('/admin/api/available-doctors', [BookingController::class, 'availableDoctors'])
    ->name('admin.available-doctors')
    ->middleware('auth');
Route::get('/admin/api/search-patient-by-nik', [BookingController::class, 'searchPatientByNik'])
    ->name('admin.search-patient-by-nik')
    ->middleware('auth');
Route::post('/admin/booking/{id}/panggil-poli', [BookingController::class, 'panggilPoli'])->name('admin.booking.panggil-poli')->middleware('auth');
Route::post('/admin/booking/{id}/lewati-poli', [BookingController::class, 'lewatiPoli'])->name('admin.booking.lewati-poli')->middleware('auth');
Route::post('/admin/booking/{id}/kembalikan-antrian', [BookingController::class, 'kembalikanAntrian'])->name('admin.booking.kembalikan-antrian')->middleware('auth');
Route::post('/admin/booking/{id}/checkin', [BookingController::class, 'checkinPasien'])->name('admin.booking.checkin')->middleware('auth');
Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('admin.jadwal.index')->middleware('auth');
Route::get('/admin/jadwal-dokter/create', [JadwalDokterController::class, 'create'])->name('admin.jadwal.create')->middleware('auth');
Route::post('/admin/jadwal-dokter', [JadwalDokterController::class, 'store'])->name('admin.jadwal.store')->middleware('auth');
Route::get('/admin/jadwal-dokter/{id}/edit', [JadwalDokterController::class, 'edit'])->name('admin.jadwal.edit')->middleware('auth');
Route::put('/admin/jadwal-dokter/{id}', [JadwalDokterController::class, 'update'])->name('admin.jadwal.update')->middleware('auth');
Route::get('/admin/jadwal-dokter/{id}', [JadwalDokterController::class, 'show'])->name('admin.jadwal.show')->middleware('auth');

// Superadmin Arsip Laporan
Route::get('/superadmin/laporan/pasien', [\App\Http\Controllers\Superadmin\LaporanPasienController::class, 'index'])->name('superadmin.laporan-pasien')->middleware('auth');

Route::get('/superadmin/laporan/pembayaran', [\App\Http\Controllers\Superadmin\LaporanPembayaranController::class, 'index'])->name('superadmin.laporan-pembayaran')->middleware('auth');

// Superadmin CMS & Settings Route
Route::get('/superadmin/pengaturan/website', [SettingController::class, 'index'])->middleware('auth')->name('superadmin.pengaturan-web');
Route::post('/superadmin/pengaturan/website', [SettingController::class, 'update'])->middleware('auth')->name('superadmin.pengaturan-web.update');

Route::get('/superadmin/cabang/{slug}', [PerformaCabangController::class, 'show'])->middleware('auth')->name('superadmin.cabang.show');

// Pasien Routes
Route::prefix('pasien')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard']);

    Route::get('/riwayat', [PasienController::class, 'riwayat']);
    Route::post('/reservasi/{id}/checkin', [PasienController::class, 'checkin'])->name('pasien.reservasi.checkin');
    Route::post('/reservasi/{id}/batal', [PasienController::class, 'batalJanji'])->name('pasien.reservasi.batal');
    Route::get('/bantuan', function () {
        return view('pasien.bantuan');
    });
    
    // Rute yang membutuhkan profil lengkap
    Route::middleware(['profile.completed'])->group(function () {
        Route::get('/buat-janji', [PasienController::class, 'buatJanji']);
        Route::post('/buat-janji', [PasienController::class, 'storeJanji'])->name('pasien.buat-janji.store');
    });
    Route::get('/profil/lengkapi', function () {
        return view('pasien.lengkapi-profil');
    });
    Route::post('/profil/lengkapi', [PasienController::class, 'updateProfil'])->name('pasien.profil.update');
    Route::get('/api/available-doctors', [PasienController::class, 'getAvailableDoctors']);
});

// Dokter Routes
use App\Http\Controllers\Dokter\DokterDashboardController;

Route::prefix('dokter')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
    Route::get('/api/stats', [DokterDashboardController::class, 'getRealtimeStats'])->name('api.dokter.stats');
    Route::get('/jadwal', [DokterDashboardController::class, 'jadwal'])->name('dokter.jadwal');
    Route::get('/antrian', [DokterDashboardController::class, 'antrian'])->name('dokter.antrian');
    Route::get('/riwayat', [DokterDashboardController::class, 'riwayat'])->name('dokter.riwayat');

    // Profil
    Route::get('/profil', [DokterDashboardController::class, 'profil'])->name('dokter.profil');
    Route::post('/profil', [DokterDashboardController::class, 'updateProfil'])->name('dokter.profil.update');

    // Rekam Medis
    Route::get('/rekam-medis/{id_reservasi}', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'create'])->name('dokter.rekam-medis.create');
    Route::post('/rekam-medis/{id_reservasi}', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'store'])->name('dokter.rekam-medis.store');
    Route::get('/rekam-medis/{id_reservasi}/detail', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'show'])->name('dokter.rekam-medis.show');
});

// Apoteker Routes
use App\Http\Controllers\Apoteker\ApotekerDashboardController;
use App\Http\Controllers\Apoteker\ApotekerHistoryController;
use App\Http\Controllers\Apoteker\ObatController as ApotekerObatController;

Route::prefix('apoteker')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ApotekerDashboardController::class, 'index'])->name('apoteker.dashboard');
    Route::get('/antrian', [ApotekerDashboardController::class, 'index'])->name('apoteker.antrian');
    Route::get('/riwayat-obat', [ApotekerHistoryController::class, 'index'])->name('apoteker.riwayat-obat');
    Route::post('/serahkan-obat/{id_reservasi}', [ApotekerDashboardController::class, 'serahkanObat'])->name('apoteker.serahkan-obat');
    Route::post('/proses-bayar/{id_reservasi}', [ApotekerDashboardController::class, 'prosesBayar'])->name('apoteker.proses-bayar');
    
    // Manajemen Obat
    Route::get('/obat', [ApotekerObatController::class, 'index'])->name('apoteker.obat.index');
    Route::post('/obat', [ApotekerObatController::class, 'store'])->name('apoteker.obat.store');
    Route::put('/obat/{id}', [ApotekerObatController::class, 'update'])->name('apoteker.obat.update');
    Route::delete('/obat/{id}', [ApotekerObatController::class, 'destroy'])->name('apoteker.obat.destroy');
});

// Kasir Routes
use App\Http\Controllers\Kasir\KasirDashboardController;
use App\Http\Controllers\Kasir\KasirPaymentHistoryController;
Route::prefix('kasir')->middleware('auth')->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('kasir.dashboard');
    Route::get('/riwayat-pembayaran', [KasirPaymentHistoryController::class, 'index'])->name('kasir.riwayat-pembayaran');
    Route::post('/proses-bayar/{id_reservasi}', [KasirDashboardController::class, 'prosesBayar'])->name('kasir.proses-bayar');
    Route::post('/serahkan-obat/{id_reservasi}', [KasirDashboardController::class, 'serahkanObat'])->name('kasir.serahkan-obat');
    Route::get('/cetak-struk/{id_transaksi}', [KasirDashboardController::class, 'cetakStruk'])->name('kasir.cetak-struk');
    Route::post('/kirim-struk/{id_transaksi}', [KasirDashboardController::class, 'kirimStrukEmail'])->name('kasir.kirim-struk');
});


