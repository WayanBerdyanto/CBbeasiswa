@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Daftar Mahasiswa</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Mahasiswa
                            </a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Fakultas</th>
                                    <th>Jurusan/Prodi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswas as $index => $mahasiswa)
                                    <tr class="cursor-pointer hover-pointer"
                                        onclick="window.location.href='{{ route('admin.mahasiswa.show', $mahasiswa->id) }}'">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mahasiswa->nama }}</td>
                                        <td>{{ $mahasiswa->nim }}</td>
                                        <td>{{ $mahasiswa->fakultas }}</td>
                                        <td>{{ $mahasiswa->jurusan }}</td>
                                        <td class="d-flex gap-2 justify-content-center action-buttons"
                                            onclick="event.stopPropagation()">
                                            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $mahasiswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
