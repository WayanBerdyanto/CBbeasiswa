<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CBScholarships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --wm-black: #000000;
            --wm-dark: #121212;
            --wm-gray: #1a1a1a;
            --wm-light-gray: #2a2a2a;
            --wm-white: #ffffff;
            --wm-blue: #1e50e2;
            --wm-blue-hover: #0d3cb0;
            --wm-pink: #ff4d8d;
            --wm-pink-hover: #e03a7a;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--wm-dark);
            color: var(--wm-white);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(30, 80, 226, 0.15) 0%, transparent 30%),
                radial-gradient(circle at 80% 70%, rgba(255, 77, 141, 0.15) 0%, transparent 30%);
            background-size: 200% 200%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background-color: rgba(26, 26, 26, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent 0%,
                    rgba(30, 80, 226, 0.1) 50%,
                    transparent 100%);
            transform: rotate(45deg);
            z-index: -1;
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                transform: rotate(45deg) translate(-30%, -30%);
            }

            100% {
                transform: rotate(45deg) translate(30%, 30%);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-text {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--wm-white);
            text-transform: uppercase;
            letter-spacing: 3px;
            position: relative;
            display: inline-block;
        }

        .logo-text::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--wm-blue), var(--wm-pink));
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--wm-white);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--wm-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 80, 226, 0.3);
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, var(--wm-blue), var(--wm-pink));
            border: none;
            border-radius: 8px;
            color: var(--wm-white);
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, var(--wm-blue-hover), var(--wm-pink-hover));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 80, 226, 0.4);
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .login-footer a {
            color: var(--wm-pink);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--wm-blue);
            text-decoration: underline;
        }

        .floating-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .floating-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.03);
            font-size: 5rem;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(50px, 50px) rotate(90deg);
            }

            50% {
                transform: translate(100px, 0) rotate(180deg);
            }

            75% {
                transform: translate(50px, -50px) rotate(270deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                padding: 30px 20px;
                margin: 0 15px;
            }

            .logo-text {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="floating-icons">
        <i class="fas fa-graduation-cap floating-icon" style="top: 10%; left: 15%; animation-delay: 0s;"></i>
        <i class="fas fa-book floating-icon" style="top: 70%; left: 80%; animation-delay: -3s;"></i>
        <i class="fas fa-university floating-icon" style="top: 40%; left: 60%; animation-delay: -6s;"></i>
        <i class="fas fa-award floating-icon" style="top: 80%; left: 20%; animation-delay: -9s;"></i>
    </div>

    <div class="login-container">
        <div class="logo">
            <div class="logo-text">CBScholarships</div>
        </div>

        <form action="{{ route('admin.login') }}" method="POST">
            <h3 class="text-center mb-4">Admin Login</h3>
            @csrf <!-- Tambahkan CSRF token agar Laravel menerima request -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control text-white"
                    placeholder="Masukkan email Anda" required>
                <i class="fas fa-envelope input-icon"></i>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control text-white"
                    placeholder="Masukkan password Anda" required>
                <i class="fas fa-lock input-icon"></i>
            </div>

            <button type="submit" class="btn-login">MASUK</button>
        </form>

        <div class="login-footer">
            <a href="/login">Login sebagai Mahasiswa</a>
        </div>
    </div>

    <script>
        // Add focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-icon').style.color = "var(--wm-blue)";
            });

            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-icon').style.color = "rgba(255, 255, 255, 0.5)";
            });
        });

        // Add floating icons
        const icons = ['fa-graduation-cap', 'fa-book', 'fa-university', 'fa-award', 'fa-user-graduate'];
        const floatingIcons = document.querySelector('.floating-icons');

        for (let i = 0; i < 8; i++) {
            const icon = document.createElement('i');
            icon.className = `fas ${icons[Math.floor(Math.random() * icons.length)]} floating-icon`;
            icon.style.top = `${Math.random() * 100}%`;
            icon.style.left = `${Math.random() * 100}%`;
            icon.style.animationDelay = `-${Math.random() * 15}s`;
            icon.style.fontSize = `${3 + Math.random() * 4}rem`;
            floatingIcons.appendChild(icon);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    @php
        $success = session('success');
        $error = session('error');
    @endphp

    @if ($success)
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ $success }}"
            });
        </script>
    @endif

    @if ($error)
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif
</body>

</html>
