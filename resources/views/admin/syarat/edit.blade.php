@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.syarat.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center py-3">
                        <h2>Edit Syarat</h2>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.syarat.update', $syarat->id_syarat) }}" method="post">
                            @csrf
                            @method('PUT')
                            <!-- Hidden input for id_beasiswa -->
                            <input type="hidden" name="id_beasiswa" value="{{ $syarat->id_beasiswa }}">
                            
                            <div class="form-group mb-4">
                                <label for="nama">Nama Beasiswa</label>
                                <input type="text" name="nama_beasiswa" class="form-control" id="nama_beasiswa" placeholder="Masukkan nama beasiswa" value="{{ $syarat->beasiswa->nama_beasiswa }}" readonly>
                            </div>
                            <div class="form-group mb-4">
                                <label for="ipk">IPK</label>
                                <input type="number" name="syarat_ipk" class="form-control" id="syarat_ipk" placeholder="Masukkan IPK" step="0.01" min="0" max="4" value="{{ $syarat->syarat_ipk }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="dokumen">Dokumen</label>
                                <textarea name="syarat_dokumen" class="form-control" id="syarat_dokumen" placeholder="Masukkan dokumen" rows="3">{{ $syarat->syarat_dokumen }}</textarea>
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
