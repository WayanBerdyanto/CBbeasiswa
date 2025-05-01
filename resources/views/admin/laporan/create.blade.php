@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Buat Laporan</h1>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-gray-800 border-0 shadow mb-4">
                <div class="card-header bg-gradient-dark text-white">
                    <h6 class="m-0 font-weight-bold">Form Pembuatan Laporan</h6>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.laporan.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="jenis_laporan" class="text-white">Jenis Laporan</label>
                                    <select name="jenis_laporan" class="form-control @error('jenis_laporan') is-invalid @enderror" 
                                        id="jenis_laporan" required>
                                        <option value="">Pilih Jenis Laporan</option>
                                        <option value="pengajuan" {{ old('jenis_laporan') == 'pengajuan' ? 'selected' : '' }}>
                                            Laporan Pengajuan Beasiswa
                                        </option>
                                        <option value="beasiswa" {{ old('jenis_laporan') == 'beasiswa' ? 'selected' : '' }}>
                                            Laporan Data Beasiswa
                                        </option>
                                    </select>
                                    @error('jenis_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="id_jenis" class="text-white">Jenis Beasiswa (Opsional)</label>
                                    <select name="id_jenis" class="form-control @error('id_jenis') is-invalid @enderror" id="id_jenis">
                                        <option value="">Semua Jenis Beasiswa</option>
                                        @foreach ($jenisBeasiswas as $jenis)
                                            <option value="{{ $jenis->id_jenis }}" {{ old('id_jenis') == $jenis->id_jenis ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" id="date-filter-section">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="tanggal_mulai" class="text-white">Tanggal Mulai (Opsional)</label>
                                    <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                        id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="tanggal_selesai" class="text-white">Tanggal Selesai (Opsional)</label>
                                    <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                        id="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <div class="form-text text-white">
                                <i class="fas fa-info-circle me-1"></i> 
                                Anda dapat menggunakan filter untuk menghasilkan laporan yang lebih spesifik
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" name="export_type" value="view" class="btn btn-primary">
                                    <i class="fas fa-file-alt mr-1"></i> Lihat Laporan
                                </button>
                                <div class="btn-group ms-2">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-download mr-1"></i> Export
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button type="submit" name="export_type" value="excel" class="dropdown-item">
                                                <i class="fas fa-file-excel mr-2"></i> Export ke Excel
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="export_type" value="pdf" class="dropdown-item">
                                                <i class="fas fa-file-pdf mr-2"></i> Export ke PDF
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisLaporanSelect = document.getElementById('jenis_laporan');
        const dateFilterSection = document.getElementById('date-filter-section');
        
        // Function to toggle date filter visibility based on report type
        function toggleDateFilter() {
            const selectedValue = jenisLaporanSelect.value;
            
            if (selectedValue === 'pengajuan') {
                dateFilterSection.style.display = 'flex';
            } else {
                dateFilterSection.style.display = 'none';
            }
        }
        
        // Initialize on page load
        toggleDateFilter();
        
        // Update when selection changes
        jenisLaporanSelect.addEventListener('change', toggleDateFilter);
    });
</script>
@endpush 