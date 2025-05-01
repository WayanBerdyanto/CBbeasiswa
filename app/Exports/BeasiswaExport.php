<?php

namespace App\Exports;

use App\Models\Beasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class BeasiswaExport
{
    protected $beasiswas;
    protected $jenisBeasiswa;

    public function __construct($beasiswas, $jenisBeasiswa = null)
    {
        $this->beasiswas = $beasiswas;
        $this->jenisBeasiswa = $jenisBeasiswa;
    }

    public function download($type)
    {
        $filename = 'laporan_beasiswa_';
        if ($this->jenisBeasiswa) {
            $filename .= strtolower(str_replace(' ', '_', $this->jenisBeasiswa->nama_jenis)) . '_';
        }
        $filename .= date('d-m-Y') . '.' . $type;

        return Excel::create($filename, function($excel) {
            $excel->sheet('Laporan Beasiswa', function($sheet) {
                $this->generateSheet($sheet);
            });

            $excel->getProperties()
                ->setCreator('CBScholarships System')
                ->setLastModifiedBy('CBScholarships System')
                ->setTitle('Laporan Data Beasiswa')
                ->setDescription('Laporan Data Beasiswa yang dihasilkan pada ' . date('d/m/Y H:i:s'));
        })->download($type);
    }

    public function generateSheet(LaravelExcelWorksheet $sheet)
    {
        // Add header row with styling
        $sheet->row(1, [
            'No.', 'Nama Beasiswa', 'Jenis Beasiswa', 'Deskripsi', 'Tanggal Dibuat'
        ]);

        $sheet->row(1, function($row) {
            $row->setBackground('#4e73df');
            $row->setFontColor('#ffffff');
            $row->setFontWeight('bold');
        });

        // Add data rows
        $row = 2;
        foreach($this->beasiswas as $index => $beasiswa) {
            $sheet->row($row, [
                $index + 1,
                $beasiswa->nama_beasiswa,
                $beasiswa->jenisBeasiswa ? $beasiswa->jenisBeasiswa->nama_jenis : 'N/A',
                $beasiswa->deskripsi,
                $beasiswa->created_at->format('d/m/Y')
            ]);
            
            $row++;
        }

        // Auto size columns
        $sheet->setAutoSize(true);
    }
} 