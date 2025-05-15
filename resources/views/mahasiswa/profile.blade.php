@extends('layouts.main')

@section('title', 'Profil Mahasiswa')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Profil Mahasiswa</h2>
            <div class="underline mx-auto"
                style="height: 4px; width: 80px; background: linear-gradient(to right, #4e73df, #224abe);"></div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Card -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                    <!-- Card Header with Gradient Background -->
                    <div class="d-flex align-items-center justify-content-between card-header bg-gradient-primary text-white py-3 px-4">
                        <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h4>

                        <div class="d-flex">
                            <a href="{{ route('profile.edit') }}" class="btn btn-light me-2">
                                <i class="fas fa-user-edit me-1"></i> Edit Profil
                            </a>
                            <a href="{{ route('profile.edit.password') }}" class="btn btn-warning">
                                <i class="fas fa-key me-1"></i> Ubah Password
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row align-items-center mb-4">
                            <!-- Profile Picture Placeholder -->
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="avatar-container bg-primary bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 150px; height: 150px; margin: 0 auto;">
                                    <span class="display-1 text-primary">{{ substr($mahasiswa->nama, 0, 1) }}</span>
                                </div>
                            </div>

                            <!-- Basic Info -->
                            <div class="col-md-9">
                                <h3 class="fw-bold mb-3 text-primary">{{ $mahasiswa->nama }}</h3>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2 d-flex align-items-center text-light">
                                            <i class="fas fa-id-card me-2 text-primary"></i>
                                            <span class="fw-semibold">NIM:</span>
                                            <span class="ms-2">{{ $mahasiswa->nim }}</span>
                                        </p>

                                        <p class="mb-2 d-flex align-items-center text-light">
                                            <i class="fas fa-graduation-cap me-2 text-success"></i>
                                            <span class="fw-semibold">Program Studi:</span>
                                            <span class="ms-2">{{ $mahasiswa->jurusan }}</span>
                                        </p>

                                        <p class="mb-2 d-flex align-items-center text-light">
                                            <i class="fas fa-university me-2 text-info"></i>
                                            <span class="fw-semibold">Fakultas:</span>
                                            <span class="ms-2">{{ $mahasiswa->fakultas }}</span>
                                        </p>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <p class="mb-2 d-flex align-items-center text-light">
                                            <i class="fas fa-calendar-alt me-2 text-warning"></i>
                                            <span class="fw-semibold">Angkatan:</span>
                                            <span class="ms-2">{{ $mahasiswa->angkatan }}</span>
                                        </p>
                                        
                                        <p class="mb-2 d-flex align-items-center text-light">
                                            <i class="fas fa-user-graduate me-2 text-danger"></i>
                                            <span class="fw-semibold">Semester:</span>
                                            <span class="ms-2">{{ $mahasiswa->semester }}</span>
                                        </p>
                                        
                                        <p class="mb-2 d-flex align-items-center text-light">
                                            <i class="fas fa-chart-line me-2 text-success"></i>
                                            <span class="fw-semibold">IPK Terakhir:</span>
                                            <span class="ms-2 badge bg-success">{{ $mahasiswa->ipk_terakhir }}</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="mt-3">
                                    <span class="badge bg-success py-2 px-3 rounded-pill">
                                        <i class="fas fa-circle me-1 small"></i> Aktif
                                    </span>
                                    
                                    @if($mahasiswa->total_received_scholarship > 0)
                                    <span class="badge bg-primary py-2 px-3 rounded-pill ms-2">
                                        <i class="fas fa-money-bill-wave me-1"></i> Total Beasiswa: Rp. {{ number_format($mahasiswa->total_received_scholarship, 0, ',', '.') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Detail Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light bg-opacity-10 mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pribadi</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush bg-transparent">
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-venus-mars me-2 text-secondary"></i>Gender:</span>
                                                <span class="fw-bold">{{ $mahasiswa->gender }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-envelope me-2 text-secondary"></i>Email:</span>
                                                <span class="fw-bold">{{ $mahasiswa->email }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-phone me-2 text-secondary"></i>No. HP:</span>
                                                <span class="fw-bold">{{ $mahasiswa->no_hp }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent text-light">
                                                <div class="d-flex justify-content-between">
                                                    <span><i class="fas fa-map-marker-alt me-2 text-secondary"></i>Alamat:</span>
                                                </div>
                                                <div class="mt-2">
                                                    {{ $mahasiswa->alamat }}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light bg-opacity-10 mb-4">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0"><i class="fas fa-certificate me-2"></i>Informasi Akademik</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush bg-transparent">
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-book me-2 text-secondary"></i>Program Studi:</span>
                                                <span class="fw-bold">{{ $mahasiswa->jurusan }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-university me-2 text-secondary"></i>Fakultas:</span>
                                                <span class="fw-bold">{{ $mahasiswa->fakultas }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-user-graduate me-2 text-secondary"></i>Angkatan:</span>
                                                <span class="fw-bold">{{ $mahasiswa->angkatan }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-award me-2 text-secondary"></i>IPK Terakhir:</span>
                                                <span class="fw-bold text-success">{{ $mahasiswa->ipk_terakhir }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between text-light">
                                                <span><i class="fas fa-money-bill-wave me-2 text-secondary"></i>Total Beasiswa:</span>
                                                <span class="fw-bold text-primary">Rp. {{ number_format($mahasiswa->total_received_scholarship, 0, ',', '.') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
