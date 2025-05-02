@extends('layouts.main')

@section('title', 'Syarat Beasiswa')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        h2, h3, h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border-radius: 12px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.3);
        }

        .btn-primary {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }
        
        .badge-info {
            background-color: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .highlight-box {
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(16, 185, 129, 0.1));
            border-left: 5px solid #3b82f6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .requirement-list {
            list-style-type: none;
            padding-left: 10px;
        }
        
        .requirement-list li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 12px;
        }
        
        .requirement-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }
        
        .detail-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            font-size: 1.5rem;
        }
    </style>

    <div class="min-h-screen bg-gray-900 text-white">
        <div class="container py-5">
            <!-- Back Button -->
            <div class="d-flex justify-content-start mb-4">
                <a href="{{ route('beasiswa.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Beasiswa
                </a>
            </div>
            
            <!-- Beasiswa Header -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card bg-gray-800 text-white border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="detail-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0 text-blue-400">{{ $beasiswa->nama_beasiswa ?? 'Detail Beasiswa' }}</h2>
                                    <div class="mt-2">
                                        @if(isset($beasiswa->jenisBeasiswa))
                                            <span class="badge badge-info">
                                                <i class="fas fa-tag me-1"></i> 
                                                {{ $beasiswa->jenisBeasiswa->nama_jenis }}
                                            </span>
                                        @endif
                                        
                                        @if(isset($beasiswa->nominal))
                                            <span class="badge badge-info ms-2">
                                                <i class="fas fa-money-bill-wave me-1"></i> 
                                                Rp {{ number_format($beasiswa->nominal, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="highlight-box">
                                <h5 class="text-blue-300 mb-2">
                                    <i class="fas fa-info-circle me-2"></i> Deskripsi Beasiswa
                                </h5>
                                <p class="mb-0">{{ $beasiswa->deskripsi ?? 'Tidak ada deskripsi beasiswa yang tersedia.' }}</p>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="detail-icon" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-light">Periode Pendaftaran</h6>
                                            <p class="mb-0">{{ $periode->nama_periode ?? 'Periode aktif' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="detail-icon" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-light">Penyelenggara</h6>
                                            <p class="mb-0">{{ $beasiswa->penyelenggara ?? 'Internal' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Syarat Section -->
            <h3 class="text-center text-blue-400 mb-4">Persyaratan Beasiswa</h3>
            
            @if($syarat->count() > 0)
                <div class="row">
                    @foreach ($syarat as $s)
                        <div class="col-md-6 mb-4" data-aos="fade-up">
                            <div class="card bg-gray-800 text-white border-0 shadow-lg">
                                <div class="card-header bg-primary bg-opacity-25 py-3">
                                    <h4 class="mb-0">
                                        <i class="fas fa-clipboard-check me-2"></i> Persyaratan
                                    </h4>
                                </div>
                                <div class="card-body p-4">
                                    <div class="highlight-box mb-4">
                                        <h5 class="text-blue-300 mb-3">
                                            <i class="fas fa-chart-line me-2"></i> Syarat Akademik
                                        </h5>
                                        <div class="d-flex align-items-center">
                                            <div class="detail-icon" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                                <i class="fas fa-award"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 text-white">IPK Minimal</h6>
                                                <p class="mb-0 fs-4 fw-bold text-warning">{{ $s->syarat_ipk }}</p>
                                            </div>
                                        </div>
                                        
                                        @if($ipk_user)
                                            <div class="alert {{ $ipk_user >= $s->syarat_ipk ? 'alert-success' : 'alert-danger' }} mt-3">
                                                <i class="fas {{ $ipk_user >= $s->syarat_ipk ? 'fa-check-circle' : 'fa-exclamation-circle' }} me-2"></i>
                                                IPK Anda: <strong>{{ $ipk_user }}</strong>
                                                @if($ipk_user >= $s->syarat_ipk)
                                                    <span class="text-success">(Memenuhi syarat)</span>
                                                @else
                                                    <span class="text-danger">(Tidak memenuhi syarat)</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h5 class="text-blue-300 mb-3">
                                            <i class="fas fa-file-alt me-2"></i> Dokumen yang Diperlukan
                                        </h5>
                                        <ul class="requirement-list">
                                            @foreach(explode(',', $s->syarat_dokumen) as $dokumen)
                                                <li>{{ trim($dokumen) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mt-4">
                                        @if ($ipk_user >= $s->syarat_ipk)
                                            <a href="{{ route('pengajuan.form', ['id' => $id_beasiswa]) }}" 
                                               class="btn btn-primary btn-lg w-100">
                                                <i class="fas fa-paper-plane me-2"></i> Ajukan Beasiswa
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                                <i class="fas fa-times-circle me-2"></i> IPK Tidak Memenuhi Syarat
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <p>Tidak ada persyaratan yang tersedia untuk beasiswa ini.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
