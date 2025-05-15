@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Daftar Beasiswa</h2>
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
                        
                        <div class="d-flex justify-content-end mb-4 gap-2">
                            <a href="{{ route('admin.periode.index') }}" class="btn btn-info">
                                <i class="fas fa-calendar-alt me-1"></i> Kelola Periode
                            </a>
                            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Beasiswa
                            </a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Beasiswa</th>
                                    <th>Jenis Beasiswa</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($beasiswas as $idx => $beasiswa)
                                    <tr class="cursor-pointer hover-pointer"
                                        onclick="window.location.href='{{ route('admin.beasiswa.show', $beasiswa->id_beasiswa) }}'">
                                        <td>{{ $beasiswas->firstItem() + $idx }}</td>
                                        <td>{{ $beasiswa->nama_beasiswa }}</td>
                                        <td>{{ $beasiswa->jenisBeasiswa ? $beasiswa->jenisBeasiswa->nama_jenis : 'Tidak ada jenis' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($beasiswa->deskripsi, 50) }}</td>
                                        <td class="d-flex gap-2 justify-content-center action-buttons"
                                            onclick="event.stopPropagation()">
                                            <a href="{{ route('admin.beasiswa.edit', $beasiswa->id_beasiswa) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.beasiswa.destroy', $beasiswa->id_beasiswa) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus beasiswa ini?')">
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
                            {{ $beasiswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
