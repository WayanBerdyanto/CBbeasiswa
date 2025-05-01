@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Edit Pengajuan</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pengajuan.update', $pengajuan->id_pengajuan) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_beasiswa">Nama Beasiswa</label>
                                        <select name="nama_beasiswa" id="nama_beasiswa" class="form-control">
                                            @foreach ($beasiswas as $beasiswa)
                                                <option value="{{ $beasiswa->id_beasiswa }}" {{ $pengajuan->id_beasiswa == $beasiswa->id_beasiswa ? 'selected' : '' }}>{{ $beasiswa->nama_beasiswa }}</option>
                                            @endforeach
                                        </select>   
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="id_periode">Periode Beasiswa</label>
                                        <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror">
                                            <option value="">Pilih Periode</option>
                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id_periode }}" 
                                                    data-beasiswa="{{ $periode->id_beasiswa }}" 
                                                    class="periode-option" 
                                                    {{ $pengajuan->id_periode == $periode->id_periode ? 'selected' : '' }}
                                                    style="{{ $pengajuan->id_beasiswa == $periode->id_beasiswa ? '' : 'display: none;' }}">
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
                                <select name="nama_mahasiswa" class="form-control">
                                    @foreach ($mahasiswas as $mahasiswa)
                                        <option value="{{ $mahasiswa->id }}" {{ $pengajuan->id_mahasiswa == $mahasiswa->id ? 'selected' : '' }}>{{ $mahasiswa->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ipk">IPK Mahasiswa</label>
                                <input type="number" step="0.01" min="0" max="4.00" name="ipk" class="form-control @error('ipk') is-invalid @enderror" value="{{ $pengajuan->ipk }}" required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="status_pengajuan">Status Pengajuan</label>
                                <select name="status_pengajuan" class="form-control">
                                    <option value="diterima" {{ $pengajuan->status_pengajuan == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="diproses" {{ $pengajuan->status_pengajuan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="ditolak" {{ $pengajuan->status_pengajuan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                                <input type="date" name="tgl_pengajuan" class="form-control" value="{{ $pengajuan->tgl_pengajuan->format('Y-m-d') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="alasan_pengajuan">Alasan Pengajuan</label>
                                <textarea name="alasan_pengajuan" class="form-control">{{ $pengajuan->alasan_pengajuan }}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
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
