<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class MahasiswaPdfExport
{
    protected $mahasiswas;

    public function __construct($mahasiswas)
    {
        $this->mahasiswas = $mahasiswas;
    }

    public function download()
    {
        $filename = 'laporan_mahasiswa_' . date('d-m-Y') . '.pdf';

        $data = [
            'title' => 'Laporan Data Mahasiswa',
            'date' => date('d/m/Y H:i:s'),
            'mahasiswas' => $this->mahasiswas,
            'count' => $this->mahasiswas->count(),
        ];

        $pdf = PDF::loadView('pdf.mahasiswa', $data);
        return $pdf->download($filename);
    }
} 