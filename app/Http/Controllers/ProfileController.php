<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class ProfileController extends Controller
{
    public function show()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.profile', compact('mahasiswa'));
    }

    public function edit()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.formUpdate', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('mahasiswa')->user();
        
        // Validasi input
        $request->validate([
            'ipk_terakhir' => 'required|numeric|min:0|max:4',
            'angkatan' => 'required|numeric',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'semester' => 'required',
        ]);
        
        // Debugging IPK
        \Illuminate\Support\Facades\Log::info('Update profile mahasiswa', [
            'id_mahasiswa' => $user->id,
            'old_ipk' => $user->ipk_terakhir,
            'new_ipk' => $request->ipk_terakhir
        ]);
        
        // Update data mahasiswa
        Mahasiswa::where('id', $user->id)->update([
            'angkatan' => $request->angkatan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'ipk_terakhir' => $request->ipk_terakhir,
            'semester' => $request->semester,
        ]);
        
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.edit-password', compact('mahasiswa'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('mahasiswa')->user();
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Update password
        Mahasiswa::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    }
}
