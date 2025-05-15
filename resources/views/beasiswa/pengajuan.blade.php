@extends('layouts.main')

@section('title', 'Daftar Pengajuan Beasiswa')

@section('content')
    <div class="container py-5">
        <h1 class="page-header">Daftar Pengajuan Beasiswa</h1>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card h-100">
            <div class="table-container vh-100">
                <table class="table pengajuan-table">
                    <thead class="sticky-top">
                        <tr>
                            <th>Beasiswa</th>
                            <th>Alasan Pengajuan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Nominal</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $item)
                            <tr class="table-row clickable-row" data-href="{{ route('pengajuan.detail', $item->id_pengajuan) }}">
                                <td>
                                    <strong>{{ $item->beasiswa->nama_beasiswa ?? '-' }}</strong>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;" title="{{ $item->alasan_pengajuan }}">
                                        {{ $item->alasan_pengajuan }}
                                    </div>
                                </td>
                                <td class="date-cell">
                                    <i class="far fa-calendar-alt me-2 text-secondary"></i>
                                    {{ \Carbon\Carbon::parse($item->tgl_pengajuan)->translatedFormat('d M Y') }}
                                </td>
                                <td>
                                    @if ($item->status_pengajuan == 'diterima')
                                        <span class="badge badge-diterima">
                                            <i class="fas fa-check-circle"></i> Diterima
                                        </span>
                                    @elseif ($item->status_pengajuan == 'ditolak')
                                        <span class="badge badge-ditolak">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge badge-diproses">
                                            <i class="fas fa-hourglass-half"></i> Diproses
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_pengajuan == 'diterima')
                                        <span class="badge bg-success">
                                            Rp {{ number_format($item->nominal_approved, 0, ',', '.') }}
                                        </span>
                                    @elseif ($item->status_pengajuan == 'diproses')
                                        <span class="badge bg-light text-dark">
                                            Rp {{ number_format($item->beasiswa->nominal, 0, ',', '.') }}
                                            <small>(Default)</small>
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->dokumen && $item->dokumen->count() > 0)
                                        <div class="dropdown">
                                            <button class="btn-view dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id_pengajuan }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-file-alt btn-icon"></i> Dokumen ({{ $item->dokumen->count() }})
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id_pengajuan }}">
                                                @foreach($item->dokumen as $dokumen)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('dokumen.show', $dokumen->id_dokumen) }}">
                                                            <i class="fas fa-file-alt me-2"></i> {{ $dokumen->nama_dokumen }}
                                                            @if($dokumen->status_verifikasi == 'belum_diverifikasi')
                                                                <span class="badge bg-secondary float-end">Belum Diverifikasi</span>
                                                            @elseif($dokumen->status_verifikasi == 'valid')
                                                                <span class="badge bg-success float-end">Valid</span>
                                                            @else
                                                                <span class="badge bg-danger float-end">Tidak Valid</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('dokumen.create', $item->id_pengajuan) }}">
                                                        <i class="fas fa-plus me-2"></i> Tambah Dokumen
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <a href="{{ route('dokumen.create', $item->id_pengajuan) }}" 
                                           class="btn-action btn-view"
                                           title="Unggah Dokumen">
                                            <i class="fas fa-upload btn-icon"></i> Unggah
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <form id="form-delete-{{ $item->id_pengajuan }}"
                                        action="{{ route('pengajuan.hapus', $item->id_pengajuan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <div class="btn-group">
                                            @if($item->status_pengajuan == 'diproses')
                                                <a href="{{ route('pengajuan.edit', $item->id_pengajuan) }}" 
                                                   class="btn-action btn-edit"
                                                   title="Edit Pengajuan">
                                                    <i class="fas fa-edit btn-icon"></i> Edit
                                                </a>
                                            @endif
                                            
                                            <button type="button" 
                                                    class="btn-action btn-delete" 
                                                    data-id="{{ $item->id_pengajuan }}"
                                                    title="Hapus Pengajuan">
                                                <i class="fas fa-trash-alt btn-icon"></i> Hapus
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open"></i>
                                        <p>Belum ada pengajuan beasiswa</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle clickable rows
            document.querySelectorAll('.clickable-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't handle click if user clicked on a button or link
                    if (!e.target.closest('button') && !e.target.closest('a') && !e.target.closest('form')) {
                        window.location.href = this.dataset.href;
                    }
                });
            });
            
            // Delete confirmation
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const pengajuanId = this.getAttribute('data-id');
                    const beasiswaName = this.closest('tr').querySelector('td:first-child strong').textContent;

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        html: `Anda yakin ingin menghapus pengajuan untuk beasiswa <strong>${beasiswaName}</strong>?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ff4d8d',
                        cancelButtonColor: '#1e50e2',
                        confirmButtonText: '<i class="fas fa-trash-alt me-2"></i>Hapus',
                        cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                        reverseButtons: true,
                        background: '#1a1a1a',
                        color: '#ffffff',
                        iconColor: '#ecc94b'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`form-delete-${pengajuanId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush

@push('styles')
<style>
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .clickable-row:hover {
        background-color: rgba(30, 80, 226, 0.1);
    }
    
    .badge-diterima {
        background: linear-gradient(90deg, #1cc88a, #13855c);
        color: white;
    }
    
    .badge-ditolak {
        background: linear-gradient(90deg, #e74a3b, #be2617);
        color: white;
    }
    
    .badge-diproses {
        background: linear-gradient(90deg, #f6c23e, #dda20a);
        color: white;
    }
</style>
@endpush