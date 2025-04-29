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

        <!-- Profile Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                    <!-- Card Header with Gradient Background -->
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="row align-items-center mb-4">
                            <!-- Profile Picture Placeholder -->
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="avatar-container bg-light p-2 rounded-circle"
                                    style="width: 150px; height: 150px; margin: 0 auto;">
                                    <i class="fas fa-user fa-5x text-secondary" style="line-height: 130px;"></i>
                                </div>
                            </div>

                            <!-- Basic Info -->
                            <div class="col-md-9">
                                <h3 class="fw-bold mb-2 text-light">{{ $mahasiswa->nama }}</h3>
                                <p class="text-secondary mb-2 d-flex align-items-center">
                                    <i class="fas fa-id-card me-2 text-primary"></i>
                                    <span class="fw-semibold">NIM:</span>
                                    <span class="ms-2">{{ $mahasiswa->nim }}</span>
                                </p>

                                <p class="text-secondary mb-2 d-flex align-items-center">
                                    <i class="fas fa-graduation-cap me-2 text-success"></i>
                                    <span class="fw-semibold">Program Studi:</span>
                                    <span class="ms-2">{{ $mahasiswa->jurusan }}</span>
                                </p>

                                <p class="text-secondary d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-2 text-warning"></i>
                                    <span class="fw-semibold">Angkatan:</span>
                                    <span class="ms-2">{{ $mahasiswa->angkatan }}</span>
                                </p>


                                <!-- Status Badge -->
                                <div class="mt-3">
                                    <span class="badge bg-success bg-opacity-10 text-success py-2 px-3 rounded-pill">
                                        <i class="fas fa-circle me-1 small"></i> Aktif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Detail Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3 text-primary"><i class="fas fa-info-circle me-2"></i>Detail
                                    Informasi</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="fw-bold me-2"><i class="fas fa-venus-mars me-2"></i>Gender:</span>
                                        {{ $mahasiswa->gender }}
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-bold me-2"><i class="fas fa-envelope me-2"></i>Email:</span>
                                        <a href="mailto:{{ $mahasiswa->email }}">{{ $mahasiswa->email }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3 text-primary"><i class="fas fa-certificate me-2"></i>Status Akademik
                                </h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="fw-bold me-2"><i class="fas fa-university me-2"></i>Program
                                            Studi:</span>
                                        {{ $mahasiswa->jurusan }}
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-bold me-2"><i class="fas fa-layer-group me-2"></i>Angkatan:</span>
                                        {{ $mahasiswa->angkatan }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .avatar-container {
                transition: transform 0.3s ease;
            }

            .avatar-container:hover {
                transform: scale(1.05);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .underline {
                background: linear-gradient(to right, #4e73df, #224abe);
            }

            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
        </style>

        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </div>
@endsection
