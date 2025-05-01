@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Dokumen</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokumen.update', $dokumen->id_dokumen) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <p><strong>Pengajuan Beasiswa:</strong> {{ $dokumen->pengajuan->beasiswa->nama_beasiswa }}</p>
                            <p><strong>Tanggal Pengajuan:</strong> {{ $dokumen->pengajuan->tgl_pengajuan->format('d/m/Y') }}</p>
                            <p><strong>Status Verifikasi Dokumen:</strong> 
                                @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                    <span class="badge bg-secondary">Belum Diverifikasi</span>
                                @elseif($dokumen->status_verifikasi == 'valid')
                                    <span class="badge bg-success">Valid</span>
                                @else
                                    <span class="badge bg-danger">Tidak Valid</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                            <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" 
                                id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" required>
                            @error('nama_dokumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="dokumen_file" class="form-label">File Dokumen</label>
                            <input type="file" class="form-control @error('dokumen_file') is-invalid @enderror" 
                                id="dokumen_file" name="dokumen_file">
                            <small class="text-muted">Format yang diperbolehkan: PDF, JPG, JPEG, PNG. Ukuran maksimal: 5MB</small>
                            <p class="mt-2">
                                <strong>File saat ini:</strong> 
                                <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="link-primary">
                                    <i class="bi bi-file-earmark"></i> {{ $dokumen->nama_dokumen }}
                                </a>
                            </p>
                            @error('dokumen_file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 