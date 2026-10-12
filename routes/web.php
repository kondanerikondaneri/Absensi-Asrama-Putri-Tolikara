<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Penghuni;
use App\Http\Controllers\Keamanan;
use App\Http\Controllers\Pengurus;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/', function () {
        return match(auth()->user()->role) {
            'penghuni'  => redirect()->route('penghuni.dashboard'),
            'keamanan'  => redirect()->route('keamanan.dashboard'),
            'pengurus'  => redirect()->route('pengurus.dashboard'),
            default     => abort(403)
        };
    })->name('home');
});

// Penghuni
Route::prefix('penghuni')->middleware(['auth', 'role:penghuni'])->name('penghuni.')->group(function () {
    Route::get('/dashboard', [Penghuni\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/absensi', [Penghuni\AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/gps', [Penghuni\AbsensiController::class, 'absenGps'])->name('absensi.gps');
    Route::post('/absensi/qr', [Penghuni\AbsensiController::class, 'absenQr'])->name('absensi.qr');
    Route::post('/absensi/manual', [Penghuni\AbsensiController::class, 'absenManual'])->name('absensi.manual');
    
    Route::get('/keluar', [Penghuni\IzinKeluarController::class, 'index'])->name('keluar');
    Route::post('/keluar', [Penghuni\IzinKeluarController::class, 'store'])->middleware('exit.time')->name('keluar.store');
    Route::post('/kembali', [Penghuni\IzinKeluarController::class, 'kembali'])->name('kembali');
    
    Route::get('/riwayat', [Penghuni\DashboardController::class, 'riwayat'])->name('riwayat');
});

// Keamanan
Route::prefix('keamanan')->middleware(['auth', 'role:keamanan'])->name('keamanan.')->group(function () {
    Route::get('/dashboard', [Keamanan\DashboardController::class, 'index'])->name('dashboard');
    
    Route::middleware('curfew.time')->group(function() {
        Route::get('/curfew', [Keamanan\CurfewController::class, 'index'])->name('curfew');
        Route::get('/curfew/blok/{blok}', [Keamanan\CurfewController::class, 'showBlok'])->name('curfew.blok');
        Route::post('/curfew/check', [Keamanan\CurfewController::class, 'check'])->name('curfew.check');
        Route::post('/curfew/check-qr', [Keamanan\CurfewController::class, 'checkQr'])->name('curfew.check-qr');
        Route::post('/curfew/batch', [Keamanan\CurfewController::class, 'batchSubmit'])->name('curfew.batch');
    });
    
    Route::get('/curfew/riwayat', [Keamanan\CurfewController::class, 'riwayat'])->name('curfew.riwayat');
});

// Pengurus
Route::prefix('pengurus')->middleware(['auth', 'role:pengurus'])->name('pengurus.')->group(function () {
    Route::get('/dashboard', [Pengurus\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', Pengurus\UserController::class);
    Route::resource('blok', Pengurus\BlokController::class);
    Route::resource('kamar', Pengurus\KamarController::class);
    
    Route::get('/qr-codes', [Pengurus\QrCodeController::class, 'index'])->name('qr.index');
    Route::post('/qr-codes/generate', [Pengurus\QrCodeController::class, 'generate'])->name('qr.generate');
    Route::delete('/qr-codes/{qr}', [Pengurus\QrCodeController::class, 'destroy'])->name('qr.destroy');
    
    Route::get('/monitoring', [Pengurus\MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/laporan', [Pengurus\LaporanController::class, 'index'])->name('laporan');
});
