@extends('layouts.main')

@section('title', 'Detail Pengajuan Beasiswa')

@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-primary mb-3">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pengajuan
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    </div>
    @endif
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fs-4 mb-1">{{ $pengajuan->beasiswa->nama_beasiswa }}</h2>
                            <p class="mb-1 text-light">
                                @if($pengajuan->beasiswa->jenisBeasiswa)
                                <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                    {{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis }}
                                </span>
                                @endif
                                <i class="far fa-calendar-alt me-1"></i> 
                                Diajukan pada {{ $pengajuan->tgl_pengajuan->format('d M Y') }}
                            </p>
                        </div>
                        
                        <div class="text-end">
                            @if($pengajuan->status_pengajuan == 'diterima')
                                <span class="badge badge-diterima rounded-3 px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Diterima
                                </span>
                            @elseif($pengajuan->status_pengajuan == 'ditolak')
                                <span class="badge badge-ditolak rounded-3 px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                </span>
                            @else
                                <span class="badge badge-diproses rounded-3 px-3 py-2">
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
                            <h6 class="fw-bold mb-2">IPK Mahasiswa</h6>
                            <p class="mb-0">{{ $pengajuan->ipk }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Semester Mahasiswa</h6>
                            <p class="mb-0">{{ $pengajuan->mahasiswa ->semester }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Status</h6>
                            <p class="mb-0">
                                <span class="badge 
                                    @if($pengajuan->status_pengajuan == 'diterima') bg-success
                                    @elseif($pengajuan->status_pengajuan == 'ditolak') bg-danger
                                    @else bg-warning @endif">
                                    {{ ucfirst($pengajuan->status_pengajuan) }}
                                </span>
                            </p>
                        </div>
                        
                        @if($pengajuan->status_pengajuan == 'diterima')
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Nominal Disetujui</h6>
                            <p class="mb-0">Rp. {{ number_format($pengajuan->nominal_approved, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if($pengajuan->status_pengajuan == 'diproses')
                    <div class="mt-3">
                        <a href="{{ route('pengajuan.edit', $pengajuan->id_pengajuan) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i> Edit Pengajuan
                        </a>
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
                            <p class="mb-0">{{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis ?? 'Tidak ada jenis' }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Nominal Beasiswa</h6>
                            <p class="mb-0">Rp. {{ number_format($pengajuan->beasiswa->nominal, 0, ',', '.') }}</p>
                        </div>
                        
                        @if($pengajuan->periode)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Periode</h6>
                            <p class="mb-0">{{ $pengajuan->periode->nama_periode }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Tanggal Periode</h6>
                            <p class="mb-0">{{ $pengajuan->periode->tanggal_mulai->format('d M Y') }} - {{ $pengajuan->periode->tanggal_selesai->format('d M Y') }}</p>
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
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-light"><i class="fas fa-file-alt me-2"></i> Dokumen Pendukung</h5>
                    <a href="{{ route('dokumen.create', $pengajuan->id_pengajuan) }}?redirect_to_detail=1" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i> Tambah Dokumen
                    </a>
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
                                                <small class="text-light">
                                                    Diupload: {{ $dokumen->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="btn-group">
                                                <a href="{{ route('dokumen.show', $dokumen->id_dokumen) }}" 
                                                   class="btn btn-sm btn-primary rounded-start">
                                                    <i class="fas fa-eye me-1"></i> Lihat
                                                </a>
                                                <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @if($pengajuan->status_pengajuan == 'diproses')
                                                <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}?redirect_to_detail=1" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger rounded-end delete-doc-btn" 
                                                        data-id="{{ $dokumen->id_dokumen }}"
                                                        data-name="{{ $dokumen->nama_dokumen }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-doc-{{ $dokumen->id_dokumen }}" 
                                                      action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}" 
                                                      method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endif
                                            </div>
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
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-light mb-3"></i>
                            <p class="mb-0">Belum ada dokumen yang diunggah</p>
                            <a href="{{ route('dokumen.create', $pengajuan->id_pengajuan) }}?redirect_to_detail=1" class="btn btn-primary mt-3">
                                <i class="fas fa-upload me-2"></i> Unggah Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-diterima {
        background: linear-gradient(90deg, #1cc88a, #13855c);
        color: white;
    }
    .badge-ditolak {
        background: linear-gradient(90deg, #e74a3b, #be2617);
        color: white;
    }
    .badge-diproses {
        background: linear-gradient(90deg, #f6c23e, #dda20a);
        color: white;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .list-group-item {
        transition: background-color 0.2s;
    }
    
    .list-group-item:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete document confirmation
        document.querySelectorAll('.delete-doc-btn').forEach(button => {
            button.addEventListener('click', function() {
                const docId = this.getAttribute('data-id');
                const docName = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Anda yakin ingin menghapus dokumen <strong>${docName}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#3f51b5',
                    confirmButtonText: '<i class="fas fa-trash-alt me-2"></i>Hapus',
                    cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-doc-${docId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endpush 