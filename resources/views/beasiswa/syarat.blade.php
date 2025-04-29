@extends('layouts.main')

@section('title', 'Syarat Beasiswa')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
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
    </style>

    <div class="min-h-screen bg-gray-900 text-white d-flex flex-column align-items-center justify-content-center">
        <div class="container mt-5">
            <h2 class="text-center text-blue-400">Syarat Beasiswa</h2>
            <div class="row mt-4">
                @foreach ($syarat as $s)
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card bg-gray-800 text-white p-4 shadow-lg border-0">
                            <h4 class="text-blue-400">Syarat IPK: {{ $s->syarat_ipk }}</h4>
                            <p class="text-gray-300">Dokumen: {{ $s->syarat_dokumen }}</p>
                            <div class="d-flex justify-content-left mt-4">
                                <a href="{{ route('pengajuan.form', ['id' => $id_beasiswa]) }}" class="btn btn-primary">
                                    Ajukan Beasiswa
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-left mt-4">
                <a href="{{ route('beasiswa.index') }}" class="btn btn-primary">
                    ⬅ Kembali ke Daftar Beasiswa
                </a>
            </div>
        </div>
    </div>
@endsection
