@extends('admin.layouts.main')

@section('title', 'Verifikasi Dokumen')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center py-3">
                    <h2>Verifikasi Dokumen</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-light">Informasi Dokumen</h5>
                                <div class="p-3 rounded" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <p class="mb-2"><strong>Nama Dokumen:</strong> {{ $dokumen->nama_dokumen }}</p>
                                    <p class="mb-2"><strong>Tanggal Upload:</strong> {{ $dokumen->created_at->format('d F Y H:i') }}</p>
                                    <p class="mb-2"><strong>Status Verifikasi Saat Ini:</strong> 
                                        @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                            <span class="badge bg-secondary">Belum Diverifikasi</span>
                                        @elseif($dokumen->status_verifikasi == 'valid')
                                            <span class="badge bg-success">Valid</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Valid</span>
                                        @endif
                                    </p>
                                    @if($dokumen->keterangan)
                                        <p class="mb-0"><strong>Keterangan Saat Ini:</strong> {{ $dokumen->keterangan }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-light">Informasi Pengajuan</h5>
                                <div class="p-3 rounded" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <p class="mb-2"><strong>Nama Beasiswa:</strong> {{ $dokumen->pengajuan->beasiswa->nama_beasiswa }}</p>
                                    <p class="mb-2"><strong>Nama Mahasiswa:</strong> {{ $dokumen->pengajuan->mahasiswa->nama }}</p>
                                    <p class="mb-2"><strong>NIM:</strong> {{ $dokumen->pengajuan->mahasiswa->nim }}</p>
                                    <p class="mb-0"><strong>Status Pengajuan:</strong> 
                                        @if($dokumen->pengajuan->status_pengajuan == 'diterima')
                                            <span class="badge" style="background: linear-gradient(90deg, #1cc88a, #13855c);">Diterima</span>
                                        @elseif($dokumen->pengajuan->status_pengajuan == 'ditolak')
                                            <span class="badge" style="background: linear-gradient(90deg, #e74a3b, #be2617);">Ditolak</span>
                                        @else
                                            <span class="badge" style="background: linear-gradient(90deg, #f6c23e, #dda20a); color: var(--wm-dark);">Diproses</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-light">Preview Dokumen</h5>
                            <div class="p-3 rounded text-center" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                @php
                                    $extension = pathinfo($dokumen->file_path, PATHINFO_EXTENSION);
                                @endphp
                                
                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $dokumen->file_path) }}" alt="{{ $dokumen->nama_dokumen }}" class="img-fluid mb-3" style="max-height: 400px;">
                                @elseif(strtolower($extension) == 'pdf')
                                    <div class="mb-3">
                                        <i class="fas fa-file-pdf fa-5x text-danger"></i>
                                        <p class="mt-2">PDF Document</p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <i class="fas fa-file-alt fa-5x"></i>
                                        <p class="mt-2">{{ strtoupper($extension) }} Document</p>
                                    </div>
                                @endif
                                
                                <a href="{{ route('admin.dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-primary">
                                    <i class="fas fa-download me-1"></i> Download Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-light">Form Verifikasi</h5>
                            <div class="p-3 rounded" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                <form action="{{ route('admin.dokumen.verifikasi', $dokumen->id_dokumen) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                                        <select class="form-select" id="status_verifikasi" name="status_verifikasi" required>
                                            <option value="belum_diverifikasi" {{ $dokumen->status_verifikasi == 'belum_diverifikasi' ? 'selected' : '' }}>Belum Diverifikasi</option>
                                            <option value="valid" {{ $dokumen->status_verifikasi == 'valid' ? 'selected' : '' }}>Valid</option>
                                            <option value="tidak_valid" {{ $dokumen->status_verifikasi == 'tidak_valid' ? 'selected' : '' }}>Tidak Valid</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $dokumen->keterangan }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.pengajuan.show', $dokumen->id_pengajuan) }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Simpan Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 