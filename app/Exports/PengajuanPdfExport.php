<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class PengajuanPdfExport
{
    protected $pengajuans;
    protected $jenisBeasiswa;
    protected $tanggalMulai;
    protected $tanggalSelesai;

    public function __construct($pengajuans, $jenisBeasiswa = null, $tanggalMulai = null, $tanggalSelesai = null)
    {
        $this->pengajuans = $pengajuans;
        $this->jenisBeasiswa = $jenisBeasiswa;
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalSelesai = $tanggalSelesai;
    }

    public function download()
    {
        $filename = 'laporan_pengajuan_';
        if ($this->jenisBeasiswa) {
            $filename .= strtolower(str_replace(' ', '_', $this->jenisBeasiswa->nama_jenis)) . '_';
        }
        $filename .= date('d-m-Y') . '.pdf';

        $tanggalPeriode = null;
        if ($this->tanggalMulai) {
            $tanggalPeriode = date('d/m/Y', strtotime($this->tanggalMulai));
            if ($this->tanggalSelesai) {
                $tanggalPeriode .= ' - ' . date('d/m/Y', strtotime($this->tanggalSelesai));
            }
        }

        $data = [
            'title' => 'Laporan Data Pengajuan Beasiswa',
            'date' => date('d/m/Y H:i:s'),
            'pengajuans' => $this->pengajuans,
            'jenisBeasiswa' => $this->jenisBeasiswa,
            'tanggalPeriode' => $tanggalPeriode,
            'count' => $this->pengajuans->count(),
        ];

        $pdf = PDF::loadView('pdf.pengajuan', $data);
        return $pdf->download($filename);
    }
} 