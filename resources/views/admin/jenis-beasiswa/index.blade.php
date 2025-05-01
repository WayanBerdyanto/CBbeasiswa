@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Daftar Jenis Beasiswa</h2>
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
                            <a href="{{ route('admin.jenis-beasiswa.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Jenis Beasiswa
                            </a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jenis</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Beasiswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jenisBeasiswas as $jenis)
                                    <tr class="cursor-pointer hover-pointer"
                                        onclick="window.location.href='{{ route('admin.jenis-beasiswa.show', $jenis->id_jenis) }}'">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jenis->nama_jenis }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($jenis->deskripsi, 50) }}</td>
                                        <td>{{ $jenis->beasiswas_count }}</td>
                                        <td class="d-flex gap-2 justify-content-center action-buttons"
                                            onclick="event.stopPropagation()">
                                            <a href="{{ route('admin.jenis-beasiswa.edit', $jenis->id_jenis) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.jenis-beasiswa.destroy', $jenis->id_jenis) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus jenis beasiswa ini?')">
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
                            {{ $jenisBeasiswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 