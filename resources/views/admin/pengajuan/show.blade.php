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
                                    <div class="p-3 rounded"
                                        style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <p class="mb-2"><strong>Nama Beasiswa:</strong>
                                            {{ $pengajuan->beasiswa->nama_beasiswa }}</p>
                                        <p class="mb-2"><strong>Jenis:</strong>
                                            {{ $pengajuan->beasiswa->jenisBeasiswa ? $pengajuan->beasiswa->jenisBeasiswa->nama_jenis : 'Tidak ada jenis' }}
                                        </p>
                                        <p class="mb-0"><strong>Deskripsi:</strong> {{ $pengajuan->beasiswa->deskripsi }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="text-light">Informasi Mahasiswa</h5>
                                    <div class="p-3 rounded"
                                        style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                        <p class="mb-2"><strong>Nama:</strong> {{ $pengajuan->mahasiswa->nama }}</p>
                                        <p class="mb-2"><strong>NIM:</strong> {{ $pengajuan->mahasiswa->nim }}</p>
                                        <p class="mb-2"><strong>Jurusan:</strong> {{ $pengajuan->mahasiswa->jurusan }}</p>
                                        <p class="mb-0"><strong>Angkatan:</strong> {{ $pengajuan->mahasiswa->angkatan }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-light">Detail Pengajuan</h5>
                                <div class="p-3 rounded"
                                    style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Status:</strong>
                                                @if ($pengajuan->status_pengajuan == 'diterima')
                                                    <span class="badge"
                                                        style="background: linear-gradient(90deg, #1cc88a, #13855c);">Diterima</span>
                                                @elseif($pengajuan->status_pengajuan == 'ditolak')
                                                    <span class="badge"
                                                        style="background: linear-gradient(90deg, #e74a3b, #be2617);">Ditolak</span>
                                                @else
                                                    <span class="badge"
                                                        style="background: linear-gradient(90deg, #f6c23e, #dda20a); color: var(--wm-dark);">Diproses</span>
                                                @endif
                                            </p>
                                            <p class="mb-2"><strong>Tanggal Pengajuan:</strong>
                                                {{ $pengajuan->tgl_pengajuan->format('d F Y') }}</p>
                                            <p class="mb-2"><strong>IPK Mahasiswa:</strong> {{ $pengajuan->ipk }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Periode:</strong>
                                                @if ($pengajuan->periode)
                                                    {{ $pengajuan->periode->nama_periode }}
                                                    <span
                                                        class="badge {{ $pengajuan->periode->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $pengajuan->periode->status }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tidak ada periode</span>
                                                @endif
                                            </p>
                                            @if ($pengajuan->periode)
                                                <p class="mb-2"><strong>Durasi Periode:</strong>
                                                    {{ $pengajuan->periode->tanggal_mulai->format('d M Y') }} -
                                                    {{ $pengajuan->periode->tanggal_selesai->format('d M Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="fw-bold mb-2">Alasan Pengajuan:</p>
                                        <div class="p-3 rounded"
                                            style="background-color: var(--wm-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                            {{ $pengajuan->alasan_pengajuan }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-light mb-0">Dokumen Pendukung</h5>
                                    <a href="{{ route('admin.dokumen.create', $pengajuan->id_pengajuan) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Dokumen
                                    </a>
                                </div>
                                <div class="p-3 rounded"
                                    style="background-color: var(--wm-light-gray); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    @if ($pengajuan->dokumen && $pengajuan->dokumen->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover" style="color: var(--wm-white);">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Dokumen</th>
                                                        <th>Status Verifikasi</th>
                                                        <th>Tanggal Upload</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pengajuan->dokumen as $dokumen)
                                                        <tr>
                                                            <td>{{ $dokumen->nama_dokumen }}</td>
                                                            <td>
                                                                @if ($dokumen->status_verifikasi == 'belum_diverifikasi')
                                                                    <span class="badge bg-secondary">Belum
                                                                        Diverifikasi</span>
                                                                @elseif($dokumen->status_verifikasi == 'valid')
                                                                    <span class="badge bg-success">Valid</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tidak Valid</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $dokumen->created_at->format('d/m/Y H:i') }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="{{ route('admin.dokumen.show', $dokumen->id_dokumen) }}"
                                                                        class="btn btn-sm btn-info me-1">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.dokumen.download', $dokumen->id_dokumen) }}"
                                                                        class="btn btn-sm btn-primary me-1">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.dokumen.verifikasi.form', $dokumen->id_dokumen) }}"
                                                                        class="btn btn-sm btn-warning me-1">
                                                                        <i class="fas fa-check-circle"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('admin.dokumen.destroy', $dokumen->id_dokumen) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center p-3">
                                            <i class="fas fa-file-alt fa-3x mb-3" style="color: var(--wm-gray);"></i>
                                            <p class="mb-0">Belum ada dokumen yang diunggah</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pengajuan.index') }}" class="btn"
                                style="background-color: var(--wm-gray); color: var(--wm-white); border: 1px solid rgba(255, 255, 255, 0.1);">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <div>
                                <a href="{{ route('admin.pengajuan.edit', $pengajuan->id_pengajuan) }}"
                                    class="btn btn-info">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="{{ route('admin.pengajuan.pdf', $pengajuan->id_pengajuan) }}"
                                    class="btn btn-primary" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i> Lihat PDF
                                </a>
                                <form action="{{ route('admin.pengajuan.destroy', $pengajuan->id_pengajuan) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        style="background: linear-gradient(90deg, #e74a3b, #be2617); border: none;"
                                        onclick="return confirm('Yakin ingin menghapus pengajuan ini?')">
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
