<?php

namespace App\Exports;

use App\Models\Beasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class BeasiswaPdfExport
{
    protected $beasiswas;
    protected $jenisBeasiswa;

    public function __construct($beasiswas, $jenisBeasiswa = null)
    {
        $this->beasiswas = $beasiswas;
        $this->jenisBeasiswa = $jenisBeasiswa;
    }

    public function download()
    {
        $filename = 'laporan_beasiswa_';
        if ($this->jenisBeasiswa) {
            $filename .= strtolower(str_replace(' ', '_', $this->jenisBeasiswa->nama_jenis)) . '_';
        }
        $filename .= date('d-m-Y') . '.pdf';

        $data = [
            'title' => 'Laporan Data Beasiswa',
            'date' => date('d/m/Y H:i:s'),
            'beasiswas' => $this->beasiswas,
            'jenisBeasiswa' => $this->jenisBeasiswa,
            'count' => $this->beasiswas->count(),
        ];

        $pdf = PDF::loadView('pdf.beasiswa', $data);
        return $pdf->download($filename);
    }
} 