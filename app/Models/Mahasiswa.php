<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

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

    // Define relationships
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_mahasiswa', 'id');
    }
}
