@extends('admin.layouts.main')

@section('title', 'Nominal Beasiswa - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Nominal Beasiswa</h1>
        <a href="{{ route('admin.pengajuan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Nominal Beasiswa untuk Pengajuan #{{ $pengajuan->id_pengajuan }}</h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informasi Mahasiswa</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>: {{ $pengajuan->mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <th>NIM</th>
                            <td>: {{ $pengajuan->mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th>Fakultas</th>
                            <td>: {{ $pengajuan->mahasiswa->fakultas }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>: {{ $pengajuan->mahasiswa->jurusan }}</td>
                        </tr>
                        <tr>
                            <th>IPK</th>
                            <td>: {{ $pengajuan->mahasiswa->ipk_terakhir }}</td>
                        </tr>
                        <tr>
                            <th>Total Beasiswa Diterima</th>
                            <td>: Rp {{ number_format($pengajuan->mahasiswa->total_received_scholarship, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Beasiswa</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Beasiswa</th>
                            <td>: {{ $pengajuan->beasiswa->nama_beasiswa }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>: {{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nominal Default</th>
                            <td>: Rp {{ number_format($pengajuan->beasiswa->nominal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status Pengajuan</th>
                            <td>: 
                                @if($pengajuan->status_pengajuan == 'diproses')
                                    <span class="badge badge-warning">Diproses</span>
                                @elseif($pengajuan->status_pengajuan == 'diterima')
                                    <span class="badge badge-success">Diterima</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nominal Disetujui</th>
                            <td>: Rp {{ number_format($pengajuan->nominal_approved ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>: {{ $pengajuan->tgl_pengajuan->format('d-m-Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h5>Pengaturan Nominal Beasiswa</h5>
                    <form action="{{ route('admin.pengajuan.nominal.update', $pengajuan->id_pengajuan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nominal_approved">Nominal Beasiswa yang Disetujui</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control @error('nominal_approved') is-invalid @enderror" 
                                    id="nominal_approved" name="nominal_approved" 
                                    value="{{ old('nominal_approved', $pengajuan->nominal_approved ?? $pengajuan->beasiswa->nominal) }}" 
                                    required min="0">
                            </div>
                            @error('nominal_approved')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_pengajuan">Status Pengajuan</label>
                            <select class="form-control @error('status_pengajuan') is-invalid @enderror" 
                                id="status_pengajuan" name="status_pengajuan" required>
                                <option value="diproses" {{ $pengajuan->status_pengajuan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="diterima" {{ $pengajuan->status_pengajuan == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $pengajuan->status_pengajuan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Jika status pengajuan diterima, nominal beasiswa akan ditambahkan ke total beasiswa yang diterima mahasiswa.
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('admin.pengajuan.nominal.default', $pengajuan->id_pengajuan) }}" 
                                class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengatur nominal ke nilai default beasiswa?')">
                                Set Nominal Default
                            </a>
                            <a href="{{ route('admin.pengajuan.show', $pengajuan->id_pengajuan) }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 