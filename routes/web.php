<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard - role-based routing via DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Role-based Dashboards
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->middleware('role:Admin')->name('admin.dashboard');
    Route::get('/guru/dashboard', [DashboardController::class, 'index'])->middleware('role:Guru BK')->name('guru.dashboard');
    Route::get('/siswa/dashboard', [DashboardController::class, 'index'])->middleware('role:Siswa')->name('siswa.dashboard');
    
    // Siswa Rekomendasi Routes
    Route::middleware('role:Siswa')->group(function () {
        Route::get('/siswa/rekomendasi/{id}', [\App\Http\Controllers\Siswa\RekomendasiController::class, 'detail'])->name('siswa.rekomendasi.detail');
        Route::post('/siswa/rekomendasi/pilih', [\App\Http\Controllers\Siswa\RekomendasiController::class, 'pilih'])->name('siswa.rekomendasi.pilih');
        Route::get('/siswa/beasiswa/{id}', [\App\Http\Controllers\Siswa\RekomendasiController::class, 'beasiswaDetail'])->name('siswa.beasiswa.detail');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::get('/admin/roles', [\App\Http\Controllers\Admin\RoleManagementController::class, 'index'])->name('admin.roles');
    Route::post('/admin/roles/assign', [\App\Http\Controllers\Admin\RoleManagementController::class, 'assignRole'])->name('admin.roles.assign');
    Route::get('/admin/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/export-excel', [\App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('admin.laporan.excel');
    Route::get('/admin/laporan/export-pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
    Route::resource('/admin/beasiswa', \App\Http\Controllers\Admin\BeasiswaController::class)->names('admin.beasiswa');
    Route::resource('/admin/kampus', \App\Http\Controllers\Admin\KampusController::class)->names('admin.kampus');
    Route::get('/admin/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna.index');
    Route::get('/admin/pengguna/create-guru', [\App\Http\Controllers\Admin\PenggunaController::class, 'createGuru'])->name('admin.pengguna.create.guru');
    Route::post('/admin/pengguna/create-guru', [\App\Http\Controllers\Admin\PenggunaController::class, 'storeGuru'])->name('admin.pengguna.store.guru');
    Route::get('/admin/pengguna/create-siswa', [\App\Http\Controllers\Admin\PenggunaController::class, 'createSiswa'])->name('admin.pengguna.create.siswa');
    Route::post('/admin/pengguna/create-siswa', [\App\Http\Controllers\Admin\PenggunaController::class, 'storeSiswa'])->name('admin.pengguna.store.siswa');
    Route::post('/admin/pengguna/{id}/reset', [\App\Http\Controllers\Admin\PenggunaController::class, 'resetPassword'])->name('admin.pengguna.reset');
    Route::delete('/admin/pengguna/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');

    // Admin Rekomendasi & Pendaftar Routes
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/rekomendasi', [\App\Http\Controllers\Admin\RekomendasiController::class, 'index'])->name('admin.rekomendasi.index');
        Route::get('/admin/rekomendasi/create', [\App\Http\Controllers\Admin\RekomendasiController::class, 'create'])->name('admin.rekomendasi.create');
        Route::get('/admin/rekomendasi/siswa/{id}', [\App\Http\Controllers\Admin\RekomendasiController::class, 'siswaDetails'])->name('admin.rekomendasi.siswa-details');
        Route::post('/admin/rekomendasi', [\App\Http\Controllers\Admin\RekomendasiController::class, 'store'])->name('admin.rekomendasi.store');
        Route::delete('/admin/rekomendasi/{id}', [\App\Http\Controllers\Admin\RekomendasiController::class, 'destroy'])->name('admin.rekomendasi.destroy');

        Route::get('/admin/pendaftar', [\App\Http\Controllers\Admin\PendaftarController::class, 'index'])->name('admin.pendaftar.index');
        Route::get('/admin/pendaftar/{beasiswaId}', [\App\Http\Controllers\Admin\PendaftarController::class, 'show'])->name('admin.pendaftar.show');
        Route::get('/admin/pendaftar/{beasiswaId}/export-excel', [\App\Http\Controllers\Admin\PendaftarController::class, 'exportExcel'])->name('admin.pendaftar.excel');
        Route::get('/admin/pendaftar/{beasiswaId}/export-pdf', [\App\Http\Controllers\Admin\PendaftarController::class, 'exportPdf'])->name('admin.pendaftar.pdf');
    });

    // Guru BK Routes
    Route::get('/guru/siswa', [\App\Http\Controllers\Guru\SiswaController::class, 'index'])->middleware('role:Guru BK')->name('guru.siswa.index');
    Route::get('/guru/siswa/create', [\App\Http\Controllers\Guru\InputSiswaController::class, 'create'])->middleware('role:Guru BK')->name('guru.siswa.create');
    Route::post('/guru/siswa/create', [\App\Http\Controllers\Guru\InputSiswaController::class, 'store'])->middleware('role:Guru BK')->name('guru.siswa.create.store');
    Route::get('/guru/siswa/{id}/proses', [\App\Http\Controllers\Guru\InputSiswaController::class, 'proses'])->middleware('role:Guru BK')->name('guru.siswa.proses');
    Route::post('/guru/siswa/proses-store', [\App\Http\Controllers\Guru\InputSiswaController::class, 'storeProses'])->middleware('role:Guru BK')->name('guru.siswa.proses.store');
    Route::get('/guru/siswa/{id}/edit', [\App\Http\Controllers\Guru\SiswaController::class, 'edit'])->middleware('role:Guru BK')->name('guru.siswa.edit');
    Route::put('/guru/siswa/{id}', [\App\Http\Controllers\Guru\SiswaController::class, 'update'])->middleware('role:Guru BK')->name('guru.siswa.update');
    Route::delete('/guru/siswa/{id}', [\App\Http\Controllers\Guru\SiswaController::class, 'destroy'])->middleware('role:Guru BK')->name('guru.siswa.destroy');
});

require __DIR__.'/auth.php';
