<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        // Redirect if already logged in
        if (Auth::guard('mahasiswa')->check()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        // Menyesuaikan ke file: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (Auth::guard('mahasiswa')->attempt($credentials)) {
                return redirect()->route('mahasiswa.dashboard')->with('success', 'Login berhasil!');
            }

            return back()->with('error', 'Email atau password salah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    // Menampilkan form registrasi
    public function showRegisForm()
    {
        // Jurusan
        // $jurusan = [
        //     'Teknik Informatika',
        //     'Sistem Informasi',
        //     'Desain Komunikasi Visual',
        //     'Arsitektur',
        //     'Manajemen',
        //     'Akuntansi',
        //     'Bioteknologi',
        //     'Ilmu Hukum',
        //     'Psikologi',
        //     'Pendidikan Agama Kristen',
        // ];

        // $fakultas = [
        //     'Fakultas Teologi',
        //     'Fakultas Arsitektur dan Desain',
        //     'Fakultas Bioteknologi',
        //     'Fakultas Bisnis',
        //     'Fakultas Teknologi Informasi',
        //     'Fakultas Kedokteran',
        //     'Fakultas Kependidikan dan Humaniora',
        // ];

        $grupJurusan = [
            'Fakultas Teologi' => ['Filsafat Keilahian'],
            'Fakultas Arsitektur dan Desain' => ['Arsitektur', 'Desain Produk'],
            'Fakultas Bioteknologi' => ['Bilogi'],
            'Fakultas Bisnis' => ['Manajemen', 'Akuntansi'],
            'Fakultas Teknologi Informasi' => ['Informatika', 'Sistem Informasi'],
            'Fakultas Kedokteran' => ['Kedokteran', 'Profesi Dokter'],
            'Fakultas Kependidikan dan Humaniora' => ['Pendidikan Bahasa Inggris', 'Studi Humanitas'],
        ];

        // Redirect if already logged in
        if (Auth::guard('mahasiswa')->check()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        // Mengarahkan ke resources/views/auth/regis.blade.php
        return view('auth.regis', compact('grupJurusan'));
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:35',
            'nim' => 'required|string|size:8|unique:mahasiswa',
            'fakultas' => 'required|string|max:35',
            'jurusan' => 'required|string|max:35',
            'gender' => 'required|numeric',
            'angkatan' => 'required|string|max:25',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'ipk_terakhir' => 'nullable|numeric|min:0|max:4.00',
            'semester' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $email = $request->nim . '@students.ukdw.ac.id';

            $mahasiswa = Mahasiswa::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'fakultas' => $request->fakultas,
                'jurusan' => $request->jurusan,
                'gender' => $request->gender == 1 ? 'Laki-laki' : 'Perempuan',
                'angkatan' => $request->angkatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'ipk_terakhir' => $request->ipk_terakhir ?? 0.00,
                'email' => $email,
                'password' => bcrypt($request->password),
                'semester' => $request->semester
             ]);

            Auth::guard('mahasiswa')->login($mahasiswa);

            return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage());
        }
    }

    // Proses logout
    public function logout()
    {
        try {
            Auth::guard('mahasiswa')->logout();
            return redirect('/login')->with('success', 'Logout berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat logout: ' . $e->getMessage());
        }
    }
}
