@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Daftar Syarat Beasiswa</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('admin.syarat.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Syarat
                            </a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Beasiswa</th>
                                    <th>IPK</th>
                                    <th>Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($syarat as $idx => $item)
                                    <tr class="cursor-pointer hover-pointer"
                                        onclick="window.location.href='{{ route('admin.syarat.show', $item->id_syarat) }}'">
                                        <td>{{ $syarat->firstItem() + $idx }}</td>
                                        <td>{{ $item->beasiswa->nama_beasiswa }}</td>
                                        <td>{{ $item->syarat_ipk }}</td>
                                        <td>{{ $item->syarat_dokumen }}</td>
                                        <td class="d-flex gap-2 justify-content-center action-buttons"
                                            onclick="event.stopPropagation()">
                                            <a href="{{ route('admin.syarat.edit', $item->id_syarat) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.syarat.destroy', $item->id_syarat) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus syarat ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $syarat->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
