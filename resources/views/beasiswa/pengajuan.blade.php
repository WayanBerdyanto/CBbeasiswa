@extends('layouts.main')

@section('title', 'Daftar Pengajuan Beasiswa')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-dark: #1a202c;
            --bg-card: #2d3748;
            --bg-table-header: #4a5568;
            --bg-table-row: #2d3748;
            --bg-table-hover: #4a5568;
            --text-primary: #000000;
            --text-secondary: #003a61;
            --accent-blue: #4299e1;
            --accent-red: #f56565;
            --accent-green: #48bb78;
            --accent-yellow: #ecc94b;
            --border-color: #4a5568;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
        }

        .page-header {
            color: var(--accent-blue);
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-blue), transparent);
            border-radius: 3px;
        }

        .card {
            background-color: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            border: none;
        }

        .table-container {
            overflow-x: auto;
        }

        table.table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 800px;
        }

        table.table th {
            background-color: var(--bg-table-header);
            color: var(--text-primary);
            font-weight: 500;
            padding: 1rem 1.25rem;
            border: none;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        table.table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-secondary);
        }

        table.table tbody tr {
            background-color: var(--bg-table-row);
            transition: all 0.2s ease;
        }

        table.table tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--border-color);
        }

        table.table tbody tr:hover {
            background-color: var(--bg-table-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-diterima {
            background-color: rgba(72, 187, 120, 0.2);
            color: var(--accent-green);
        }

        .badge-ditolak {
            background-color: rgba(245, 101, 101, 0.2);
            color: var(--accent-red);
        }

        .badge-diproses {
            background-color: rgba(236, 201, 75, 0.2);
            color: var(--accent-yellow);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background-color: rgba(66, 153, 225, 0.2);
            color: var(--accent-blue);
        }

        .btn-view:hover {
            background-color: rgba(66, 153, 225, 0.3);
        }

        .btn-delete {
            background-color: rgba(245, 101, 101, 0.2);
            color: var(--accent-red);
            margin-left: 0.5rem;
        }

        .btn-delete:hover {
            background-color: rgba(245, 101, 101, 0.3);
        }

        .btn-icon {
            margin-right: 0.5rem;
            font-size: 0.875rem;
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2.5rem;
            color: var(--border-color);
            margin-bottom: 1rem;
        }

        .empty-state p {
            margin-bottom: 0;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(72, 187, 120, 0.2);
            color: var(--accent-green);
        }

        .date-cell {
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .card {
                border-radius: 0;
            }
            
            .container {
                padding-left: 0;
                padding-right: 0;
            }
            
            .page-header {
                font-size: 1.5rem;
                padding: 0 1rem;
            }
        }
    </style>

    <div class="container py-5">
        <h1 class="page-header">Daftar Pengajuan Beasiswa</h1>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Beasiswa</th>
                            <th>Alasan Pengajuan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->beasiswa->nama_beasiswa ?? '-' }}</strong>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;" title="{{ $item->alasan_pengajuan }}">
                                        {{ $item->alasan_pengajuan }}
                                    </div>
                                </td>
                                <td class="date-cell">
                                    {{ \Carbon\Carbon::parse($item->tgl_pengajuan)->translatedFormat('d M Y') }}
                                </td>
                                <td>
                                    @if ($item->status_pengajuan == 'diterima')
                                        <span class="badge badge-diterima">
                                            <i class="fas fa-check-circle mr-1"></i> Diterima
                                        </span>
                                    @elseif ($item->status_pengajuan == 'ditolak')
                                        <span class="badge badge-ditolak">
                                            <i class="fas fa-times-circle mr-1"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge badge-diproses">
                                            <i class="fas fa-hourglass-half mr-1"></i> Diproses
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $item->dokumen) }}" 
                                       class="btn-action btn-view"
                                       target="_blank"
                                       title="Lihat Dokumen">
                                        <i class="fas fa-file-alt btn-icon"></i> Dokumen
                                    </a>
                                </td>
                                <td>
                                    <form id="form-delete-{{ $item->id_pengajuan }}"
                                        action="{{ route('pengajuan.hapus', $item->id_pengajuan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-action btn-delete" 
                                                data-id="{{ $item->id_pengajuan }}"
                                                title="Hapus Pengajuan">
                                            <i class="fas fa-trash-alt btn-icon"></i> Hapus
                                        </button>
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
                        confirmButtonColor: '#f56565',
                        cancelButtonColor: '#4299e1',
                        confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Hapus',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                        reverseButtons: true,
                        backdrop: `
                            rgba(0,0,0,0.7)
                            url("${window.location.origin}/images/trash-animation.gif")
                            left top
                            no-repeat
                        `
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`form-delete-${pengajuanId}`).submit();
                        }
                    });
                });
            });

            // Tooltip initialization
            $('[title]').tooltip({
                placement: 'top',
                trigger: 'hover'
            });
        });
    </script>
@endpush