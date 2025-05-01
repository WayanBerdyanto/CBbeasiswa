<!-- resources/views/admin/beasiswa/show.blade.php -->
@extends('admin.layouts.main')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Detail Mahasiswa</h1>
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Mahasiswa</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="text-blue-400">{{ $mahasiswa->nama }}</h5>
                        <span class="badge bg-primary">{{ $mahasiswa->nim }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Fakultas:</h6>
                        <p class="text-gray-300">{{ $mahasiswa->fakultas ?? $mahasiswa->jurusan }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Prodi:</h6>
                        <p class="text-gray-300">{{ $mahasiswa->prodi ?? $mahasiswa->jurusan }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Terakhir diperbarui:</h6>
                        <p class="text-gray-300">{{ $mahasiswa->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="card-footer bg-gray-800 border-0">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-info">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-12">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Persyaratan Beasiswa</h6>
                </div>
                <div class="card-body">
                    @if($mahasiswa->pengajuan && $mahasiswa->pengajuan->count() > 0)
                        @foreach($mahasiswa->pengajuan as $pengajuan)
                            <div class="mb-3 p-3 bg-gray-700 rounded">
                                <h6 class="text-white">IPK Minimal: <span class="text-warning">{{ $pengajuan->beasiswa->nama_beasiswa }}</span></h6>
                                <p class="text-gray-300">Dokumen: {{ $pengajuan->beasiswa->deskripsi }}</p>
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
                    <a href="{{ route('admin.pengajuan.create') }}?mahasiswa_id={{ $mahasiswa->id }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus mr-1"></i> Tambah Pengajuan
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
                        <span class="badge bg-primary">{{ $mahasiswa->pengajuan_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-white">Diterima:</span>
                        <span class="badge bg-success">{{ $mahasiswa->pengajuan_diterima_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-white">Diproses:</span>
                        <span class="badge bg-warning">{{ $mahasiswa->pengajuan_diproses_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white">Ditolak:</span>
                        <span class="badge bg-danger">{{ $mahasiswa->pengajuan_ditolak_count ?? 0 }}</span>
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