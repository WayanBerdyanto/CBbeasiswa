<!-- resources/views/admin/beasiswa/show.blade.php -->
@extends('admin.layouts.main')

@section('title', 'Detail Beasiswa')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Detail Beasiswa</h1>
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Beasiswa</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="text-blue-400">{{ $beasiswa->nama_beasiswa }}</h5>
                        <span class="badge bg-primary">{{ $beasiswa->jenisBeasiswa ? $beasiswa->jenisBeasiswa->nama_jenis : 'Tidak ada jenis' }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Deskripsi:</h6>
                        <p class="text-gray-300">{{ $beasiswa->deskripsi }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Dibuat pada:</h6>
                        <p class="text-gray-300">{{ $beasiswa->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Terakhir diperbarui:</h6>
                        <p class="text-gray-300">{{ $beasiswa->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="card-footer bg-gray-800 border-0">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.beasiswa.edit', $beasiswa->id_beasiswa) }}" class="btn btn-info">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.beasiswa.destroy', $beasiswa->id_beasiswa) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus beasiswa ini?')">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Periode Beasiswa</h6>
                    <a href="{{ route('admin.periode.create') }}?id_beasiswa={{ $beasiswa->id_beasiswa }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Periode
                    </a>
                </div>
                <div class="card-body">
                    @if($beasiswa->periode && $beasiswa->periode->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover text-white">
                                <thead>
                                    <tr>
                                        <th>Nama Periode</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Kuota</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($beasiswa->periode as $periode)
                                        <tr>
                                            <td>{{ $periode->nama_periode }}</td>
                                            <td>{{ $periode->tanggal_mulai->format('d M Y') }}</td>
                                            <td>{{ $periode->tanggal_selesai->format('d M Y') }}</td>
                                            <td>{{ $periode->kuota }}</td>
                                            <td>
                                                <span class="badge bg-{{ $periode->status == 'aktif' ? 'success' : 'danger' }}">
                                                    {{ $periode->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.periode.show', $periode->id_periode) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-calendar-alt fa-2x text-gray-500 mb-2"></i>
                            <p class="text-gray-300">Belum ada periode yang dibuat untuk beasiswa ini.</p>
                            <a href="{{ route('admin.periode.create') }}?id_beasiswa={{ $beasiswa->id_beasiswa }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus mr-1"></i> Tambah Periode Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-12">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Persyaratan Beasiswa</h6>
                </div>
                <div class="card-body">
                    @if($beasiswa->syarat && $beasiswa->syarat->count() > 0)
                        @foreach($beasiswa->syarat as $syarat)
                            <div class="mb-3 p-3 bg-gray-700 rounded">
                                <h6 class="text-white">IPK Minimal: <span class="text-warning">{{ $syarat->syarat_ipk }}</span></h6>
                                <p class="text-gray-300">Dokumen: {{ $syarat->syarat_dokumen }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-info-circle fa-2x text-gray-500 mb-2"></i>
                            <p class="text-gray-300">Belum ada persyaratan yang ditetapkan.</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-gray-800 border-0">
                    <a href="{{ route('admin.syarat.create') }}?beasiswa_id={{ $beasiswa->id_beasiswa }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus mr-1"></i> Tambah Persyaratan
                    </a>
                </div>
            </div>
            
            <div class="card bg-gray-800 border-0 shadow">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Statistik Pengajuan</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-white">Total Pengajuan:</span>
                        <span class="badge bg-primary">{{ $beasiswa->pengajuan_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-white">Diterima:</span>
                        <span class="badge bg-success">{{ $beasiswa->pengajuan_diterima_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-white">Diproses:</span>
                        <span class="badge bg-warning">{{ $beasiswa->pengajuan_diproses_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white">Ditolak:</span>
                        <span class="badge bg-danger">{{ $beasiswa->pengajuan_ditolak_count ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gray-300 {
        color: #dddfeb;
    }
    .text-gray-500 {
        color: #b7b9cc;
    }
    .bg-gray-700 {
        background-color: #424554;
    }
</style>
@endsection