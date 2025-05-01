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
        'id_periode',
        'status_pengajuan',
        'tgl_pengajuan',
        'alasan_pengajuan',
        'ipk',
    ];

    // Relasi ke tabel beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'id_beasiswa', 'id_beasiswa');
    }

    // Relasi ke tabel mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id');
    }

    // Relasi ke tabel periode beasiswa
    public function periode()
    {
        return $this->belongsTo(PeriodeBeasiswa::class, 'id_periode', 'id_periode');
    }
}
