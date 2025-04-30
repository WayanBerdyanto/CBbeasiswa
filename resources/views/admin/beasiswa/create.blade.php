@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    &nbsp; Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Beasiswa</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.beasiswa.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="nama">Nama Beasiswa</label>
                                <input type="text" name="nama_beasiswa" class="form-control" id="nama_beasiswa" placeholder="Masukkan nama beasiswa">
                            </div>
                            <div class="form-group mb-4">
                                <label for="jenis">Jenis Beasiswa</label>
                                <select name="jenis" class="form-control" id="jenis">
                                    @foreach ($jenis as $key => $item)
                                        <option value="{{ $item['beasiswa'] }}">{{ $item['beasiswa'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukkan deskripsi beasiswa"></textarea>
                            </div>
                            <div class="d-flex justify-content-end gap-4 my-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
