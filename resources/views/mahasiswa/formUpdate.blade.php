@extends('layouts.main')

@section('title', 'Profil Mahasiswa')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Update Profil Mahasiswa</h2>
            <div class="underline mx-auto"
                style="height: 4px; width: 80px; background: linear-gradient(to right, #4e73df, #224abe);"></div>
        </div>

        <!-- Profile Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                    <!-- Card Header with Gradient Background -->
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h4>
                    </div>

                    <div class="card bg-gray-800 p-4">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}"
                                        readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ $mahasiswa->email }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nim</label>
                                    <input type="text"class="form-control" value="{{ $mahasiswa->nim }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" value="{{ $mahasiswa->jurusan }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fakultas</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('fakultas', $mahasiswa->fakultas ?? '') }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender </label>
                                    <input type="text" name="gender" class="form-control"
                                        value="{{ old('gender', $mahasiswa->gender ?? '') }}" readonly>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span>Akses Edit</span>
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Angkatan </label>
                                    <input type="number" name="angkatan" class="form-control"
                                        value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}"required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Hp </label>
                                    <input type="text" name="no_hp" class="form-control"
                                        value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}"required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alamat </label>
                                    <input name="alamat" class="form-control"
                                        value="{{ old('alamat', $mahasiswa->alamat ?? '') }}" required>

                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ipk Terakhir </label>
                                    <input type="number" name="ipk_terakhir" class="form-control"
                                        step="0.01" min="0" max="4.00"
                                        value="{{ old('ipk_terakhir', $mahasiswa->ipk_terakhir ?? '') }}" required>
                                    @error('ipk_terakhir')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Semester </label>
                                    <input name="semester" class="form-control"
                                        value="{{ old('semester', $mahasiswa->semester ?? '') }}" required>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Ubah Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
