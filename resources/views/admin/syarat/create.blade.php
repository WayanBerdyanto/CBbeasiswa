@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.syarat.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    &nbsp; Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Tambah Syarat</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.syarat.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="id_beasiswa">Beasiswa</label>
                                <select name="id_beasiswa" class="form-control" id="id_beasiswa">
                                    @foreach ($beasiswa as $key => $item)
                                        <option value="{{ $item['id_beasiswa'] }}">{{ $item['nama_beasiswa'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="syarat_ipk">IPK</label>
                                <input type="number" name="syarat_ipk" class="form-control" id="syarat_ipk" placeholder="Masukkan IPK" step="0.01" min="0" max="4">
                            </div>
                            <div class="form-group mb-4">
                                <label for="syarat_dokumen">Dokumen</label>
                                <textarea name="syarat_dokumen" class="form-control" id="syarat_dokumen" placeholder="Masukkan dokumen" rows="3"></textarea>
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
