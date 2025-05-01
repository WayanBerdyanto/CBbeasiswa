@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-start mb-4">
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Pengajuan</h2>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.pengajuan.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nama_beasiswa">Nama Beasiswa</label>
                                <select name="nama_beasiswa" class="form-control @error('nama_beasiswa') is-invalid @enderror">
                                    <option value="">Pilih Beasiswa</option>
                                    @foreach ($beasiswas as $beasiswa)
                                        <option value="{{ $beasiswa->id_beasiswa }}">{{ $beasiswa->nama_beasiswa }}</option>
                                    @endforeach
                                </select>
                                @error('nama_beasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_mahasiswa">Nama Mahasiswa</label>
                                <select name="nama_mahasiswa" class="form-control @error('nama_mahasiswa') is-invalid @enderror">
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach ($mahasiswas as $mahasiswa)
                                        <option value="{{ $mahasiswa->id }}" {{ isset($selectedMahasiswaId) && $selectedMahasiswaId == $mahasiswa->id ? 'selected' : '' }}>
                                            {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('nama_mahasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="status_pengajuan">Status Pengajuan</label>
                                <select name="status_pengajuan" class="form-control @error('status_pengajuan') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="diproses" selected>Diproses</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                                @error('status_pengajuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                                <input type="date" name="tgl_pengajuan" class="form-control @error('tgl_pengajuan') is-invalid @enderror" value="{{ date('Y-m-d') }}">
                                @error('tgl_pengajuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="alasan_pengajuan">Alasan Pengajuan</label>
                                <textarea name="alasan_pengajuan" class="form-control @error('alasan_pengajuan') is-invalid @enderror" rows="4"></textarea>
                                @error('alasan_pengajuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">Batal</a>
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
