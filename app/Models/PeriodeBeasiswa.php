<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'periode_beasiswa';
    protected $primaryKey = 'id_periode';
    protected $fillable = [
        'id_beasiswa',
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'kuota'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'id_beasiswa', 'id_beasiswa');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_periode', 'id_periode');
    }
} 