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
        @if($jenisBeasiswa)
            <p><strong>Jenis Beasiswa:</strong> {{ $jenisBeasiswa->nama_jenis }}</p>
        @endif
        
        @if($tanggalPeriode)
            <p><strong>Periode:</strong> {{ $tanggalPeriode }}</p>
        @endif
        
        <p><strong>Total Data:</strong> {{ $count }} pengajuan</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Beasiswa</th>
                <th>Jenis Beasiswa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuans as $index => $pengajuan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                    <td>{{ $pengajuan->mahasiswa ? $pengajuan->mahasiswa->nim : 'N/A' }}</td>
                    <td>{{ $pengajuan->mahasiswa ? $pengajuan->mahasiswa->nama : 'N/A' }}</td>
                    <td>{{ $pengajuan->beasiswa ? $pengajuan->beasiswa->nama_beasiswa : 'N/A' }}</td>
                    <td>{{ $pengajuan->beasiswa && $pengajuan->beasiswa->jenisBeasiswa ? $pengajuan->beasiswa->jenisBeasiswa->nama_jenis : 'N/A' }}</td>
                    <td>
                        @if($pengajuan->status_pengajuan == 'diterima')
                            <span class="status-diterima">Diterima</span>
                        @elseif($pengajuan->status_pengajuan == 'ditolak')
                            <span class="status-ditolak">Ditolak</span>
                        @else
                            <span class="status-diproses">Diproses</span>
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