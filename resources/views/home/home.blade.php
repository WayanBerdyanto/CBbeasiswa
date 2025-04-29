@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <div class="min-h-screen bg-gray-900 text-white d-flex flex-column align-items-center justify-content-center">
        <!-- Hero Section -->
        <div class="text-center">
            <!-- Hero Section -->
            <div class="text-center">
                <h1 class="text-blue-400 animate__animated animate__fadeInDown font-weight-bold display-4" data-aos="fade-down">
                    WELCOME TO CBSCHOLARSHIPS
                </h1>
                <p class="lead mt-3 text-gray-300 animate__animated animate__fadeInUp" data-aos="fade-up">
                    Temukan kesempatan beasiswa terbaik untuk masa depanmu!
                </p>
                <a href="{{ route('beasiswa.index') }}" class="btn btn-primary mt-4 animate__animated animate__zoomIn">
                    Cari Beasiswa
                </a>
            </div>
        </div>

        <!-- About Section -->
        <div class="container mt-5">
            <div class="card shadow-lg border-0 custom-slide-in bg-gray-800 text-white" data-aos="zoom-in">
                <div class="card-body p-5 text-center">
                    <h2 class="font-weight-bold text-blue-400">Mengapa Memilih CBScholarships?</h2>
                    <p class="text-gray-300 mt-3">
                        CBScholarships berkomitmen untuk mendukung mahasiswa berprestasi dalam meraih impian pendidikan
                        tinggi.
                        Kami menyediakan akses ke berbagai program beasiswa yang membantu meringankan biaya kuliah dan
                        membuka
                        peluang akademik yang lebih luas.
                    </p>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 text-center" data-aos="fade-right">
                    <div class="card bg-gray-800 text-white p-4 shadow-lg border-0">
                        <h4 class="text-blue-400">Beasiswa Beragam</h4>
                        <p class="text-gray-300">Kami menawarkan berbagai jenis beasiswa sesuai kebutuhan mahasiswa.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center" data-aos="fade-up">
                    <div class="card bg-gray-800 text-white p-4 shadow-lg border-0">
                        <h4 class="text-blue-400">Informasi Terupdate</h4>
                        <p class="text-gray-300">Selalu dapatkan informasi terbaru seputar peluang beasiswa.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center" data-aos="fade-left">
                    <div class="card bg-gray-800 text-white p-4 shadow-lg border-0">
                        <h4 class="text-blue-400">Mudah & Cepat</h4>
                        <p class="text-gray-300">Cari dan ajukan beasiswa dengan mudah melalui platform kami.</p>
                    </div>
                </div>
            </div>
        </div>
    @endsection
