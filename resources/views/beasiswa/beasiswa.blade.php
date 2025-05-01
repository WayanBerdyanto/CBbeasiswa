@extends('layouts.main')

@section('title', 'Daftar Beasiswa')

@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="page-title">Daftar Beasiswa Tersedia</h2>
                <p class="text-white fw-light">Temukan berbagai pilihan beasiswa yang dapat membantu pendidikan Anda</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control search-input" id="searchBeasiswa" placeholder="Cari beasiswa...">
                </div>
            </div>
        </div>

        <!-- Daftar Beasiswa -->
        <div class="row" id="beasiswaList">
            @foreach ($beasiswa as $b)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card scholarship-card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $b->nama_beasiswa }}</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary badge-scholarship">
                                {{ $b->jenis }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="scholarship-description">{{ $b->deskripsi }}</p>
                            
                            <div class="scholarship-meta">
                                <i class="far fa-clock meta-icon"></i> Diperbarui: {{ $b->updated_at->diffForHumans() }}
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('syarat.index', $b->id_beasiswa) }}" class="btn btn-view">
                                    <i class="fas fa-arrow-right me-2"></i>Lihat Syarat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="row d-none">
            <div class="col-12 text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-3x text-secondary opacity-25"></i>
                </div>
                <h5 class="fw-light mb-3">Tidak ada beasiswa yang ditemukan</h5>
                <p class="text-secondary mb-4 fw-light">Silakan coba dengan kata kunci lain</p>
            </div>
        </div>
    </div>

    <script>
        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchBeasiswa');
            const beasiswaList = document.getElementById('beasiswaList');
            const emptyState = document.getElementById('emptyState');
            const cards = beasiswaList.querySelectorAll('.col-md-4');
            
            searchInput.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                let visible = 0;
                
                cards.forEach(card => {
                    const cardContent = card.textContent.toLowerCase();
                    if (cardContent.includes(value)) {
                        card.style.display = 'block';
                        visible++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                if (visible === 0) {
                    beasiswaList.classList.add('d-none');
                    emptyState.classList.remove('d-none');
                } else {
                    beasiswaList.classList.remove('d-none');
                    emptyState.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
