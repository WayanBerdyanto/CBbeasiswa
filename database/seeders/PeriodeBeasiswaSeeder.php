<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodeBeasiswa;
use App\Models\Beasiswa;
use Carbon\Carbon;

class PeriodeBeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all beasiswa to create periods for them
        $beasiswas = Beasiswa::all();

        // Current year and previous year
        $currentYear = Carbon::now()->year;
        $previousYear = $currentYear - 1;
        
        foreach ($beasiswas as $beasiswa) {
            // Create previous periods (completed)
            $this->createPeriod(
                $beasiswa->id_beasiswa, 
                "Periode $previousYear Ganjil", 
                'ganjil',
                [1, 3, 5, 7], 
                Carbon::create($previousYear, 7, 1), 
                Carbon::create($previousYear, 8, 30), 
                'tidak_aktif',
                rand(20, 50)
            );
            
            $this->createPeriod(
                $beasiswa->id_beasiswa, 
                "Periode $previousYear Genap", 
                'genap',
                [2, 4, 6, 8], 
                Carbon::create($previousYear, 12, 1), 
                Carbon::create($previousYear + 1, 1, 31), 
                'tidak_aktif',
                rand(20, 50)
            );
            
            // Create current active periods
            $this->createPeriod(
                $beasiswa->id_beasiswa, 
                "Periode $currentYear Ganjil", 
                'ganjil',
                [1, 3, 5, 7], 
                Carbon::create($currentYear, 7, 1), 
                Carbon::create($currentYear, 8, 30), 
                'aktif',
                rand(20, 50)
            );
            
            // Create upcoming period (not active yet)
            $this->createPeriod(
                $beasiswa->id_beasiswa, 
                "Periode $currentYear Genap", 
                'genap',
                [2, 4, 6, 8], 
                Carbon::create($currentYear, 12, 1), 
                Carbon::create($currentYear + 1, 1, 31), 
                'tidak_aktif',
                rand(20, 50)
            );
        }
    }
    
    /**
     * Helper function to create period
     */
    private function createPeriod($beasiswaId, $nama, $tipeSemester, $semesterSyarat, $tanggalMulai, $tanggalSelesai, $status, $kuota)
    {
        // Convert semester array to comma-separated string
        $semesterString = implode(',', $semesterSyarat);
        
        PeriodeBeasiswa::create([
            'id_beasiswa' => $beasiswaId,
            'nama_periode' => $nama,
            'tipe_semester' => $tipeSemester,
            'semester_syarat' => $semesterString,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'status' => $status,
            'kuota' => $kuota
        ]);
    }
} 