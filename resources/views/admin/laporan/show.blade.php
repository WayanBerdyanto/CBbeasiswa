@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Hasil Laporan</h1>
                <div>
                    <a href="{{ route('admin.laporan.create') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-filter mr-1"></i> Filter Baru
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-info">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card bg-gray-800 border-0 shadow">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Filter Laporan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-white">Jenis Laporan:</h6>
                                <p class="text-gray-300">
                                    @if($jenis_laporan == 'pengajuan')
                                        Laporan Pengajuan Beasiswa
                                    @elseif($jenis_laporan == 'beasiswa')
                                        Laporan Data Beasiswa
                                    @else
                                        {{ $jenis_laporan }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        @if($jenis_beasiswa)
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-white">Jenis Beasiswa:</h6>
                                <p class="text-gray-300">{{ $jenis_beasiswa->nama_jenis }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($tanggal_mulai)
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-white">Periode:</h6>
                                <p class="text-gray-300">
                                    {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }}
                                    @if($tanggal_selesai)
                                        - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-white">Total Data:</h6>
                                <p class="text-gray-300">{{ $results->count() }} entri</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-gray-800 border-0">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success me-2" onclick="window.print()">
                            <i class="fas fa-print mr-1"></i> Cetak
                        </button>
                        
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                <li>
                                    <form action="{{ route('admin.laporan.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="jenis_laporan" value="{{ $jenis_laporan }}">
                                        @if($tanggal_mulai)
                                            <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                                        @endif
                                        @if($tanggal_selesai)
                                            <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                                        @endif
                                        @if($jenis_beasiswa)
                                            <input type="hidden" name="id_jenis" value="{{ $jenis_beasiswa->id_jenis }}">
                                        @endif
                                        <button type="submit" name="export_type" value="excel" class="dropdown-item">
                                            <i class="fas fa-file-excel mr-2"></i> Export ke Excel
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.laporan.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="jenis_laporan" value="{{ $jenis_laporan }}">
                                        @if($tanggal_mulai)
                                            <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                                        @endif
                                        @if($tanggal_selesai)
                                            <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                                        @endif
                                        @if($jenis_beasiswa)
                                            <input type="hidden" name="id_jenis" value="{{ $jenis_beasiswa->id_jenis }}">
                                        @endif
                                        <button type="submit" name="export_type" value="pdf" class="dropdown-item">
                                            <i class="fas fa-file-pdf mr-2"></i> Export ke PDF
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Data Laporan 
                        <small class="text-muted">{{ now()->format('d M Y H:i') }}</small>
                    </h6>
                </div>
                <div class="card-body">
                    @if($results->count() > 0)
                        @if($jenis_laporan == 'pengajuan')
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Mahasiswa</th>
                                            <th>Beasiswa</th>
                                            <th>Jenis Beasiswa</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results as $index => $pengajuan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                            <td>
                                                {{ $pengajuan->mahasiswa->nama ?? 'N/A' }}
                                                <small class="d-block text-muted">{{ $pengajuan->mahasiswa->nim ?? '' }}</small>
                                            </td>
                                            <td>{{ $pengajuan->beasiswa->nama_beasiswa ?? 'N/A' }}</td>
                                            <td>{{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis ?? 'N/A' }}</td>
                                            <td>
                                                @if($pengajuan->status_pengajuan == 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif($pengajuan->status_pengajuan == 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Diproses</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($jenis_laporan == 'beasiswa')
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Beasiswa</th>
                                            <th>Jenis Beasiswa</th>
                                            <th>Deskripsi</th>
                                            <th>Tgl Dibuat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results as $index => $beasiswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $beasiswa->nama_beasiswa }}</td>
                                            <td>{{ $beasiswa->jenisBeasiswa->nama_jenis ?? 'N/A' }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($beasiswa->deskripsi, 50) }}</td>
                                            <td>{{ $beasiswa->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-gray-400 mb-3"></i>
                            <p class="mb-0">Tidak ada data yang sesuai dengan filter yang dipilih.</p>
                            <a href="{{ route('admin.laporan.create') }}" class="btn btn-primary mt-3">
                                Coba Filter Lain
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gray-300 {
        color: #dddfeb;
    }
    .text-gray-400 {
        color: #b7b9cc;
    }
    .text-gray-500 {
        color: #a0a5b9;
    }
    .bg-gray-700 {
        background-color: #424554;
    }
    @media print {
        header, footer, .btn, nav, .no-print {
            display: none !important;
        }
        body {
            background-color: white !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        .card-header {
            background-color: #f8f9fc !important;
            color: #000 !important;
        }
        .text-white, .text-gray-300 {
            color: #000 !important;
        }
        .bg-gray-800, .bg-gradient-dark {
            background-color: #fff !important;
        }
    }
</style>

@endsection 