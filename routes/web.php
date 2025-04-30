<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminBeasiswaController;
use App\Http\Controllers\Admin\AdminSyaratBeasiswaController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\SyaratController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminPengajuanController;
use App\Http\Controllers\Admin\AdminLaporanController;


Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');



// ------------------- AUTH MAHASISWA -------------------
Route::middleware(['auth:mahasiswa'])->group(function () {
    // Menampilkan daftar syarat dari semua beasiswa (dengan tombol ajukan)
    Route::get('/syarat-beasiswa', [PengajuanController::class, 'syaratBeasiswa'])->name('pengajuan.syarat');

    // Form pengajuan beasiswa
    Route::get('/pengajuan/{id}', [PengajuanController::class, 'form'])->name('pengajuan.form');

    // Simpan pengajuan beasiswa
    Route::post('/pengajuan/simpan', [PengajuanController::class, 'simpanPengajuan'])->name('pengajuan.simpan');
});

// Halaman daftar pengajuan (umum)
Route::get('/pengajuan', [PengajuanController::class, 'daftar'])->name('pengajuan.index');

// Hapus pengajuan
Route::delete('/pengajuan/{id}', [PengajuanController::class, 'hapus'])->name('pengajuan.hapus');

// ------------------- BEASISWA DAN SYARAT -------------------
Route::get('/beasiswa', [BeasiswaController::class, 'index'])->name('beasiswa.index');

// Menampilkan syarat berdasarkan ID beasiswa tertentu
Route::get('/beasiswa/{id}/syarat', [SyaratController::class, 'index'])->name('syarat.index');

// ------------------- AUTH -------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/regis', [AuthController::class, 'showRegisForm'])->name('regis');
Route::post('/regis', [AuthController::class, 'register']);

// ------------------- HOME (SETELAH LOGIN) -------------------
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// ------------------- DEFAULT -------------------
Route::get('/', function () {
    return view('welcome');
});

// admin login
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

// admin dashboard
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Beasiswa management
        Route::resource('beasiswa', AdminBeasiswaController::class);

        // Syarat management
        Route::resource('syarat', AdminSyaratBeasiswaController::class);

        // Pengajuan filter (pindahkan ke atas route dengan parameter dinamis)
        Route::get('pengajuan/filter', [AdminPengajuanController::class, 'filter'])->name('pengajuan.filter');

        // Pengajuan management
        Route::get('pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');

        // Penting: Route "create" harus sebelum route dengan parameter dinamis {id}
        // Pengajuan create
        Route::get('pengajuan/create', [AdminPengajuanController::class, 'create'])->name('pengajuan.create');

        // Pengajuan edit (pindahkan di atas route detail)
        Route::get('pengajuan/edit/{id}', [AdminPengajuanController::class, 'edit'])->name('pengajuan.edit');

        // Pengajuan detail - pindahkan setelah semua route spesifik
        Route::get('pengajuan/{id}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');

        // Pengajuan store
        Route::post('pengajuan', [AdminPengajuanController::class, 'store'])->name('pengajuan.store');

        // Pengajuan update
        Route::put('pengajuan/update/{id}', [AdminPengajuanController::class, 'update'])->name('pengajuan.update');

        // Update status pengajuan
        Route::patch('pengajuan/status/{id}', [AdminPengajuanController::class, 'updateStatus'])->name('pengajuan.status');

        // Pengajuan destroy
        Route::delete('pengajuan/{id}', [AdminPengajuanController::class, 'destroy'])->name('pengajuan.destroy');

        // Reporting
        Route::get('laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/export', [AdminLaporanController::class, 'export'])->name('laporan.export');
    });


    // admin logout
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
