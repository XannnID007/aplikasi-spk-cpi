<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\HasilCpiController as AdminHasilCpiController;
use App\Http\Controllers\Admin\PerhitunganController; // Controller baru

// Guru Controllers
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\HasilCpiController as GuruHasilCpiController;
use App\Http\Controllers\Guru\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes (Role: admin only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Siswa Management
    Route::resource('siswa', AdminSiswaController::class);

    // Kriteria Management
    Route::resource('kriteria', KriteriaController::class);

    // Penilaian Management
    Route::resource('penilaian', PenilaianController::class);

    // Data Perhitungan Management (FITUR BARU)
    Route::prefix('perhitungan')->name('perhitungan.')->group(function () {
        Route::get('/', [PerhitunganController::class, 'index'])->name('index');
        Route::get('/siswa/{siswa}', [PerhitunganController::class, 'show'])->name('show');
        Route::get('/matrix', [PerhitunganController::class, 'matrix'])->name('matrix');
        Route::get('/normalisasi', [PerhitunganController::class, 'normalisasi'])->name('normalisasi');
    });

    // Hasil CPI Management
    Route::get('/hasil-cpi', [AdminHasilCpiController::class, 'index'])->name('hasil-cpi.index');
    Route::get('/hasil-cpi/{id}', [AdminHasilCpiController::class, 'show'])->name('hasil-cpi.show');

    // CPI Process Actions
    Route::post('/hitung-cpi', [AdminHasilCpiController::class, 'hitungCpi'])->name('hitung-cpi');
    Route::delete('/reset-hasil', [AdminHasilCpiController::class, 'resetHasil'])->name('reset-hasil');

    // Laporan
    Route::get('/cetak-hasil', [AdminHasilCpiController::class, 'cetakHasil'])->name('cetak-hasil');
});

// Guru Routes (Role: guru only)
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // Hasil CPI - Read Only
    Route::get('/hasil-cpi', [GuruHasilCpiController::class, 'index'])->name('hasil-cpi.index');
    Route::get('/hasil-cpi/{id}', [GuruHasilCpiController::class, 'show'])->name('hasil-cpi.show');

    // Laporan
    Route::get('/cetak-hasil', [GuruHasilCpiController::class, 'cetakHasil'])->name('cetak-hasil');

    // Profil Management
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});
