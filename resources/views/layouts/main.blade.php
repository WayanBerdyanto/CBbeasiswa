<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBScholarships | @yield('title')</title>
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
            background-color: var(--wm-dark);
            color: var(--wm-white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .custom-header-footer {
            background-color: var(--wm-black);
            color: var(--wm-white);
            padding: 15px 5%;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            border-bottom: none;
        }

        .logo-center {
            font-size: 2rem;
            font-weight: 800;
            color: var(--wm-white);
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            margin: 0;
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

        /* Content */
        .content {
            padding: 30px;
            background-color: var(--wm-dark);
            flex: 1;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(90deg, var(--wm-blue), var(--wm-pink));
            color: var(--wm-white);
            border: none;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 30px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, var(--wm-blue-hover), var(--wm-pink-hover));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 80, 226, 0.6);
        }

        /* Cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            background-color: var(--wm-gray);
            border: none;
            color: var(--wm-white);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            font-weight: 600;
            background-color: var(--wm-light-gray);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Dropdown */
        .dropdown-toggle {
            background-color: var(--wm-gray);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--wm-white);
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            background-color: var(--wm-light-gray);
        }

        .dropdown-menu {
            background-color: var(--wm-gray);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .dropdown-item {
            color: var(--wm-white);
            padding: 10px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--wm-light-gray);
            color: var(--wm-white);
        }

        /* Form controls */
        .form-control,
        .form-select {
            background-color: var(--wm-gray);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--wm-white);
            border-radius: 4px;
            padding: 10px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--wm-gray);
            color: var(--wm-white);
            border-color: var(--wm-blue);
            box-shadow: 0 0 0 0.25rem rgba(30, 80, 226, 0.25);
        }

        /* Footer */
        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--wm-white);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--wm-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--wm-light-gray);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--wm-blue);
        }
    </style>
</head>
@stack('scripts')

<body>
    <!-- HEADER -->
    <header class="custom-header-footer">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="logo-center">
                <i class="fas fa-graduation-cap me-2"></i>CBScholarships
            </h1>
            <!-- Dropdown User -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-user me-2"></i> {{ Auth::user()->nama }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="/profile"><i class="fas fa-user-circle me-2"></i>Profile</a></li>

                    <li><a class="dropdown-item" href="/user"><i class="fas fa-key me-2"></i>Change
                            Password</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- BODY -->
    <div class="container-fluid d-flex flex-grow-1">
        <!-- MENU -->
        @include('admin.layouts.nav')


        <!-- CONTENT -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="custom-header-footer py-3">
        <p class="text-center mb-0">
            <a href="#" class="footer-link">
                Bram & Calvin
            </a>
        </p>
    </footer>

    {{-- Sweet Alert --}}
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
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('header');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(0, 0, 0, 0.9)';
                navbar.style.padding = '10px 5%';
            } else {
                navbar.style.background = 'var(--wm-black)';
                navbar.style.padding = '15px 5%';
            }
        });
    </script>
</body>

</html>
