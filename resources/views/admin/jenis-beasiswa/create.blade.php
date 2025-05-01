@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                @if(isset($beasiswaId))
                    <a href="{{ route('admin.beasiswa.edit', $beasiswaId) }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beasiswa
                    </a>
                @else
                    <a href="{{ route('admin.jenis-beasiswa.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Jenis Beasiswa</h2>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.jenis-beasiswa.store') }}" method="post">
                            @csrf
                            @if(isset($beasiswaId))
                                <input type="hidden" name="beasiswa_id" value="{{ $beasiswaId }}">
                            @endif
                            <div class="form-group mb-4">
                                <label for="nama_jenis">Nama Jenis Beasiswa</label>
                                <input type="text" name="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" 
                                    id="nama_jenis" placeholder="Masukkan nama jenis beasiswa" value="{{ old('nama_jenis') }}">
                                @error('nama_jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                    id="deskripsi" placeholder="Masukkan deskripsi jenis beasiswa" rows="4">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end gap-4 my-4">
                                @if(isset($beasiswaId))
                                    <a href="{{ route('admin.beasiswa.edit', $beasiswaId) }}" class="btn btn-secondary">Batal</a>
                                @else
                                    <a href="{{ route('admin.jenis-beasiswa.index') }}" class="btn btn-secondary">Batal</a>
                                @endif
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 