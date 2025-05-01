@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Daftar Periode Beasiswa</h2>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('admin.periode.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Periode
                            </a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Periode</th>
                                    <th>Beasiswa</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Kuota</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($periodes as $periode)
                                    <tr class="cursor-pointer hover-pointer"
                                        onclick="window.location.href='{{ route('admin.periode.show', $periode->id_periode) }}'">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $periode->nama_periode }}</td>
                                        <td>{{ $periode->beasiswa ? $periode->beasiswa->nama_beasiswa : 'Tidak ada beasiswa' }}</td>
                                        <td>{{ $periode->tanggal_mulai->format('d M Y') }}</td>
                                        <td>{{ $periode->tanggal_selesai->format('d M Y') }}</td>
                                        <td>{{ $periode->kuota }}</td>
                                        <td>
                                            <span class="badge bg-{{ $periode->status == 'aktif' ? 'success' : 'danger' }}">
                                                {{ $periode->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="d-flex gap-2 justify-content-center action-buttons"
                                            onclick="event.stopPropagation()">
                                            <form action="{{ route('admin.periode.toggle-status', $periode->id_periode) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-{{ $periode->status == 'aktif' ? 'warning' : 'success' }}"
                                                    onclick="event.stopPropagation(); return confirm('{{ $periode->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} periode ini?')">
                                                    <i class="fas fa-{{ $periode->status == 'aktif' ? 'toggle-off' : 'toggle-on' }}"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.periode.edit', $periode->id_periode) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.periode.destroy', $periode->id_periode) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus periode ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $periodes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 