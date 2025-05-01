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
        'email',
        'password',
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
}
