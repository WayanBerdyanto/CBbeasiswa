@extends('admin.layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h1 class="text-blue-400 font-weight-bold">Dashboard Admin Beasiswa</h1>
                <p class="text-gray-300">Ringkasan statistik dan aktivitas terbaru sistem beasiswa</p>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-gradient-primary border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Beasiswa</div>
                                <div class="h5 mb-0 font-weight-bold text-white">{{ $totalBeasiswa }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-graduation-cap fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.beasiswa.index') }}" class="text-white small">Lihat detail <i
                                    class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-gradient-info border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Periode</div>
                                <div class="h5 mb-0 font-weight-bold text-white">{{ $totalPeriode }}</div>
                                <div class="small text-white">{{ $aktivePeriode }} Periode Aktif</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.periode.index') }}" class="text-white small">Lihat detail <i
                                    class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-gradient-success border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pengajuan Diterima
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-white">{{ $penerimaanDiterima }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.pengajuan.filter') }}?status=diterima" class="text-white small">Lihat
                                detail <i class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-gradient-warning border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pengajuan Diproses
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-white">{{ $penerimaanDiproses }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-white-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.pengajuan.filter') }}?status=diproses" class="text-white small">Lihat
                                detail <i class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Periods aktif saat ini -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gray-800 border-0 shadow">
                    <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Periode Beasiswa Aktif Saat Ini</h6>
                        <a href="{{ route('admin.periode.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Periode
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-white" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Periode</th>
                                        <th>Beasiswa</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Kuota</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($currentPeriods as $periode)
                                        <tr>
                                            <td>{{ $periode->nama_periode }}</td>
                                            <td>{{ $periode->beasiswa->nama_beasiswa }}</td>
                                            <td>{{ $periode->tanggal_mulai->format('d M Y') }}</td>
                                            <td>{{ $periode->tanggal_selesai->format('d M Y') }}</td>
                                            <td>{{ $periode->kuota }}</td>
                                            <td>
                                                <a href="{{ route('admin.periode.show', $periode->id_periode) }}"
                                                    class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada periode aktif saat ini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.periode.index') }}" class="btn btn-info">Kelola Semua Periode</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Terbaru -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gray-800 border-0 shadow">
                    <div class="card-header bg-gradient-dark text-white">
                        <h6 class="m-0 font-weight-bold">Pengajuan Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-white" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                        <th>Beasiswa</th>
                                        <th>Periode</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestPengajuan as $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuan->mahasiswa->nama }}</td>
                                            <td>{{ $pengajuan->beasiswa->nama_beasiswa }}</td>
                                            <td>{{ $pengajuan->periode ? $pengajuan->periode->nama_periode : 'N/A' }}</td>
                                            <td>{{ $pengajuan->tgl_pengajuan->format('d M Y') }}</td>
                                            <td>
                                                @if ($pengajuan->status_pengajuan == 'diterima')
                                                    <span class="badge"
                                                        style="background: linear-gradient(90deg, #1cc88a, #13855c);">Diterima</span>
                                                @elseif($pengajuan->status_pengajuan == 'ditolak')
                                                    <span class="badge"
                                                        style="background: linear-gradient(90deg, #e74a3b, #be2617);">Ditolak</span>
                                                @else
                                                    <span class="badge"
                                                        style="background: linear-gradient(90deg, #f6c23e, #dda20a);">Diproses</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pengajuan.show', $pengajuan->id_pengajuan) }}"
                                                    class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('admin.pengajuan.edit', $pengajuan->id_pengajuan) }}"
                                                    class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <form
                                                    action="{{ route('admin.pengajuan.destroy', $pengajuan->id_pengajuan) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada pengajuan beasiswa</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-primary">Lihat Semua
                                Pengajuan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dua Card Informasi -->
        <div class="row">
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card bg-gray-800 border-0 shadow">
                    <div class="card-header bg-gradient-dark text-white">
                        <h6 class="m-0 font-weight-bold">Beasiswa Paling Diminati</h6>
                    </div>
                    <div class="card-body">
                        @forelse($popularBeasiswa as $index => $beasiswa)
                            <div class="progress-container mb-3">
                                <span class="text-white">{{ $beasiswa->nama_beasiswa }}</span>
                                <div class="progress mt-1">
                                    <div class="progress-bar 
                                @if ($index % 5 == 0) bg-primary 
                                @elseif($index % 5 == 1) bg-info 
                                @elseif($index % 5 == 2) bg-warning 
                                @elseif($index % 5 == 3) bg-danger 
                                @else bg-success @endif"
                                        role="progressbar" style="width: {{ $beasiswa->percentage }}%">
                                        {{ $beasiswa->percentage }}%</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-white text-center">Belum ada data beasiswa</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card bg-gray-800 border-0 shadow">
                    <div class="card-header bg-gradient-dark text-white">
                        <h6 class="m-0 font-weight-bold">Aktivitas Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @forelse($latestActivity as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-item-content">
                                        <span class="text-white"><strong>Pengajuan</strong>
                                            {{ $activity->status_pengajuan }}</span>
                                        <p class="text-gray-300">
                                            Pengajuan dari {{ $activity->mahasiswa->nama }} untuk
                                            {{ $activity->beasiswa->nama_beasiswa }}
                                            @if($activity->periode)
                                                ({{ $activity->periode->nama_periode }})
                                            @endif
                                            @if ($activity->status_pengajuan == 'diterima')
                                                telah disetujui
                                            @elseif($activity->status_pengajuan == 'ditolak')
                                                telah ditolak
                                            @else
                                                sedang diproses
                                            @endif
                                        </p>
                                        <span
                                            class="time text-gray-500">{{ $activity->updated_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-white text-center">Belum ada aktivitas</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
