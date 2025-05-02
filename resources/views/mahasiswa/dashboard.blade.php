@extends('layouts.main')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-user-graduate text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="fs-4 fw-light mb-1">Selamat Datang, {{ $user->nama }}!</h2>
                            <p class="fw-light mb-0">NIM: {{ $user->nim }} | Jurusan: {{ $user->jurusan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-0 h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                            <i class="fas fa-file-alt text-primary"></i>
                        </div>
                        <h5 class="card-title fw-light mb-0">Total Pengajuan</h5>
                    </div>
                    <h3 class="display-5 fw-normal text-primary mb-0">{{ $totalPengajuan }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-0 h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h5 class="card-title fw-light mb-0">Diterima</h5>
                    </div>
                    <h3 class="display-5 fw-normal text-success mb-0">{{ $penerimaanDiterima }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                            style="width: {{ $totalPengajuan > 0 ? ($penerimaanDiterima / $totalPengajuan * 100) : 0 }}%;" 
                            aria-valuenow="{{ $totalPengajuan > 0 ? ($penerimaanDiterima / $totalPengajuan * 100) : 0 }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-0 h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                            <i class="fas fa-hourglass-half text-warning"></i>
                        </div>
                        <h5 class="card-title fw-light mb-0">Diproses</h5>
                    </div>
                    <h3 class="display-5 fw-normal text-warning mb-0">{{ $penerimaanDiproses }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                            style="width: {{ $totalPengajuan > 0 ? ($penerimaanDiproses / $totalPengajuan * 100) : 0 }}%;" 
                            aria-valuenow="{{ $totalPengajuan > 0 ? ($penerimaanDiproses / $totalPengajuan * 100) : 0 }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-2">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <h5 class="card-title fw-light mb-0">Ditolak</h5>
                    </div>
                    <h3 class="display-5 fw-normal text-danger mb-0">{{ $penerimaanDitolak }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" 
                            style="width: {{ $totalPengajuan > 0 ? ($penerimaanDitolak / $totalPengajuan * 100) : 0 }}%;" 
                            aria-valuenow="{{ $totalPengajuan > 0 ? ($penerimaanDitolak / $totalPengajuan * 100) : 0 }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-light"><i class="fas fa-history me-2"></i> Pengajuan Terbaru</h5>
                        <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-light fw-light">
                            <i class="fas fa-eye me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentPengajuan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 fw-light">Beasiswa</th>
                                        <th class="fw-light">Tanggal</th>
                                        <th class="fw-light">Status</th>
                                        <th class="fw-light">Dokumen</th>
                                        <th class="text-end pe-4 fw-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-light">
                                    @foreach($recentPengajuan as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                                    <i class="fas fa-graduation-cap text-primary"></i>
                                                </div>
                                                <span class="fw-normal">{{ $item->beasiswa->nama_beasiswa }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="far fa-calendar-alt me-1 text-light"></i>
                                            {{ $item->tgl_pengajuan->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if($item->status_pengajuan == 'diterima')
                                                <span class="badge bg-success rounded-pill px-3 py-2 fw-light">
                                                    <i class="fas fa-check-circle me-1"></i> Diterima
                                                </span>
                                            @elseif($item->status_pengajuan == 'ditolak')
                                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-light">
                                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                                </span>
                                            @else
                                                <span class="badge bg-warning rounded-pill px-3 py-2 fw-light">
                                                    <i class="fas fa-hourglass-half me-1"></i> Diproses
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary rounded-pill px-3 py-2 fw-light">
                                                <i class="fas fa-file-alt me-1"></i> {{ $item->dokumen->count() }} Dokumen
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-light">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <div class="rounded-circle bg-light mx-auto" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-alt fa-3x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3 fw-light">Anda belum memiliki pengajuan beasiswa</h5>
                            <p class="text-light mb-4 fw-light">Mulai ajukan beasiswa untuk mendapatkan bantuan pendidikan</p>
                            <a href="{{ route('beasiswa.index') }}" class="btn btn-primary rounded-pill px-4 fw-light">
                                <i class="fas fa-plus-circle me-2"></i> Ajukan Beasiswa Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Additional lightweight styling */
.display-5 {
    font-size: 2.5rem;
    letter-spacing: -0.5px;
}

.card {
    box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
}

.badge {
    font-weight: 400 !important;
    letter-spacing: 0.5px;
}

.table {
    font-size: 0.95rem;
}

.btn {
    font-weight: 400 !important;
    letter-spacing: 0.5px;
}
</style>
@endsection 