<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class PengajuanExport
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

    public function download($type)
    {
        $filename = 'laporan_pengajuan_';
        if ($this->jenisBeasiswa) {
            $filename .= strtolower(str_replace(' ', '_', $this->jenisBeasiswa->nama_jenis)) . '_';
        }
        $filename .= date('d-m-Y') . '.' . $type;

        return Excel::create($filename, function($excel) {
            $excel->sheet('Laporan Pengajuan', function($sheet) {
                $this->generateSheet($sheet);
            });

            $excel->getProperties()
                ->setCreator('CBScholarships System')
                ->setLastModifiedBy('CBScholarships System')
                ->setTitle('Laporan Data Pengajuan Beasiswa')
                ->setDescription('Laporan Data Pengajuan Beasiswa yang dihasilkan pada ' . date('d/m/Y H:i:s'));
        })->download($type);
    }

    public function generateSheet(LaravelExcelWorksheet $sheet)
    {
        // Add title and filter info
        $row = 1;

        $sheet->row($row++, ['LAPORAN DATA PENGAJUAN BEASISWA']);
        $sheet->row($row++, ['Tanggal Laporan: ' . date('d/m/Y H:i:s')]);
        
        if ($this->jenisBeasiswa) {
            $sheet->row($row++, ['Jenis Beasiswa: ' . $this->jenisBeasiswa->nama_jenis]);
        }
        
        if ($this->tanggalMulai) {
            $periode = 'Periode: ' . date('d/m/Y', strtotime($this->tanggalMulai));
            if ($this->tanggalSelesai) {
                $periode .= ' - ' . date('d/m/Y', strtotime($this->tanggalSelesai));
            }
            $sheet->row($row++, [$periode]);
        }
        
        $sheet->row($row++, ['Total Data: ' . count($this->pengajuans)]);
        
        // Empty row
        $row++;
        
        // Add header row with styling
        $sheet->row($row, [
            'No.', 'Tanggal Pengajuan', 'NIM', 'Nama Mahasiswa', 'Beasiswa', 'Jenis Beasiswa', 'Nominal', 'Status'
        ]);

        $sheet->row($row, function($rowStyle) {
            $rowStyle->setBackground('#4e73df');
            $rowStyle->setFontColor('#ffffff');
            $rowStyle->setFontWeight('bold');
        });

        // Add data rows
        $row++;
        foreach($this->pengajuans as $index => $pengajuan) {
            $status = '';
            switch($pengajuan->status_pengajuan) {
                case 'diterima':
                    $status = 'Diterima';
                    break;
                case 'ditolak':
                    $status = 'Ditolak';
                    break;
                default:
                    $status = 'Diproses';
                    break;
            }
            
            $sheet->row($row, [
                $index + 1,
                $pengajuan->created_at->format('d/m/Y'),
                $pengajuan->mahasiswa ? $pengajuan->mahasiswa->nim : 'N/A',
                $pengajuan->mahasiswa ? $pengajuan->mahasiswa->nama : 'N/A',
                $pengajuan->beasiswa ? $pengajuan->beasiswa->nama_beasiswa : 'N/A',
                $pengajuan->beasiswa && $pengajuan->beasiswa->jenisBeasiswa ? $pengajuan->beasiswa->jenisBeasiswa->nama_jenis : 'N/A',
                $pengajuan->nominal_approved ? 'Rp ' . number_format($pengajuan->nominal_approved, 0, ',', '.') : 'N/A',
                $status
            ]);
            
            // Style status cells
            if ($status == 'Diterima') {
                $sheet->cell('H' . $row, function($cell) {
                    $cell->setBackground('#1cc88a');
                    $cell->setFontColor('#ffffff');
                });
            } elseif ($status == 'Ditolak') {
                $sheet->cell('H' . $row, function($cell) {
                    $cell->setBackground('#e74a3b');
                    $cell->setFontColor('#ffffff');
                });
            } else {
                $sheet->cell('H' . $row, function($cell) {
                    $cell->setBackground('#f6c23e');
                    $cell->setFontColor('#ffffff');
                });
            }
            
            $row++;
        }

        // Style the title
        $sheet->mergeCells('A1:H1');
        $sheet->cell('A1', function($cell) {
            $cell->setAlignment('center');
            $cell->setFontSize(16);
            $cell->setFontWeight('bold');
        });
        
        // Merge filter info cells
        for ($i = 2; $i <= 5; $i++) {
            $sheet->mergeCells('A' . $i . ':H' . $i);
        }
        
        // Auto size columns
        $sheet->setAutoSize(true);
    }
} 