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
        <p><strong>Total Data:</strong> {{ $count }} beasiswa</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Beasiswa</th>
                <th>Jenis Beasiswa</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beasiswas as $index => $beasiswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $beasiswa->nama_beasiswa }}</td>
                    <td>{{ $beasiswa->jenisBeasiswa ? $beasiswa->jenisBeasiswa->nama_jenis : 'N/A' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($beasiswa->deskripsi, 50) }}</td>
                    <td>{{ $beasiswa->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>© {{ date('Y') }} CBScholarships System. Dokumen ini dihasilkan secara otomatis.</p>
    </div>
</body>
</html> 