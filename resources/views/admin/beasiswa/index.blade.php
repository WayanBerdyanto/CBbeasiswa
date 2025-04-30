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
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
                                Tambah Beasiswa
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
                                @empty($beasiswas)
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                @else
                                    @foreach ($beasiswas as $beasiswa)
                                        <tr class="cursor-pointer hover-pointer"
                                            onclick="window.location.href='{{ route('admin.beasiswa.show', $beasiswa->id_beasiswa) }}'">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $beasiswa->nama_beasiswa }}</td>
                                            <td>{{ $beasiswa->jenis }}</td>
                                            <td>{{ $beasiswa->deskripsi }}</td>
                                            <td class="d-flex gap-2 justify-content-center action-buttons"
                                                onclick="event.stopPropagation()">
                                                <a href="{{ route('admin.beasiswa.edit', $beasiswa->id_beasiswa) }}"
                                                    class="btn btn-info">Edit</a>
                                                <form action="{{ route('admin.beasiswa.destroy', $beasiswa->id_beasiswa) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus beasiswa ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $beasiswas->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
