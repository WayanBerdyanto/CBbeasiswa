@extends('layouts.main')

@section('title', 'Edit Pengajuan Beasiswa')

@section('content')
    <div class="container mt-5 text-white">
        <h2 class="text-center text-blue-400 mb-4">Edit Pengajuan Beasiswa</h2>

        <div class="card bg-gray-800 p-4">
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pengajuan.update', $pengajuan->id_pengajuan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Beasiswa</label>
                    <input type="text" class="form-control" value="{{ $beasiswa->nama_beasiswa }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">IPK Anda</label>
                    <input type="number" name="ipk" class="form-control" step="0.01" min="0" max="4" value="{{ old('ipk', $pengajuan->ipk) }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Alasan Pengajuan</label>
                    <textarea name="alasan_pengajuan" class="form-control" rows="4" required>{{ old('alasan_pengajuan', $pengajuan->alasan_pengajuan) }}</textarea>
                </div>

                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">Dokumen Pendukung</h5>
                    
                    @if($pengajuan->dokumen->count() > 0)
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Dokumen</th>
                                        <th>Status Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengajuan->dokumen as $dokumen)
                                        <tr>
                                            <td>{{ $dokumen->nama_dokumen }}</td>
                                            <td>
                                                @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                                    <span class="badge bg-secondary">Belum Diverifikasi</span>
                                                @elseif($dokumen->status_verifikasi == 'valid')
                                                    <span class="badge bg-success">Valid</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Valid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('dokumen.show', $dokumen->id_dokumen) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mb-3">
                            <a href="{{ route('dokumen.create', $pengajuan->id_pengajuan) }}" class="btn btn-info">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Dokumen Baru
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> Belum ada dokumen yang diunggah.
                            <a href="{{ route('dokumen.create', $pengajuan->id_pengajuan) }}" class="alert-link">Unggah dokumen sekarang</a>.
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 