<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';
    protected $casts = [
        'tgl_pengajuan' => 'datetime',
    ];
    
    protected $fillable = [
        'id_beasiswa',
        'id_mahasiswa',
        'status_pengajuan',
        'tgl_pengajuan',
        'alasan_pengajuan',
    ];

    // Relasi ke tabel beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'id_beasiswa', 'id_beasiswa');
    }

    // Relasi ke tabel mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}
