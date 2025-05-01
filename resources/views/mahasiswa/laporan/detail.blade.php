@extends('layouts.main')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('report.index') }}" class="btn btn-outline-primary mb-3">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Laporan
            </a>
        </div>
    </div>

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fs-4 mb-1">{{ $pengajuan->beasiswa->nama_beasiswa }}</h2>
                            <p class="mb-1 text-muted">
                                <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                    {{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis }}
                                </span>
                                <i class="far fa-calendar-alt me-1"></i> 
                                Diajukan pada {{ $pengajuan->tgl_pengajuan->format('d M Y') }}
                            </p>
                        </div>
                        
                        <div class="text-end">
                            @if($pengajuan->status_pengajuan == 'diterima')
                                <span class="badge bg-success rounded-3 px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Diterima
                                </span>
                            @elseif($pengajuan->status_pengajuan == 'ditolak')
                                <span class="badge bg-danger rounded-3 px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                </span>
                            @else
                                <span class="badge bg-warning rounded-3 px-3 py-2">
                                    <i class="fas fa-hourglass-half me-1"></i> Diproses
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Detail Sections -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-7 mb-4 mb-lg-0">
            <!-- Application Details -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-light"><i class="fas fa-info-circle me-2"></i> Detail Pengajuan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Alasan Pengajuan</h6>
                        <p class="mb-0">{{ $pengajuan->alasan_pengajuan }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Tanggal Pengajuan</h6>
                            <p class="mb-0">{{ $pengajuan->tgl_pengajuan->format('d M Y H:i') }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Terakhir Diperbarui</h6>
                            <p class="mb-0">{{ $pengajuan->updated_at->format('d M Y H:i') }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Status</h6>
                            <p class="mb-0">
                                @if($pengajuan->status_pengajuan == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($pengajuan->status_pengajuan == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning">Diproses</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Dokumen Terlampir</h6>
                            <p class="mb-0">{{ $pengajuan->dokumen->count() }} dokumen</p>
                        </div>
                    </div>
                    
                    @if($pengajuan->status_pengajuan == 'ditolak' && $pengajuan->alasan_penolakan)
                        <div class="mt-3 p-3 bg-danger bg-opacity-10 rounded-3">
                            <h6 class="fw-bold mb-2 text-danger">Alasan Penolakan</h6>
                            <p class="mb-0">{{ $pengajuan->alasan_penolakan }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Beasiswa Details -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-light"><i class="fas fa-graduation-cap me-2"></i> Informasi Beasiswa</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Deskripsi</h6>
                        <p class="mb-0">{{ $pengajuan->beasiswa->deskripsi }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Jenis Beasiswa</h6>
                            <p class="mb-0">{{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Penyelenggara</h6>
                            <p class="mb-0">{{ $pengajuan->beasiswa->penyelenggara ?? 'Tidak tercantum' }}</p>
                        </div>
                        
                        @if($pengajuan->beasiswa->jumlah)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Jumlah Beasiswa</h6>
                            <p class="mb-0">{{ $pengajuan->beasiswa->jumlah }}</p>
                        </div>
                        @endif
                        
                        @if($pengajuan->beasiswa->nominal)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Nominal Beasiswa</h6>
                            <p class="mb-0">Rp {{ number_format($pengajuan->beasiswa->nominal, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-5">
            <!-- Document List -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-light"><i class="fas fa-file-alt me-2"></i> Dokumen Pengajuan</h5>
                </div>
                <div class="card-body p-0">
                    @if($pengajuan->dokumen->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($pengajuan->dokumen as $dokumen)
                                <li class="list-group-item border-0 py-3 px-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                                <i class="fas fa-file-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $dokumen->nama_dokumen }}</h6>
                                                <small class="text-muted">
                                                    Diupload: {{ $dokumen->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('dokumen.show', $dokumen->id_dokumen) }}" class="btn btn-sm btn-primary rounded-pill">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="d-block mb-1">Status Verifikasi:</small>
                                        @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                            <span class="badge bg-secondary">Belum Diverifikasi</span>
                                        @elseif($dokumen->status_verifikasi == 'valid')
                                            <span class="badge bg-success">Valid</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Valid</span>
                                        @endif
                                        
                                        @if($dokumen->keterangan)
                                            <div class="mt-2 small">
                                                <strong>Keterangan:</strong> {{ $dokumen->keterangan }}
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-0">Belum ada dokumen terlampir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 