@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Pengajuan</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pengajuan.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nama_beasiswa">Nama Beasiswa</label>
                                <select name="nama_beasiswa" class="form-control">
                                    @foreach ($beasiswas as $beasiswa)
                                        <option value="{{ $beasiswa->id_beasiswa }}">{{ $beasiswa->nama_beasiswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_mahasiswa">Nama Mahasiswa</label>
                                <select name="nama_mahasiswa" class="form-control">
                                    @foreach ($mahasiswas as $mahasiswa)
                                        <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status_pengajuan">Status Pengajuan</label>
                                <select name="status_pengajuan" class="form-control">
                                    <option value="diterima">Diterima</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                                <input type="date" name="tgl_pengajuan" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="alasan_pengajuan">Alasan Pengajuan</label>
                                <textarea name="alasan_pengajuan" class="form-control"></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
