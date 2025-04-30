@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Daftar Pengajuan</h2>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <div class="mb-4">
                            <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                <i class="fas fa-filter me-1"></i> Filter Pengajuan
                            </button>

                            <div class="collapse mb-4" id="filterCollapse">
                                <div class="card card-body bg-gray-800">
                                    <form action="{{ route('admin.pengajuan.filter') }}" method="GET" class="row g-3">
                                        <div class="col-md-4">
                                            <label for="keyword" class="form-label">Kata Kunci</label>
                                            <input type="text" class="form-control" id="keyword" name="keyword"
                                                placeholder="Cari nama mahasiswa/beasiswa" value="{{ request('keyword') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">Semua Status</option>
                                                <option value="diterima"
                                                    {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima
                                                </option>
                                                <option value="diproses"
                                                    {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses
                                                </option>
                                                <option value="ditolak"
                                                    {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="beasiswa" class="form-label">Beasiswa</label>
                                            <select class="form-select" id="beasiswa" name="beasiswa">
                                                <option value="">Semua Beasiswa</option>
                                                @foreach ($beasiswas ?? [] as $beasiswa)
                                                    <option value="{{ $beasiswa->id_beasiswa }}"
                                                        {{ request('beasiswa') == $beasiswa->id_beasiswa ? 'selected' : '' }}>
                                                        {{ $beasiswa->nama_beasiswa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="mahasiswa" class="form-label">Mahasiswa</label>
                                            <select class="form-select" id="mahasiswa" name="mahasiswa">
                                                <option value="">Semua Mahasiswa</option>
                                                @foreach ($mahasiswas ?? [] as $mahasiswa)
                                                    <option value="{{ $mahasiswa->id }}"
                                                        {{ request('mahasiswa') == $mahasiswa->id ? 'selected' : '' }}>
                                                        {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai"
                                                name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tanggal_akhir"
                                                name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                        </div>

                                        <div class="col-12 mt-3 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search me-1"></i> Cari
                                            </button>
                                            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-redo me-1"></i> Reset
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <div>
                                @if (request()->has('keyword') ||
                                        request()->has('status') ||
                                        request()->has('beasiswa') ||
                                        request()->has('mahasiswa') ||
                                        request()->has('tanggal_mulai') ||
                                        request()->has('tanggal_akhir'))
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-1"></i> Menampilkan hasil filter
                                        @if (request('keyword'))
                                            dengan kata kunci: <strong>{{ request('keyword') }}</strong>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('admin.pengajuan.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Pengajuan
                            </a>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Beasiswa</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Status Pengajuan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Alasan Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuans as $pengajuan)
                                    <tr class="cursor-pointer hover-pointer"
                                        onclick="window.location.href='{{ route('admin.pengajuan.show', $pengajuan->id_pengajuan) }}'">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengajuan->beasiswa->nama_beasiswa }}</td>
                                        <td>{{ $pengajuan->mahasiswa->nama }}</td>
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
                                        <td>{{ $pengajuan->tgl_pengajuan->format('d M Y') }}</td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 150px;"
                                                title="{{ $pengajuan->alasan_pengajuan }}">
                                                {{ $pengajuan->alasan_pengajuan }}
                                            </div>
                                        </td>
                                        <td class="d-flex gap-2 justify-content-center action-buttons"
                                            onclick="event.stopPropagation()">
                                            <a href="{{ route('admin.pengajuan.edit', $pengajuan->id_pengajuan) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.pengajuan.destroy', $pengajuan->id_pengajuan) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus pengajuan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $pengajuans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
