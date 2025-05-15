<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokumen;
use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\Syarat;
use Faker\Factory as Faker;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Get all applications
        $pengajuans = Pengajuan::all();
        
        // For each application, create the required documents
        foreach ($pengajuans as $pengajuan) {
            // Get the scholarship and its requirements
            $beasiswa = Beasiswa::find($pengajuan->id_beasiswa);
            $syarats = Syarat::where('id_beasiswa', $beasiswa->id_beasiswa)->get();
            
            // Create standard documents that all applications need
            $this->createStandardDocuments($faker, $pengajuan);
            
            // Create documents based on scholarship requirements
            foreach ($syarats as $syarat) {
                $this->createDocumentForRequirement($faker, $pengajuan, $syarat);
            }
        }
    }
    
    /**
     * Create standard documents that all scholarship applications need
     */
    private function createStandardDocuments($faker, $pengajuan)
    {
        // List of standard documents
        $standardDocs = [
            'KTM' => 'KTM_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Transkrip Nilai' => 'Transkrip_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Surat Permohonan' => 'Permohonan_' . $pengajuan->mahasiswa->nim . '.pdf',
            'KTP' => 'KTP_' . $pengajuan->mahasiswa->nim . '.pdf',
        ];
        
        foreach ($standardDocs as $docName => $fileName) {
            $this->createDocument(
                $faker,
                $pengajuan->id_pengajuan,
                $docName,
                'public/uploads/dokumen/' . $fileName,
                $pengajuan->status_pengajuan
            );
        }
    }
    
    /**
     * Create a document based on specific scholarship requirement
     */
    private function createDocumentForRequirement($faker, $pengajuan, $syarat)
    {
        $docTypes = [
            'IPK Minimal' => null, // No document needed for IPK check
            'Surat Keterangan Tidak Mampu' => 'SKTM_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Sertifikat Prestasi' => 'Prestasi_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Surat Rekomendasi' => 'Rekomendasi_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Bukti Pembayaran UKT' => 'UKT_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Surat Keterangan Aktif' => 'Aktif_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Bukti Kegiatan Organisasi' => 'Organisasi_' . $pengajuan->mahasiswa->nim . '.pdf',
            'Kartu Keluarga' => 'KK_' . $pengajuan->mahasiswa->nim . '.pdf',
        ];
        
        // Skip if no document type mapping or IPK requirement (checked programmatically)
        if (!isset($docTypes[$syarat->nama_syarat]) || $docTypes[$syarat->nama_syarat] === null) {
            return;
        }
        
        $this->createDocument(
            $faker,
            $pengajuan->id_pengajuan,
            $syarat->nama_syarat,
            'public/uploads/dokumen/' . $docTypes[$syarat->nama_syarat],
            $pengajuan->status_pengajuan
        );
    }
    
    /**
     * Helper function to create a document record
     */
    private function createDocument($faker, $pengajuanId, $documentName, $filePath, $applicationStatus)
    {
        // Map our verification statuses to the database enum values
        $verificationStatusMap = [
            'verified' => 'valid',
            'rejected' => 'tidak_valid',
            'pending' => 'belum_diverifikasi'
        ];
        
        // Determine verification status based on application status
        switch ($applicationStatus) {
            case 'diterima': // approved
                $verificationStatus = $verificationStatusMap['verified'];
                $remarks = $faker->optional(0.3)->sentence() ?: 'Dokumen sudah diperiksa dan disetujui';
                break;
            case 'ditolak': // rejected
                // 70% of documents in rejected applications have issues
                $internalStatus = $faker->randomElement(['verified', 'rejected', 'rejected', 'rejected']);
                $verificationStatus = $verificationStatusMap[$internalStatus];
                $remarks = $internalStatus === 'rejected' 
                    ? $faker->randomElement([
                        'Dokumen tidak jelas/tidak terbaca',
                        'Dokumen sudah tidak berlaku',
                        'Dokumen tidak memenuhi syarat',
                        'Tanda tangan tidak lengkap',
                        'Informasi tidak sesuai dengan data yang disubmit',
                        'Dokumen tidak absah',
                      ])
                    : 'Dokumen sudah diperiksa';
                break;
            default: // diproses (pending)
                $internalStatus = $faker->randomElement(['pending', 'pending', 'pending', 'verified']);
                $verificationStatus = $verificationStatusMap[$internalStatus];
                $remarks = $internalStatus === 'verified' 
                    ? 'Dokumen sudah diperiksa' 
                    : 'Menunggu verifikasi';
                break;
        }
        
        Dokumen::create([
            'id_pengajuan' => $pengajuanId,
            'nama_dokumen' => $documentName,
            'file_path' => $filePath,
            'status_verifikasi' => $verificationStatus,
            'keterangan' => $remarks
        ]);
    }
} 