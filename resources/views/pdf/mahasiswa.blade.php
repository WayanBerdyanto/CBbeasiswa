<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #4e73df;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .status-diterima {
            background-color: #1cc88a;
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .status-ditolak {
            background-color: #e74a3b;
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .status-diproses {
            background-color: #f6c23e;
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal Laporan: {{ $date }}</p>
    </div>
    
    <div class="info">
        <p><strong>Total Data:</strong> {{ $count }} mahasiswa</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Jumlah Pengajuan</th>
                <th>Status Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswas as $index => $mahasiswa)
                @php
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
                @endphp
                
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->email }}</td>
                    <td>{{ $mahasiswa->program_studi ?? 'N/A' }}</td>
                    <td>{{ $jumlahPengajuan }}</td>
                    <td>
                        @if($statusTerakhir == 'Diterima')
                            <span class="status-diterima">Diterima</span>
                        @elseif($statusTerakhir == 'Ditolak')
                            <span class="status-ditolak">Ditolak</span>
                        @elseif($statusTerakhir == 'Diproses')
                            <span class="status-diproses">Diproses</span>
                        @else
                            {{ $statusTerakhir }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>© {{ date('Y') }} CBScholarships System. Dokumen ini dihasilkan secara otomatis.</p>
    </div>
</body>
</html> 