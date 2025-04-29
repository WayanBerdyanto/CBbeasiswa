<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\SyaratController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;



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

Route::get('/regis', [LoginController::class, 'showRegisForm'])->name('regis');
Route::post('/regis', [LoginController::class, 'register']);

// ------------------- HOME (SETELAH LOGIN) -------------------
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// ------------------- DEFAULT -------------------
Route::get('/', function () {
    return view('welcome');
});
