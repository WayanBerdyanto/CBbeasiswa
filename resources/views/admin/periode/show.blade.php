@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Detail Periode Beasiswa</h2>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Informasi Periode</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="30%">Nama Periode</th>
                                                <td>{{ $periode->nama_periode }}</td>
                                            </tr>
                                            <tr>
                                                <th>Beasiswa</th>
                                                <td>
                                                    <a href="{{ route('admin.beasiswa.show', $periode->beasiswa->id_beasiswa) }}">
                                                        {{ $periode->beasiswa->nama_beasiswa }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Beasiswa</th>
                                                <td>{{ $periode->beasiswa->jenisBeasiswa ? $periode->beasiswa->jenisBeasiswa->nama_jenis : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Mulai</th>
                                                <td>{{ $periode->tanggal_mulai->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Selesai</th>
                                                <td>{{ $periode->tanggal_selesai->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kuota</th>
                                                <td>{{ $periode->kuota }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="badge bg-{{ $periode->status == 'aktif' ? 'success' : 'danger' }}">
                                                        {{ $periode->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Dibuat Pada</th>
                                                <td>{{ $periode->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Terakhir Update</th>
                                                <td>{{ $periode->updated_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Statistik Pengajuan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="card bg-primary text-white">
                                                    <div class="card-body py-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-0">Total Pengajuan</h6>
                                                                <h2 class="mb-0">{{ $periode->total_pengajuan }}</h2>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-file-alt fa-3x"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="card bg-success text-white">
                                                    <div class="card-body py-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-0">Diterima</h6>
                                                                <h2 class="mb-0">{{ $periode->pengajuan_diterima }}</h2>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-check-circle fa-3x"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="card bg-warning text-white">
                                                    <div class="card-body py-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-0">Diproses</h6>
                                                                <h2 class="mb-0">{{ $periode->pengajuan_diproses }}</h2>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-spinner fa-3x"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="card bg-danger text-white">
                                                    <div class="card-body py-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-0">Ditolak</h6>
                                                                <h2 class="mb-0">{{ $periode->pengajuan_ditolak }}</h2>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-times-circle fa-3x"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="progress mb-4" style="height: 25px;">
                                            @php
                                                $persenDiterima = $periode->total_pengajuan > 0 ? ($periode->pengajuan_diterima / $periode->total_pengajuan) * 100 : 0;
                                                $persenDiproses = $periode->total_pengajuan > 0 ? ($periode->pengajuan_diproses / $periode->total_pengajuan) * 100 : 0;
                                                $persenDitolak = $periode->total_pengajuan > 0 ? ($periode->pengajuan_ditolak / $periode->total_pengajuan) * 100 : 0;
                                            @endphp
                                            
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenDiterima }}%" 
                                                aria-valuenow="{{ $persenDiterima }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($persenDiterima, 1) }}%
                                            </div>
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenDiproses }}%" 
                                                aria-valuenow="{{ $persenDiproses }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($persenDiproses, 1) }}%
                                            </div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $persenDitolak }}%" 
                                                aria-valuenow="{{ $persenDitolak }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($persenDitolak, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <a href="{{ route('admin.periode.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <a href="{{ route('admin.periode.edit', $periode->id_periode) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                            </div>
                            <form action="{{ route('admin.periode.toggle-status', $periode->id_periode) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $periode->status == 'aktif' ? 'warning' : 'success' }}"
                                    onclick="return confirm('{{ $periode->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} periode ini?')">
                                    <i class="fas fa-{{ $periode->status == 'aktif' ? 'toggle-off' : 'toggle-on' }} me-1"></i>
                                    {{ $periode->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} Periode
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 