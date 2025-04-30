<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        // Mengarahkan ke resources/views/auth/login.blade.php
        return view('auth.login');
    }


    // Proses login (sementara hardcoded)
    public function login(Request $request)
    {
        // Validasi data login
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek login (sementara masih hardcoded untuk contoh)
        if ($validated['email'] === 'user@example.com' && $validated['password'] === 'password123') {
            return redirect()->route('home');
        }

        // Jika login gagal
        return back()->withErrors(['login' => 'Email atau password tidak sesuai.']);
    }
    public function logout(Request $request)
    {
        $request->session()->forget('mahasiswa');
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
    
}
