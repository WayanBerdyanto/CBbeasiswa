<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBScholarships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- INI STYLE START YEE --}}
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
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 5%;
            background-color: var(--wm-black);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }

        .logo-center {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--wm-white);
            text-transform: uppercase;
            letter-spacing: 3px;
            position: relative;
        }

        .logo-center::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--wm-blue), var(--wm-pink));
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 180px 10% 100px;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--wm-gray), var(--wm-black));
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(30, 80, 226, 0.1) 0%, rgba(0, 0, 0, 0) 70%);
            z-index: 0;
        }

        .hero-content {
            max-width: 600px;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 30px;
            background: linear-gradient(90deg, var(--wm-white), var(--wm-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .hero-text {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            line-height: 1.8;
        }

        .hero-icon {
            font-size: 25rem;
            color: rgba(255, 77, 141, 0.1);
            position: absolute;
            right: 5%;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }

        /* Buttons */
        .buttons {
            display: flex;
            gap: 20px;
            margin-top: 40px;
        }

        .btn {
            padding: 15px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--wm-blue), var(--wm-pink));
            color: var(--wm-white);
            box-shadow: 0 4px 15px rgba(30, 80, 226, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(30, 80, 226, 0.6);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--wm-white);
            border: 2px solid var(--wm-white);
        }

        .btn-secondary:hover {
            background-color: var(--wm-white);
            color: var(--wm-black);
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 150px 5% 80px;
            }

            .hero-content {
                max-width: 100%;
                margin-bottom: 50px;
            }

            .hero-icon {
                position: relative;
                right: auto;
                font-size: 15rem;
                margin-top: 30px;
            }

            .buttons {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 5%;
            }

            .logo-center {
                font-size: 1.8rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-icon {
                font-size: 10rem;
            }

            .btn {
                padding: 12px 25px;
                font-size: 0.9rem;
            }
        }
    </style>
    {{-- INI STYLE START YEE --}}
    
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-center">CBScholarships</div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Temukan Beasiswa Impian Anda</h1>
            <h2 class="hero-subtitle">Membuka Pintu Menuju Masa Depan yang Lebih Cerah</h2>
            <p class="hero-text">
                CBScholarships berkomitmen untuk mendukung mahasiswa berprestasi dalam meraih impian pendidikan tinggi.
                Kami menyediakan akses ke berbagai program beasiswa yang dapat meringankan biaya kuliah dan memberikan
                kesempatan untuk mengembangkan potensi akademik.
            </p>
            <div class="buttons">
                <a href="{{ route('regis') }}">
                    <button class="btn btn-primary">DAFTAR SEKARANG</button>
                </a>
                <a href="{{ route('login') }}">
                    <button class="btn btn-secondary">MASUK</button>
                </a>
            </div>
        </div>
        <i class="fas fa-graduation-cap hero-icon"></i>
    </section>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(0, 0, 0, 0.9)';
                navbar.style.padding = '15px 5%';
            } else {
                navbar.style.background = 'var(--wm-black)';
                navbar.style.padding = '20px 5%';
            }
        });
    </script>
</body>

</html>
