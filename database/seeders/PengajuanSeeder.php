<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengajuan;
use App\Models\Mahasiswa;
use App\Models\PeriodeBeasiswa;
use App\Models\Beasiswa;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Get all available data
        $mahasiswas = Mahasiswa::all();
        $periodes = PeriodeBeasiswa::all();
        
        // Application reasons for realistic data
        $alasanPengajuan = [
            'Saya mengalami kesulitan ekonomi untuk melanjutkan perkuliahan',
            'Biaya pendidikan yang semakin meningkat dan pendapatan orang tua yang terbatas',
            'Untuk meringankan beban biaya pendidikan',
            'Saya ingin fokus pada studi tanpa harus mencari pekerjaan sampingan',
            'Orang tua saya baru saja kehilangan pekerjaan',
            'Beasiswa ini akan sangat membantu saya mencapai cita-cita akademik',
            'Saya memiliki prestasi akademik yang baik dan ingin mendapatkan dukungan finansial',
            'Untuk mendukung penelitian dan kegiatan akademik saya',
            'Saya berasal dari keluarga kurang mampu tetapi memiliki semangat belajar tinggi',
            'Untuk membantu biaya hidup selama kuliah',
        ];
        
        // Status applications mapped to database enum values
        $statuses = [
            'pending' => 'diproses',
            'approved' => 'diterima',
            'rejected' => 'ditolak'
        ];
        
        // Current date
        $now = Carbon::now();
        
        // For each period, create several applications
        foreach ($periodes as $periode) {
            // Get related beasiswa
            $beasiswa = Beasiswa::find($periode->id_beasiswa);
            
            // Get start and end date of period
            $startDate = Carbon::parse($periode->tanggal_mulai);
            $endDate = Carbon::parse($periode->tanggal_selesai);
            
            // Skip if dates are invalid
            if ($startDate->gt($endDate)) {
                continue;
            }
            
            // For completed periods, create more applications with finalized status
            if ($periode->status === 'tidak_aktif') {
                // For inactive periods that are in the past, create applications
                if ($endDate->isPast()) {
                    // Use a safe end date (either the actual end date or today, whichever is earlier)
                    $safeEndDate = $endDate->gt($now) ? $now : $endDate;
                    
                    $this->createApplications(
                        $faker, $mahasiswas, $periode, $beasiswa, 
                        $startDate, $safeEndDate, $alasanPengajuan, 
                        $statuses, 
                        ['approved', 'rejected'], 
                        15, 25, 0.7); // 70% approval rate
                }
            }
            // For active periods, create fewer applications with more pending
            else if ($periode->status === 'aktif') {
                // Only create applications if start date is in the past
                if ($startDate->isPast()) {
                    // Use a safe end date (today)
                    $safeEndDate = $now;
                    
                    $this->createApplications(
                        $faker, $mahasiswas, $periode, $beasiswa, 
                        $startDate, $safeEndDate, $alasanPengajuan, 
                        $statuses,
                        ['pending', 'approved', 'rejected'], 
                        10, 20, 0.3); // 30% processed, mostly pending
                }
            }
            // For upcoming periods, don't create applications
        }
    }
    
    /**
     * Helper function to create applications
     */
    private function createApplications($faker, $mahasiswas, $periode, $beasiswa, $startDate, $endDate, $alasanSet, $statusMapping, $allowedStatuses, $minCount, $maxCount, $approvalRate)
    {
        // Make sure start date is before end date
        if ($startDate->gt($endDate)) {
            return;
        }
        
        // Get valid semester requirements from period
        $validSemesters = explode(',', $periode->semester_syarat);
        
        // Filter students who meet semester requirement
        $eligibleStudents = $mahasiswas->filter(function($student) use ($validSemesters) {
            return in_array($student->semester, $validSemesters);
        });
        
        // If no eligible students, return
        if ($eligibleStudents->isEmpty()) {
            return;
        }
        
        // Determine how many applications to create
        $count = rand($minCount, $maxCount);
        
        // Create applications
        for ($i = 0; $i < $count; $i++) {
            // Get random student from eligible pool
            $student = $eligibleStudents->random();
            
            // Determine application date within period timeframe
            $applicationDate = $faker->dateTimeBetween(
                $startDate->format('Y-m-d'), 
                $endDate->format('Y-m-d')
            );
            
            // Determine status with weighted probability
            $rand = mt_rand(1, 100) / 100;
            if (in_array('pending', $allowedStatuses) && $rand > 0.7) {
                $internalStatus = 'pending';
                $nominalApproved = null;
            } else if (in_array('approved', $allowedStatuses) && $rand <= $approvalRate) {
                $internalStatus = 'approved';
                // Sometimes give partial scholarship (80-100% of original)
                $percentage = $faker->randomFloat(2, 0.8, 1);
                $nominalApproved = round($beasiswa->nominal * $percentage, -3); // Round to nearest thousand
            } else {
                $internalStatus = 'rejected';
                $nominalApproved = null;
            }
            
            // Convert internal status to database enum value
            $dbStatus = $statusMapping[$internalStatus];
            
            // Create the application
            Pengajuan::create([
                'id_beasiswa' => $beasiswa->id_beasiswa,
                'id_mahasiswa' => $student->id,
                'id_periode' => $periode->id_periode,
                'status_pengajuan' => $dbStatus,
                'nominal_approved' => $nominalApproved,
                'tgl_pengajuan' => $applicationDate,
                'alasan_pengajuan' => $faker->randomElement($alasanSet),
                'ipk' => $student->ipk_terakhir,
            ]);
            
            // If approved, update student's total received scholarship
            if ($internalStatus === 'approved' && $nominalApproved) {
                $student->total_received_scholarship = ($student->total_received_scholarship ?? 0) + $nominalApproved;
                $student->save();
            }
        }
    }
} 