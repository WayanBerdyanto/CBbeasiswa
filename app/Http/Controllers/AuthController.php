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
        // Redirect if already logged in
        if (Auth::guard('mahasiswa')->check()) {
            return redirect()->route('mahasiswa.dashboard');
        }
        
        // Mengarahkan ke resources/views/auth/regis.blade.php
        return view('auth.regis');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:35',
            'nim' => 'required|string|size:8|unique:mahasiswa',
            'jurusan' => 'required|string|max:35',
            'gender' => 'required|numeric',
            'angkatan' => 'required|string|max:25',
            'syarat_lpk' => 'required|numeric',
            'email' => 'required|email|max:25|unique:mahasiswa',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            $mahasiswa = Mahasiswa::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'jurusan' => $request->jurusan,
                'gender' => $request->gender,
                'angkatan' => $request->angkatan,
                'syarat_lpk' => $request->syarat_lpk,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            Auth::guard('mahasiswa')->login($mahasiswa);
            
            return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage());
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        try {
            Auth::guard('mahasiswa')->logout();
            return redirect('/login')->with('success', 'Logout berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat logout: ' . $e->getMessage());
        }
    }
}
