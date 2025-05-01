@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Detail Pengajuan</h2>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="text-light">Informasi Beasiswa</h5>
                                    <div class="p-3 rounded" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <p class="mb-2"><strong>Nama Beasiswa:</strong> {{ $pengajuan->beasiswa->nama_beasiswa }}</p>
                                        <p class="mb-2"><strong>Jenis:</strong> {{ $pengajuan->beasiswa->jenisBeasiswa ? $pengajuan->beasiswa->jenisBeasiswa->nama_jenis : 'Tidak ada jenis' }}</p>
                                        <p class="mb-0"><strong>Deskripsi:</strong> {{ $pengajuan->beasiswa->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="text-light">Informasi Mahasiswa</h5>
                                    <div class="p-3 rounded" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <p class="mb-2"><strong>Nama:</strong> {{ $pengajuan->mahasiswa->nama }}</p>
                                        <p class="mb-2"><strong>NIM:</strong> {{ $pengajuan->mahasiswa->nim }}</p>
                                        <p class="mb-2"><strong>Jurusan:</strong> {{ $pengajuan->mahasiswa->jurusan }}</p>
                                        <p class="mb-0"><strong>Angkatan:</strong> {{ $pengajuan->mahasiswa->angkatan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-light">Detail Pengajuan</h5>
                                <div class="p-3 rounded" style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Status:</strong> 
                                                @if($pengajuan->status_pengajuan == 'diterima')
                                                    <span class="badge" style="background: linear-gradient(90deg, #1cc88a, #13855c);">Diterima</span>
                                                @elseif($pengajuan->status_pengajuan == 'ditolak')
                                                    <span class="badge" style="background: linear-gradient(90deg, #e74a3b, #be2617);">Ditolak</span>
                                                @else
                                                    <span class="badge" style="background: linear-gradient(90deg, #f6c23e, #dda20a); color: var(--wm-dark);">Diproses</span>
                                                @endif
                                            </p>
                                            <p class="mb-2"><strong>Tanggal Pengajuan:</strong> {{ $pengajuan->tgl_pengajuan->format('d F Y') }}</p>
                                            <p class="mb-2"><strong>IPK Mahasiswa:</strong> {{ $pengajuan->ipk }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Periode:</strong> 
                                                @if($pengajuan->periode)
                                                    {{ $pengajuan->periode->nama_periode }}
                                                    <span class="badge {{ $pengajuan->periode->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $pengajuan->periode->status }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tidak ada periode</span>
                                                @endif
                                            </p>
                                            @if($pengajuan->periode)
                                                <p class="mb-2"><strong>Durasi Periode:</strong> 
                                                    {{ $pengajuan->periode->tanggal_mulai->format('d M Y') }} - 
                                                    {{ $pengajuan->periode->tanggal_selesai->format('d M Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="fw-bold mb-2">Alasan Pengajuan:</p>
                                        <div class="p-3 rounded" style="background-color: var(--wm-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                            {{ $pengajuan->alasan_pengajuan }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pengajuan.index') }}" class="btn" style="background-color: var(--wm-gray); color: var(--wm-white); border: 1px solid rgba(255, 255, 255, 0.1);">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <div>
                                <a href="{{ route('admin.pengajuan.edit', $pengajuan->id_pengajuan) }}" class="btn btn-info">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.pengajuan.destroy', $pengajuan->id_pengajuan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="background: linear-gradient(90deg, #e74a3b, #be2617); border: none;" onclick="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                        <i class="fas fa-trash me-1"></i> Hapus
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

