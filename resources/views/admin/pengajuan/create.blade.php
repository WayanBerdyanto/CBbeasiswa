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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_beasiswa">Nama Beasiswa</label>
                                        <select name="nama_beasiswa" id="nama_beasiswa" class="form-control @error('nama_beasiswa') is-invalid @enderror">
                                            <option value="">Pilih Beasiswa</option>
                                            @foreach ($beasiswas as $beasiswa)
                                                <option value="{{ $beasiswa->id_beasiswa }}">{{ $beasiswa->nama_beasiswa }}</option>
                                            @endforeach
                                        </select>
                                        @error('nama_beasiswa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="id_periode">Periode Beasiswa</label>
                                        <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror">
                                            <option value="">Pilih Periode</option>
                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id_periode }}" data-beasiswa="{{ $periode->id_beasiswa }}" class="periode-option" style="display: none;">
                                                    {{ $periode->nama_periode }} ({{ $periode->tanggal_mulai->format('d M Y') }} - {{ $periode->tanggal_selesai->format('d M Y') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_periode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
                                <label for="ipk">IPK Mahasiswa</label>
                                <input type="number" step="0.01" min="0" max="4.00" name="ipk" class="form-control @error('ipk') is-invalid @enderror" placeholder="Contoh: 3.50" required>
                                @error('ipk')
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const beasiswaSelect = document.getElementById('nama_beasiswa');
        const periodeOptions = document.querySelectorAll('.periode-option');
        
        // Filter periode options based on selected beasiswa
        beasiswaSelect.addEventListener('change', function() {
            const beasiswaId = this.value;
            const periodeSelect = document.getElementById('id_periode');
            
            // Reset periode selection
            periodeSelect.value = '';
            
            // Hide all options first
            periodeOptions.forEach(option => {
                option.style.display = 'none';
            });
            
            // Show only relevant options
            if (beasiswaId) {
                periodeOptions.forEach(option => {
                    if (option.dataset.beasiswa === beasiswaId) {
                        option.style.display = 'block';
                    }
                });
            }
        });
    });
</script>
@endpush
