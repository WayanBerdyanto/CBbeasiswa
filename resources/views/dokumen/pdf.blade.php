<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 5px;
            color: #4e73df;
        }
        .header p {
            font-size: 12px;
            margin: 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 14px;
            margin: 0 0 10px;
            color: #4e73df;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-box {
            background: #f8f9fc;
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .info-box p {
            margin: 5px 0;
        }
        .status-valid {
            color: #1cc88a;
            font-weight: bold;
        }
        .status-invalid {
            color: #e74a3b;
            font-weight: bold;
        }
        .status-pending {
            color: #f6c23e;
            font-weight: bold;
        }
        .nominal-box {
            background: #e8f4ff;
            border: 2px solid #4e73df;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .nominal-approved {
            color: #1cc88a;
            font-size: 14px;
            font-weight: bold;
        }
        .nominal-default {
            color: #4e73df;
            font-size: 14px;
            font-weight: bold;
        }
        .nominal-note {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal Cetak: {{ $date }}</p>
    </div>
    
    <!-- Informasi Mahasiswa -->
    <div class="section">
        <h2>Data Mahasiswa</h2>
        <div class="info-box">
            <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
            <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            <p><strong>Jurusan:</strong> {{ $mahasiswa->jurusan }}</p>
            <p><strong>Fakultas:</strong> {{ $mahasiswa->fakultas }}</p>
            <p><strong>Semester:</strong> {{ $mahasiswa->semester }}</p>
            <p><strong>IPK:</strong> {{ $mahasiswa->ipk_terakhir }}</p>
        </div>
    </div>
    
    <!-- Informasi Beasiswa -->
    <div class="section">
        <h2>Informasi Beasiswa</h2>
        <div class="info-box">
            <p><strong>Nama Beasiswa:</strong> {{ $beasiswa->nama_beasiswa }}</p>
            <p><strong>Jenis Beasiswa:</strong> {{ $beasiswa->jenisBeasiswa->nama_jenis ?? 'N/A' }}</p>
            
            <!-- Nominal Beasiswa -->
            <div class="nominal-box">
                @if($pengajuan->status_pengajuan == 'diterima')
                    <p><strong>Nominal Disetujui:</strong> 
                        <span class="nominal-approved">Rp {{ number_format($pengajuan->nominal_display, 0, ',', '.') }}</span>
                    </p>
                    @if($pengajuan->nominal_approved != $beasiswa->nominal)
                        <p><strong>Nominal Awal:</strong> 
                            <span class="nominal-default">Rp {{ number_format($beasiswa->nominal, 0, ',', '.') }}</span>
                        </p>
                        <p class="nominal-note">*Nominal telah disesuaikan oleh admin</p>
                    @endif
                @else
                    <p><strong>Nominal Beasiswa:</strong> 
                        <span class="nominal-default">Rp {{ number_format($pengajuan->nominal_display, 0, ',', '.') }}</span>
                    </p>
                    @if($pengajuan->status_pengajuan == 'diproses')
                        <p class="nominal-note">*Nominal dapat berubah sesuai keputusan admin</p>
                    @endif
                @endif
            </div>

            @if($pengajuan->periode)
            <p><strong>Periode:</strong> {{ $pengajuan->periode->nama_periode }}</p>
            <p><strong>Tanggal Periode:</strong> {{ $pengajuan->periode->tanggal_mulai->format('d/m/Y') }} - {{ $pengajuan->periode->tanggal_selesai->format('d/m/Y') }}</p>
            @endif
        </div>
    </div>
    
    <!-- Detail Dokumen -->
    <div class="section">
        <h2>Detail Dokumen</h2>
        <div class="info-box">
            <p><strong>Nama Dokumen:</strong> {{ $dokumen->nama_dokumen }}</p>
            <p><strong>Tanggal Upload:</strong> {{ $dokumen->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Status Verifikasi:</strong> 
                @if($dokumen->status_verifikasi == 'valid')
                    <span class="status-valid">Valid</span>
                @elseif($dokumen->status_verifikasi == 'tidak_valid')
                    <span class="status-invalid">Tidak Valid</span>
                @else
                    <span class="status-pending">Belum Diverifikasi</span>
                @endif
            </p>
            @if($dokumen->keterangan)
            <p><strong>Keterangan:</strong> {{ $dokumen->keterangan }}</p>
            @endif
        </div>
    </div>
    
    <!-- Status Pengajuan -->
    <div class="section">
        <h2>Status Pengajuan</h2>
        <div class="info-box">
            <p><strong>Status:</strong> 
                @if($pengajuan->status_pengajuan == 'diterima')
                    <span class="status-valid">Diterima</span>
                @elseif($pengajuan->status_pengajuan == 'ditolak')
                    <span class="status-invalid">Ditolak</span>
                @else
                    <span class="status-pending">Diproses</span>
                @endif
            </p>
            <p><strong>Tanggal Pengajuan:</strong> {{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
            @if($pengajuan->alasan_pengajuan)
            <p><strong>Alasan Pengajuan:</strong> {{ $pengajuan->alasan_pengajuan }}</p>
            @endif
            @if($pengajuan->status_pengajuan == 'ditolak' && $pengajuan->alasan_penolakan)
            <p><strong>Alasan Penolakan:</strong> {{ $pengajuan->alasan_penolakan }}</p>
            @endif
        </div>
    </div>
    
    <div class="footer">
        <p>Dokumen ini dicetak pada {{ $date }} dan merupakan dokumen resmi untuk keperluan akademik.</p>
        <p>{{ config('app.name') }} - Sistem Informasi Beasiswa</p>
    </div>
</body>
</html> 