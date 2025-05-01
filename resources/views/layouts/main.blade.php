<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBScholarships | @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/mahasiswa.css') }}">
</head>

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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
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
        @include('layouts.nav')


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
                customClass: {
                    popup: 'colored-toast',
                },
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
                customClass: {
                    popup: 'colored-toast',
                },
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

    @stack('scripts')
</body>

</html>
