<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use Notifiable;
    // Define table name explicitly
    protected $table = 'mahasiswa';

    // Define fillable fields based on the migrations
    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'fakultas',
        'gender',
        'angkatan',
        'no_hp',
        'alamat',
        'ipk_terakhir',
        'total_received_scholarship',
        'email',
        'password',
        'semester',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    // Define relationships
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_mahasiswa', 'id');
    }
    
    // Cek apakah mahasiswa memenuhi syarat untuk beasiswa tertentu
    public function memenuhi_syarat(Beasiswa $beasiswa)
    {
        $syarat_terpenuhi = true;
        $message = '';
        
        // Cek syarat IPK
        $syaratIpk = Syarat::where('id_beasiswa', $beasiswa->id_beasiswa)
                         ->where('nama_syarat', 'IPK Minimal')
                         ->first();
        
        if ($syaratIpk && $this->ipk_terakhir < $syaratIpk->keterangan) {
            $syarat_terpenuhi = false;
            $message = 'IPK Anda ('.$this->ipk_terakhir.') tidak memenuhi syarat minimal ('.$syaratIpk->keterangan.')';
        }
        
        return [
            'memenuhi' => $syarat_terpenuhi,
            'pesan' => $message
        ];
    }
}
