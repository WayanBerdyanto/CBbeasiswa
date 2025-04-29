@extends('layouts.main')

@section('title', 'Daftar Beasiswa')

@section('content')
    <style>
        /* Menggunakan Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .card h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        .card p {
            font-size: 14px;
            font-weight: 300;
        }

        .btn-primary {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px;
        }
    </style>

    <div class="min-h-screen bg-gray-900 text-white d-flex flex-column align-items-center justify-content-center">

        <!-- Daftar Beasiswa -->
        <div class="container mt-5">
            <h2 class="text-center text-blue-400">Daftar Beasiswa</h2>
            <div class="row mt-4">
                @foreach ($beasiswa as $b)
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card bg-gray-800 text-white p-4 shadow-lg border-0">
                            <h4 class="text-blue-400">{{ $b->nama_beasiswa }}</h4>
                            <p class="text-gray-300">Jenis: {{ $b->jenis }}</p>
                            <p class="text-gray-300">{{ $b->deskripsi }}</p>
                            <a href="{{ route('syarat.index', $b->id_beasiswa) }}" class="btn btn-primary mt-3">
                                Lihat Syarat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
