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
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 5px;
        }
        .header p {
            font-size: 12px;
            margin: 0;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info p {
            margin: 5px 0;
        }
        .summary {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            font-weight: bold;
        }
        td {
            padding: 8px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .status-diterima {
            color: #28a745;
            font-weight: bold;
        }
        .status-ditolak {
            color: #dc3545;
            font-weight: bold;
        }
        .status-diproses {
            color: #ffc107;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal laporan: {{ $date }}</p>
        @if(isset($isAdmin) && $isAdmin)
            <p class="text-center"><strong>Dilihat oleh Admin</strong></p>
        @endif
    </div>
    
    <div class="student-info">
        <h2>Data Mahasiswa</h2>
        <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Program Studi:</strong> {{ $mahasiswa->prodi }}</p>
        <p><strong>Fakultas:</strong> {{ $mahasiswa->fakultas }}</p>
    </div>
    
    <div class="summary">
        <h2>Ringkasan</h2>
        <p>Total pengajuan beasiswa: {{ $count }}</p>
    </div>
    
    <h2>Daftar Pengajuan Beasiswa</h2>
    
    @if($pengajuanList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Beasiswa</th>
                    <th>Jenis</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuanList as $index => $pengajuan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengajuan->beasiswa->nama_beasiswa }}</td>
                    <td>{{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis }}</td>
                    <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                    <td>
                        @if($pengajuan->status_pengajuan == 'diterima')
                            <span class="status-diterima">Diterima</span>
                        @elseif($pengajuan->status_pengajuan == 'ditolak')
                            <span class="status-ditolak">Ditolak</span>
                        @else
                            <span class="status-diproses">Diproses</span>
                        @endif
                    </td>
                    <td>{{ $pengajuan->dokumen->count() }} dokumen</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <h2>Detail Dokumen</h2>
        @foreach($pengajuanList as $index => $pengajuan)
            <h3>{{ $index + 1 }}. {{ $pengajuan->beasiswa->nama_beasiswa }}</h3>
            @if($pengajuan->dokumen->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Status Verifikasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuan->dokumen as $dokumen)
                        <tr>
                            <td>{{ $dokumen->nama_dokumen }}</td>
                            <td>{{ $dokumen->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                    Belum Diverifikasi
                                @elseif($dokumen->status_verifikasi == 'valid')
                                    Valid
                                @else
                                    Tidak Valid
                                @endif
                            </td>
                            <td>{{ $dokumen->keterangan ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada dokumen terlampir</p>
            @endif
            
            @if($pengajuan->alasan_pengajuan)
                <p><strong>Alasan Pengajuan:</strong> {{ $pengajuan->alasan_pengajuan }}</p>
            @endif
            
            @if($pengajuan->status_pengajuan == 'ditolak' && $pengajuan->alasan_penolakan)
                <p><strong>Alasan Penolakan:</strong> {{ $pengajuan->alasan_penolakan }}</p>
            @endif
        @endforeach
    @else
        <p>Tidak ada pengajuan beasiswa yang ditemukan.</p>
    @endif
    
    <div class="footer">
        <p>Dokumen ini dicetak pada {{ $date }} dan merupakan dokumen resmi untuk keperluan pribadi.</p>
    </div>
</body>
</html> 