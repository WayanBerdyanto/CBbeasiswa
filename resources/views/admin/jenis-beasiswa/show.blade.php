@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Detail Jenis Beasiswa</h1>
                <a href="{{ route('admin.jenis-beasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Jenis Beasiswa</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="text-blue-400">{{ $jenisBeasiswa->nama_jenis }}</h5>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Deskripsi:</h6>
                        <p class="text-gray-300">{{ $jenisBeasiswa->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Dibuat pada:</h6>
                        <p class="text-gray-300">{{ $jenisBeasiswa->created_at ? $jenisBeasiswa->created_at->format('d M Y, H:i') : 'Tidak ada data' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-white">Terakhir diperbarui:</h6>
                        <p class="text-gray-300">{{ $jenisBeasiswa->updated_at ? $jenisBeasiswa->updated_at->format('d M Y, H:i') : 'Tidak ada data' }}</p>
                    </div>
                </div>
                <div class="card-footer bg-gray-800 border-0">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.jenis-beasiswa.edit', $jenisBeasiswa->id_jenis) }}" class="btn btn-info">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.jenis-beasiswa.destroy', $jenisBeasiswa->id_jenis) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jenis beasiswa ini?')">
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
                    <h6 class="m-0 font-weight-bold">Beasiswa yang Terkait</h6>
                </div>
                <div class="card-body">
                    @if($jenisBeasiswa->beasiswas && $jenisBeasiswa->beasiswas->count() > 0)
                        <div class="list-group">
                            @foreach($jenisBeasiswa->beasiswas as $beasiswa)
                                <a href="{{ route('admin.beasiswa.show', $beasiswa->id_beasiswa) }}" 
                                   class="list-group-item list-group-item-action bg-gray-700 text-white border-0 mb-2 rounded">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $beasiswa->nama_beasiswa }}</h6>
                                    </div>
                                    <small class="text-gray-300">{{ \Illuminate\Support\Str::limit($beasiswa->deskripsi, 50) }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-info-circle fa-2x text-gray-500 mb-2"></i>
                            <p class="text-gray-300">Belum ada beasiswa yang menggunakan jenis ini.</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-gray-800 border-0">
                    <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus mr-1"></i> Tambah Beasiswa Baru
                    </a>
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
    .list-group-item:hover {
        background-color: #383b4c !important;
    }
</style>
@endsection 