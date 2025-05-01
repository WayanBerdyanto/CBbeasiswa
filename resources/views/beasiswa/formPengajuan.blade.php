@extends('layouts.main')

@section('title', 'Form Pengajuan Beasiswa')

@section('content')
    <div class="container mt-5 text-white">
        <h2 class="text-center text-blue-400 mb-4">Form Pengajuan Beasiswa</h2>

        <div class="card bg-gray-800 p-4">
            <form action="{{ route('pengajuan.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id_beasiswa" value="{{ $syarat->id_beasiswa }}">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-control" value="{{ $user->nim }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">IPK Anda (Minimal: {{ $syarat->syarat_ipk }})</label>
                    <input type="number" name="ipk" class="form-control" step="0.01" min="0" max="4" value="{{ old('ipk', $user->ipk ?? '') }}" required>
                </div>
                

                <div class="mb-3">
                    <label class="form-label">Alasan Pengajuan</label>
                    <textarea name="alasan_pengajuan" class="form-control" rows="3" required>{{ old('alasan_pengajuan') }}</textarea>
                </div>

                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">Dokumen Pendukung</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" class="form-control" name="nama_dokumen" value="{{ old('nama_dokumen') }}" placeholder="Contoh: Transkrip Nilai, KTM, Surat Keterangan, dll." required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Upload Dokumen Persyaratan</label>
                        <input type="file" class="form-control" name="dokumen_file" required>
                        <small class="text-muted">Format yang diperbolehkan: PDF, JPG, JPEG, PNG. Ukuran maksimal: 5MB</small>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Setelah pengajuan berhasil dibuat, Anda dapat menambahkan dokumen pendukung lainnya.
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
@endsection
