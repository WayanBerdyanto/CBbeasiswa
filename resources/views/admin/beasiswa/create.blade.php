@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    &nbsp; Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Beasiswa</h2>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.beasiswa.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="nama_beasiswa">Nama Beasiswa</label>
                                <input type="text" name="nama_beasiswa" class="form-control @error('nama_beasiswa') is-invalid @enderror" 
                                    id="nama_beasiswa" placeholder="Masukkan nama beasiswa" value="{{ old('nama_beasiswa') }}">
                                @error('nama_beasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="id_jenis">Jenis Beasiswa</label>
                                <div class="d-flex">
                                    <select name="id_jenis" class="form-control @error('id_jenis') is-invalid @enderror" id="id_jenis">
                                        <option value="">Pilih Jenis Beasiswa</option>
                                        @foreach ($jenisBeasiswas as $jenis)
                                            <option value="{{ $jenis->id_jenis }}" {{ old('id_jenis') == $jenis->id_jenis ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('admin.jenis-beasiswa.create') }}?beasiswa_id=new" class="btn btn-success ms-2" id="newJenisBtn">
                                        <i class="fas fa-plus"></i> Baru
                                    </a>
                                </div>
                                @error('id_jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Beasiswa</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nominal">Nominal Beasiswa (Rp)</label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal', 0) }}" min="0" required>
                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end gap-4 my-4">
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
        // Check if there's a selected jenis id in the session
        const selectedJenisId = "{{ session('selected_jenis_id') }}";
        if (selectedJenisId) {
            const jenisSelect = document.getElementById('id_jenis');
            if (jenisSelect) {
                jenisSelect.value = selectedJenisId;
            }
        }
    });
</script>
@endpush
