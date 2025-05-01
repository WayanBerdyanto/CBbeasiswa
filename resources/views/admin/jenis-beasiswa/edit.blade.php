@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Edit Jenis Beasiswa</h1>
                <a href="{{ route('admin.jenis-beasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 mx-auto">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Form Edit Jenis Beasiswa</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.jenis-beasiswa.update', $jenisBeasiswa->id_jenis) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if(isset($beasiswaId))
                            <input type="hidden" name="beasiswa_id" value="{{ $beasiswaId }}">
                        @endif
                        <div class="form-group mb-4">
                            <label for="nama_jenis" class="text-white">Nama Jenis Beasiswa</label>
                            <input type="text" name="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" 
                                id="nama_jenis" placeholder="Masukkan nama jenis beasiswa" 
                                value="{{ old('nama_jenis', $jenisBeasiswa->nama_jenis) }}">
                            @error('nama_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="deskripsi" class="text-white">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" placeholder="Masukkan deskripsi jenis beasiswa" rows="4">{{ old('deskripsi', $jenisBeasiswa->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            @if(isset($beasiswaId))
                                <a href="{{ route('admin.beasiswa.edit', $beasiswaId) }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            @else
                                <a href="{{ route('admin.jenis-beasiswa.show', $jenisBeasiswa->id_jenis) }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                        </div>
                    </form>
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