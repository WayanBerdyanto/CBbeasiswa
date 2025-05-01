@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-blue-400 font-weight-bold">Laporan Sistem</h1>
                <a href="{{ route('admin.laporan.create') }}" class="btn btn-primary">
                    <i class="fas fa-file-alt mr-1"></i> Buat Laporan Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Beasiswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_beasiswa'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Jenis Beasiswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_jenis'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Mahasiswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_mahasiswa'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pengajuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_pengajuan'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pengajuan -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengajuan Beasiswa</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Export Options:</div>
                            <a class="dropdown-item" href="{{ route('admin.laporan.export') }}?jenis_laporan=pengajuan&format=excel">
                                <i class="fas fa-file-excel mr-2"></i> Export to Excel
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.laporan.export') }}?jenis_laporan=pengajuan&format=pdf">
                                <i class="fas fa-file-pdf mr-2"></i> Export to PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Diterima ({{ $stats['pengajuan_diterima'] }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Ditolak ({{ $stats['pengajuan_ditolak'] }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Diproses ({{ $stats['pengajuan_diproses'] }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Beasiswa per Jenis -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Beasiswa per Jenis</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Jenis Beasiswa</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($beasiswaByType as $type)
                                <tr>
                                    <td>{{ $type->nama_jenis }}</td>
                                    <td>{{ $type->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan per Beasiswa -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengajuan per Beasiswa</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Beasiswa</th>
                                    <th>Diterima</th>
                                    <th>Ditolak</th>
                                    <th>Diproses</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanByBeasiswa as $item)
                                <tr>
                                    <td>{{ $item->nama_beasiswa }}</td>
                                    <td class="text-success">{{ $item->diterima }}</td>
                                    <td class="text-danger">{{ $item->ditolak }}</td>
                                    <td class="text-warning">{{ $item->diproses }}</td>
                                    <td><strong>{{ $item->total }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opsi Export -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Export Laporan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan.export') }}" method="get" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_laporan">Jenis Laporan</label>
                                <select name="jenis_laporan" class="form-control" id="jenis_laporan" required>
                                    <option value="">Pilih Jenis Laporan</option>
                                    <option value="beasiswa">Data Beasiswa</option>
                                    <option value="pengajuan">Data Pengajuan</option>
                                    <option value="mahasiswa">Data Mahasiswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="id_jenis">Jenis Beasiswa</label>
                                <select name="id_jenis" class="form-control" id="export_id_jenis">
                                    <option value="">Semua Jenis Beasiswa</option>
                                    @foreach(App\Models\JenisBeasiswa::all() as $jenis)
                                        <option value="{{ $jenis->id_jenis }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="format">Format</label>
                                <select name="format" class="form-control" id="format" required>
                                    <option value="">Pilih Format</option>
                                    <option value="excel">Excel</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                        </div>
                        
                        <div class="col-md-12 mt-3" id="date_filter_container" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_selesai">Tanggal Selesai</label>
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
        // Status Pie Chart
        var ctxPie = document.getElementById('statusChart');
        var myPieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Diterima', 'Ditolak', 'Diproses'],
                datasets: [{
                    data: [
                        {{ $stats['pengajuan_diterima'] }},
                        {{ $stats['pengajuan_ditolak'] }},
                        {{ $stats['pengajuan_diproses'] }}
                    ],
                    backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e'],
                    hoverBackgroundColor: ['#17a673', '#c23b2b', '#dda20a'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
        
        // Toggle date filter visibility based on report type
        const jenisLaporanSelect = document.getElementById('jenis_laporan');
        const dateFilterContainer = document.getElementById('date_filter_container');
        
        if (jenisLaporanSelect && dateFilterContainer) {
            jenisLaporanSelect.addEventListener('change', function() {
                if (this.value === 'pengajuan') {
                    dateFilterContainer.style.display = 'block';
                } else {
                    dateFilterContainer.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush 