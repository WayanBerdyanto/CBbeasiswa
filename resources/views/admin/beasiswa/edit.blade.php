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
                        <h2>Edit Beasiswa</h2>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.beasiswa.update', $beasiswa->id_beasiswa) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-4">
                                <label for="nama_beasiswa">Nama Beasiswa</label>
                                <input type="text" name="nama_beasiswa" class="form-control @error('nama_beasiswa') is-invalid @enderror" 
                                    id="nama_beasiswa" placeholder="Masukkan nama beasiswa" 
                                    value="{{ old('nama_beasiswa', $beasiswa->nama_beasiswa) }}">
                                @error('nama_beasiswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="id_jenis">Jenis Beasiswa</label>
                                <div class="input-group">
                                    <select name="id_jenis" class="form-control @error('id_jenis') is-invalid @enderror" id="id_jenis">
                                        <option value="">Pilih Jenis Beasiswa</option>
                                        @foreach ($jenisBeasiswas as $jenis)
                                            <option value="{{ $jenis->id_jenis }}" 
                                                {{ (old('id_jenis', $beasiswa->id_jenis) == $jenis->id_jenis) ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append d-flex">
                                        <a href="#" id="editJenisBtn" class="btn btn-info disabled">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.jenis-beasiswa.create') }}?beasiswa_id={{ $beasiswa->id_beasiswa }}" class="btn btn-success ms-2">
                                            <i class="fas fa-plus"></i> Baru
                                        </a>
                                    </div>
                                </div>
                                @error('id_jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                    id="deskripsi" placeholder="Masukkan deskripsi beasiswa" 
                                    rows="4">{{ old('deskripsi', $beasiswa->deskripsi) }}</textarea>
                                @error('deskripsi')
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
        const jenisSelect = document.getElementById('id_jenis');
        const editJenisBtn = document.getElementById('editJenisBtn');
        const beasiswaId = '{{ $beasiswa->id_beasiswa }}';
        
        // Function to update the edit button
        function updateEditButton() {
            const selectedJenisId = jenisSelect.value;
            if (selectedJenisId) {
                editJenisBtn.href = `{{ url('admin/jenis-beasiswa') }}/${selectedJenisId}/edit?beasiswa_id=${beasiswaId}`;
                editJenisBtn.classList.remove('disabled');
            } else {
                editJenisBtn.href = '#';
                editJenisBtn.classList.add('disabled');
            }
        }
        
        // Initialize on page load
        updateEditButton();
        
        // Update when selection changes
        jenisSelect.addEventListener('change', updateEditButton);
    });
</script>
@endpush
