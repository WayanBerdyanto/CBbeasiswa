<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminBeasiswaController;
use App\Http\Controllers\Admin\AdminSyaratBeasiswaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PeriodeBeasiswaController;
use App\Http\Controllers\Admin\AdminDokumenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\SyaratController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Admin\AdminPengajuanController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Admin\AdminMahasiswaController;
use App\Http\Controllers\Admin\AdminJenisBeasiswaController;
use App\Http\Controllers\Admin\AdminSyaratController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\AdminPengajuanNominalController;

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');



// ------------------- AUTH MAHASISWA -------------------
Route::middleware(['auth:mahasiswa'])->group(function () {
    // Mahasiswa Dashboard
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    
    // Menampilkan daftar syarat dari semua beasiswa (dengan tombol ajukan)
    Route::get('/syarat-beasiswa', [PengajuanController::class, 'syaratBeasiswa'])->name('pengajuan.syarat');

    // Form pengajuan beasiswa
    Route::get('/pengajuan/{id}', [PengajuanController::class, 'form'])->name('pengajuan.form');

    // Simpan pengajuan beasiswa
    Route::post('/pengajuan/simpan', [PengajuanController::class, 'simpanPengajuan'])->name('pengajuan.simpan');
    
    // Edit pengajuan beasiswa
    Route::get('/pengajuan/{id}/edit', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}/update', [PengajuanController::class, 'update'])->name('pengajuan.update');

    // Dokumen routes
    Route::get('/dokumen/create/{pengajuanId}', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}', [DokumenController::class, 'show'])->name('dokumen.show');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    
    // Halaman daftar pengajuan (hanya untuk mahasiswa yang sudah login)
    Route::get('/pengajuan', [PengajuanController::class, 'daftar'])->name('pengajuan.index');
    
    // Detail pengajuan beasiswa
    Route::get('/pengajuan/{id}/detail', [PengajuanController::class, 'detail'])->name('pengajuan.detail');
    
    // Hapus pengajuan
    Route::delete('/pengajuan/{id}', [PengajuanController::class, 'hapus'])->name('pengajuan.hapus');

    // Student report routes
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export-pdf', [ReportController::class, 'exportPdf'])->name('report.export.pdf');
    Route::get('/report/view-pdf', [ReportController::class, 'viewPdf'])->name('report.view.pdf');
    Route::get('/report/pengajuan/{id}', [ReportController::class, 'detailPengajuan'])->name('report.pengajuan.detail');

    // Update profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Update password
    Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
    Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
});

// ------------------- BEASISWA DAN SYARAT (Publik) -------------------
Route::get('/beasiswa', [BeasiswaController::class, 'index'])->name('beasiswa.index');

// Menampilkan syarat berdasarkan ID beasiswa tertentu
Route::get('/beasiswa/{id}/syarat', [SyaratController::class, 'index'])->name('syarat.index');

// ------------------- AUTH -------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/regis', [AuthController::class, 'showRegisForm'])->name('regis');
Route::post('/regis', [AuthController::class, 'register']);

// ------------------- DEFAULT -------------------
Route::get('/', function () {
    return view('welcome');
});

// Redirect from /home to dashboard
Route::get('/home', function() {
    if(Auth::guard('mahasiswa')->check()) {
        return redirect()->route('mahasiswa.dashboard');
    } else if(Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('login');
    }
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

        // Periode Beasiswa management
        Route::resource('periode', PeriodeBeasiswaController::class);
        Route::patch('periode/{id}/toggle-status', [PeriodeBeasiswaController::class, 'toggleStatus'])->name('periode.toggle-status');

        // Mahasiswa management
        Route::resource('mahasiswa', AdminMahasiswaController::class);

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
        
        // View PDF in browser
        Route::get('pengajuan/{id}/pdf', [AdminPengajuanController::class, 'viewPdf'])->name('pengajuan.pdf');

        // Pengajuan store
        Route::post('pengajuan', [AdminPengajuanController::class, 'store'])->name('pengajuan.store');

        // Pengajuan update
        Route::put('pengajuan/update/{id}', [AdminPengajuanController::class, 'update'])->name('pengajuan.update');

        // Update status pengajuan
        Route::patch('pengajuan/status/{id}', [AdminPengajuanController::class, 'updateStatus'])->name('pengajuan.status');

        // Pengajuan destroy
        Route::delete('pengajuan/{id}', [AdminPengajuanController::class, 'destroy'])->name('pengajuan.destroy');

        // Reporting
        Route::get('laporan/export', [AdminLaporanController::class, 'export'])->name('laporan.export');
        Route::resource('laporan', AdminLaporanController::class);
        
        // Route resource
        Route::resource('jenis-beasiswa', AdminJenisBeasiswaController::class);
        Route::resource('pengajuan', AdminPengajuanController::class);
        // Route::resource('syarat', AdminSyaratController::class);

        // Admin dokumen verification
        Route::patch('dokumen/{id}/verifikasi', [AdminDokumenController::class, 'verifikasi'])->name('dokumen.verifikasi');
        
        // Admin document routes
        Route::get('dokumen/create/{pengajuanId}', [AdminDokumenController::class, 'create'])->name('dokumen.create');
        Route::post('dokumen', [AdminDokumenController::class, 'store'])->name('dokumen.store');
        Route::get('dokumen/{id}', [AdminDokumenController::class, 'show'])->name('dokumen.show');
        Route::get('dokumen/{id}/edit', [AdminDokumenController::class, 'edit'])->name('dokumen.edit');
        Route::get('dokumen/{id}/verifikasi', [AdminDokumenController::class, 'verifikasiForm'])->name('dokumen.verifikasi.form');
        Route::patch('dokumen/{id}/verifikasi', [AdminDokumenController::class, 'verifikasi'])->name('dokumen.verifikasi');
        Route::put('dokumen/{id}', [AdminDokumenController::class, 'update'])->name('dokumen.update');
        Route::delete('dokumen/{id}', [AdminDokumenController::class, 'destroy'])->name('dokumen.destroy');
        Route::get('dokumen/{id}/download', [AdminDokumenController::class, 'download'])->name('dokumen.download');

        // Pengajuan Nominal routes
        Route::get('pengajuan/{id}/nominal', [AdminPengajuanNominalController::class, 'edit'])->name('pengajuan.nominal.edit');
        Route::put('pengajuan/{id}/nominal', [AdminPengajuanNominalController::class, 'update'])->name('pengajuan.nominal.update');
        Route::get('pengajuan/{id}/nominal/default', [AdminPengajuanNominalController::class, 'setDefault'])->name('pengajuan.nominal.default');
    });


    // admin logout
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dokumen/{id}/pdf', [DokumenController::class, 'generatePdf'])->name('dokumen.pdf');
    Route::get('dokumen/{id}/view', [DokumenController::class, 'pdf'])->name('dokumen.view');
});
