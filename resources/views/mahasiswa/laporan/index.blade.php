@extends('layouts.main')

@section('title', 'Laporan Beasiswa')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="fas fa-file-alt text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h2 class="fs-4 fw-light mb-1">Laporan Pengajuan Beasiswa</h2>
                                <p class="fw-light mb-0">{{ $mahasiswa->nama }} | {{ $mahasiswa->nim }}</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('report.view.pdf') }}" class="btn btn-info me-2" target="_blank">
                                <i class="fas fa-eye me-2"></i> Lihat PDF
                            </a>
                            <a href="{{ route('report.export.pdf') }}" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i> Unduh PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
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
                    <h3 class="display-5 fw-normal text-primary mb-0">{{ $stats['total_pengajuan'] }}</h3>
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
                    <h3 class="display-5 fw-normal text-success mb-0">{{ $stats['pengajuan_diterima'] }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                            style="width: {{ $stats['total_pengajuan'] > 0 ? ($stats['pengajuan_diterima'] / $stats['total_pengajuan'] * 100) : 0 }}%;" 
                            aria-valuenow="{{ $stats['total_pengajuan'] > 0 ? ($stats['pengajuan_diterima'] / $stats['total_pengajuan'] * 100) : 0 }}" 
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
                    <h3 class="display-5 fw-normal text-warning mb-0">{{ $stats['pengajuan_diproses'] }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                            style="width: {{ $stats['total_pengajuan'] > 0 ? ($stats['pengajuan_diproses'] / $stats['total_pengajuan'] * 100) : 0 }}%;" 
                            aria-valuenow="{{ $stats['total_pengajuan'] > 0 ? ($stats['pengajuan_diproses'] / $stats['total_pengajuan'] * 100) : 0 }}" 
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
                    <h3 class="display-5 fw-normal text-danger mb-0">{{ $stats['pengajuan_ditolak'] }}</h3>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" 
                            style="width: {{ $stats['total_pengajuan'] > 0 ? ($stats['pengajuan_ditolak'] / $stats['total_pengajuan'] * 100) : 0 }}%;" 
                            aria-valuenow="{{ $stats['total_pengajuan'] > 0 ? ($stats['pengajuan_ditolak'] / $stats['total_pengajuan'] * 100) : 0 }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-light"><i class="fas fa-chart-bar me-2"></i> Statistik Pengajuan Bulanan</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyStatisticsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-light"><i class="fas fa-chart-pie me-2"></i> Pengajuan Berdasarkan Jenis</h5>
                </div>
                <div class="card-body">
                    @if(count($pengajuanByJenis) > 0)
                        <canvas id="applicationTypeChart" height="300"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-light mb-3"></i>
                            <p class="text-light">Belum ada data pengajuan berdasarkan jenis</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-light"><i class="fas fa-list me-2"></i> Daftar Pengajuan Beasiswa</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($pengajuanList->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 fw-light">Beasiswa</th>
                                        <th class="fw-light">Jenis</th>
                                        <th class="fw-light">Tanggal Pengajuan</th>
                                        <th class="fw-light">Status</th>
                                        <th class="fw-light">Dokumen</th>
                                        <th class="text-end pe-4 fw-light">Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-light">
                                    @foreach($pengajuanList as $pengajuan)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                                    <i class="fas fa-graduation-cap text-primary"></i>
                                                </div>
                                                <span class="fw-normal">{{ $pengajuan->beasiswa->nama_beasiswa }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $pengajuan->beasiswa->jenisBeasiswa->nama_jenis }}
                                        </td>
                                        <td>
                                            <i class="far fa-calendar-alt me-1 text-light"></i>
                                            {{ $pengajuan->tgl_pengajuan->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if($pengajuan->status_pengajuan == 'diterima')
                                                <span class="badge bg-success rounded-pill px-3 py-2 fw-light">
                                                    <i class="fas fa-check-circle me-1"></i> Diterima
                                                </span>
                                            @elseif($pengajuan->status_pengajuan == 'ditolak')
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
                                                <i class="fas fa-file-alt me-1"></i> {{ $pengajuan->dokumen->count() }} Dokumen
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('report.pengajuan.detail', $pengajuan->id_pengajuan) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-light">
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get months data
        const monthLabels = {!! json_encode(array_keys($monthlyStats)) !!};
        const monthlyData = {
            total: [],
            diterima: [],
            diproses: [],
            ditolak: []
        };
        
        // Prepare monthly data for chart
        @foreach($monthlyStats as $month => $data)
            monthlyData.total.push({{ $data['total'] }});
            monthlyData.diterima.push({{ $data['diterima'] }});
            monthlyData.diproses.push({{ $data['diproses'] }});
            monthlyData.ditolak.push({{ $data['ditolak'] }});
        @endforeach
        
        // Monthly statistics chart
        const monthlyStatisticsCtx = document.getElementById('monthlyStatisticsChart').getContext('2d');
        new Chart(monthlyStatisticsCtx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: 'Diterima',
                        data: monthlyData.diterima,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Diproses',
                        data: monthlyData.diproses,
                        backgroundColor: 'rgba(255, 193, 7, 0.7)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Ditolak',
                        data: monthlyData.ditolak,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Pengajuan by Jenis Beasiswa Chart
        @if(count($pengajuanByJenis) > 0)
            // Prepare data for pie chart
            const jenisLabels = [];
            const jenisData = [];
            const backgroundColors = [
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(199, 199, 199, 0.7)',
                'rgba(83, 102, 255, 0.7)',
                'rgba(40, 159, 64, 0.7)',
                'rgba(210, 199, 199, 0.7)'
            ];
            
            @foreach($pengajuanByJenis as $index => $jenis)
                jenisLabels.push('{{ $jenis->nama_jenis }}');
                jenisData.push({{ $jenis->total }});
            @endforeach
            
            const applicationTypeCtx = document.getElementById('applicationTypeChart').getContext('2d');
            new Chart(applicationTypeCtx, {
                type: 'pie',
                data: {
                    labels: jenisLabels,
                    datasets: [{
                        data: jenisData,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        @endif
    });
</script>
@endpush 