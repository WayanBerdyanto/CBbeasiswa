@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Periode Beasiswa</h2>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.periode.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="id_beasiswa" class="form-label">Beasiswa</label>
                                        <select name="id_beasiswa" id="id_beasiswa"
                                            class="form-control @error('id_beasiswa') is-invalid @enderror" required>
                                            <option value="">Pilih Beasiswa</option>
                                            @foreach ($beasiswas as $beasiswa)
                                                <option value="{{ $beasiswa->id_beasiswa }}"
                                                    {{ old('id_beasiswa', $selectedBeasiswaId) == $beasiswa->id_beasiswa ? 'selected' : '' }}>
                                                    {{ $beasiswa->nama_beasiswa }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_beasiswa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_periode" class="form-label">Nama Periode</label>
                                        <input type="text" name="nama_periode" id="nama_periode"
                                            class="form-control @error('nama_periode') is-invalid @enderror"
                                            value="{{ old('nama_periode') }}" required>
                                        @error('nama_periode')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                            class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                            value="{{ old('tanggal_mulai') }}" required>
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                            class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                            value="{{ old('tanggal_selesai') }}" required>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="kuota" class="form-label">Kuota</label>
                                        <input type="number" name="kuota" id="kuota"
                                            class="form-control @error('kuota') is-invalid @enderror"
                                            value="{{ old('kuota', 0) }}" min="0" required>
                                        @error('kuota')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="tidak_aktif"
                                                {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.periode.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date for tanggal_selesai based on tanggal_mulai
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');

            tanggalMulai.addEventListener('change', function() {
                tanggalSelesai.min = this.value;
                if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                    tanggalSelesai.value = this.value;
                }
            });
        });
    </script>
@endpush
