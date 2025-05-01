<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class MahasiswaExport
{
    protected $mahasiswas;

    public function __construct($mahasiswas)
    {
        $this->mahasiswas = $mahasiswas;
    }

    public function download($type)
    {
        $filename = 'laporan_mahasiswa_' . date('d-m-Y') . '.' . $type;

        return Excel::create($filename, function($excel) {
            $excel->sheet('Laporan Mahasiswa', function($sheet) {
                $this->generateSheet($sheet);
            });

            $excel->getProperties()
                ->setCreator('CBScholarships System')
                ->setLastModifiedBy('CBScholarships System')
                ->setTitle('Laporan Data Mahasiswa')
                ->setDescription('Laporan Data Mahasiswa yang dihasilkan pada ' . date('d/m/Y H:i:s'));
        })->download($type);
    }

    public function generateSheet(LaravelExcelWorksheet $sheet)
    {
        // Add title 
        $row = 1;
        $sheet->row($row++, ['LAPORAN DATA MAHASISWA']);
        $sheet->row($row++, ['Tanggal Laporan: ' . date('d/m/Y H:i:s')]);
        $sheet->row($row++, ['Total Mahasiswa: ' . count($this->mahasiswas)]);
        
        // Empty row
        $row++;
        
        // Add header row with styling
        $sheet->row($row, [
            'No.', 'NIM', 'Nama', 'Email', 'Program Studi', 'Jumlah Pengajuan', 'Status Terakhir'
        ]);

        $sheet->row($row, function($rowStyle) {
            $rowStyle->setBackground('#4e73df');
            $rowStyle->setFontColor('#ffffff');
            $rowStyle->setFontWeight('bold');
        });

        // Add data rows
        $row++;
        foreach($this->mahasiswas as $index => $mahasiswa) {
            // Get pengajuan count and latest status
            $jumlahPengajuan = 0;
            $statusTerakhir = 'N/A';
            
            if ($mahasiswa->pengajuan && $mahasiswa->pengajuan->count() > 0) {
                $jumlahPengajuan = $mahasiswa->pengajuan->count();
                $latestPengajuan = $mahasiswa->pengajuan->sortByDesc('created_at')->first();
                
                if ($latestPengajuan) {
                    switch($latestPengajuan->status_pengajuan) {
                        case 'diterima':
                            $statusTerakhir = 'Diterima';
                            break;
                        case 'ditolak':
                            $statusTerakhir = 'Ditolak';
                            break;
                        default:
                            $statusTerakhir = 'Diproses';
                            break;
                    }
                }
            }
            
            $sheet->row($row, [
                $index + 1,
                $mahasiswa->nim,
                $mahasiswa->nama,
                $mahasiswa->email,
                $mahasiswa->program_studi ?? 'N/A',
                $jumlahPengajuan,
                $statusTerakhir
            ]);
            
            // Style status cells
            if ($statusTerakhir == 'Diterima') {
                $sheet->cell('G' . $row, function($cell) {
                    $cell->setBackground('#1cc88a');
                    $cell->setFontColor('#ffffff');
                });
            } elseif ($statusTerakhir == 'Ditolak') {
                $sheet->cell('G' . $row, function($cell) {
                    $cell->setBackground('#e74a3b');
                    $cell->setFontColor('#ffffff');
                });
            } elseif ($statusTerakhir == 'Diproses') {
                $sheet->cell('G' . $row, function($cell) {
                    $cell->setBackground('#f6c23e');
                    $cell->setFontColor('#ffffff');
                });
            }
            
            $row++;
        }

        // Style the title
        $sheet->mergeCells('A1:G1');
        $sheet->cell('A1', function($cell) {
            $cell->setAlignment('center');
            $cell->setFontSize(16);
            $cell->setFontWeight('bold');
        });
        
        // Merge info cells
        for ($i = 2; $i <= 3; $i++) {
            $sheet->mergeCells('A' . $i . ':G' . $i);
        }
        
        // Auto size columns
        $sheet->setAutoSize(true);
    }
} 