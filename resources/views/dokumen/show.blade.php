@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Dokumen</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>{{ $dokumen->nama_dokumen }}</h4>
                        <p class="text-muted mb-0">
                            Diunggah pada: {{ $dokumen->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Informasi Dokumen</h6>
                            <div class="mb-2">
                                <strong>Status Verifikasi:</strong> 
                                @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                    <span class="badge bg-secondary">Belum Diverifikasi</span>
                                @elseif($dokumen->status_verifikasi == 'valid')
                                    <span class="badge bg-success">Valid</span>
                                @else
                                    <span class="badge bg-danger">Tidak Valid</span>
                                @endif
                            </div>
                            @if($dokumen->keterangan)
                            <div class="mb-2">
                                <strong>Keterangan:</strong> {{ $dokumen->keterangan }}
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Informasi Pengajuan</h6>
                            <div class="mb-2">
                                <strong>Beasiswa:</strong> {{ $dokumen->pengajuan->beasiswa->nama_beasiswa }}
                            </div>
                            <div class="mb-2">
                                <strong>Tanggal Pengajuan:</strong> {{ $dokumen->pengajuan->tgl_pengajuan->format('d/m/Y') }}
                            </div>
                            <div class="mb-2">
                                <strong>Status Pengajuan:</strong> 
                                <span class="badge {{ $dokumen->pengajuan->status_pengajuan == 'diterima' ? 'bg-success' : ($dokumen->pengajuan->status_pengajuan == 'ditolak' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($dokumen->pengajuan->status_pengajuan) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Preview File</h6>
                        <div class="border p-3 rounded bg-light text-center">
                            @php
                                $extension = pathinfo($dokumen->file_path, PATHINFO_EXTENSION);
                            @endphp
                            
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $dokumen->file_path) }}" alt="{{ $dokumen->nama_dokumen }}" class="img-fluid mb-2" style="max-height: 300px;">
                            @else
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-text display-1 text-primary"></i>
                                    <p class="mt-2">{{ strtoupper($extension) }} Document</p>
                                </div>
                            @endif
                            
                            <div class="mt-3">
                                <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-download"></i> Download File
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 