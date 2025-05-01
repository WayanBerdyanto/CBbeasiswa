@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-start mb-4">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card p-4">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Mahasiswa</h2>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    
                        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nim">NIM</label>
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" maxlength="8" placeholder="Masukkan NIM" required>
                                        @error('nim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="fakultas">Fakultas</label>
                                        <input type="text" class="form-control @error('fakultas') is-invalid @enderror" id="fakultas" name="fakultas" value="{{ old('fakultas') }}" placeholder="Masukkan Fakultas" required>
                                        @error('fakultas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="prodi">Prodi</label>
                                        <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi') }}" placeholder="Masukkan Prodi" required>
                                        @error('prodi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="angkatan">Angkatan</label>
                                        <input type="text" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" value="{{ old('angkatan') }}" placeholder="Masukkan Angkatan" required>
                                        @error('angkatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="gender">Jenis Kelamin</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="syarat_lpk">Syarat LPK</label>
                                        <input type="number" class="form-control @error('syarat_lpk') is-invalid @enderror" id="syarat_lpk" name="syarat_lpk" value="{{ old('syarat_lpk', 0) }}" min="0">
                                        @error('syarat_lpk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <small>Password akan dibuat otomatis: "mahasiswa123"</small><br>
                                <small>Email akan dibuat otomatis dari NIM: "nim@student.ac.id"</small>
                            </div>

                            <div class="d-flex justify-content-end gap-4 my-4">
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
