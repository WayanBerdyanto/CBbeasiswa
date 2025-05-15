@extends('layouts.main')

@section('title', 'Update Password')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Update Password</h2>
            <div class="underline mx-auto"
                style="height: 4px; width: 80px; background: linear-gradient(to right, #4e73df, #224abe);"></div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Password Update Card -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                    <!-- Card Header with Gradient Background -->
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-key me-2"></i>Update Password</h4>
                    </div>

                    <div class="card bg-gray-800 p-4">
                        <form action="{{ route('profile.update.password') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label class="form-label text-light">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Password baru" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" id="strength-meter" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="form-text text-muted">Password minimal 8 karakter</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-light">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           placeholder="Konfirmasi password" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Update Password
                                </button>
                                <a href="{{ route('profile') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password strength meter
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.getElementById('strength-meter');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            // Check length
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;

            // Check for mixed case
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;

            // Check for numbers
            if (password.match(/\d/)) strength += 1;

            // Check for special chars
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

            // Update meter
            const width = strength * 20;
            strengthMeter.style.width = `${width}%`;
            
            // Update color based on strength
            if (strength <= 1) {
                strengthMeter.className = 'progress-bar bg-danger';
            } else if (strength <= 3) {
                strengthMeter.className = 'progress-bar bg-warning';
            } else {
                strengthMeter.className = 'progress-bar bg-success';
            }
        });
    </script>
@endsection 