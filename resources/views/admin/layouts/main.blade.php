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
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>

<body>
    <!-- HEADER -->
    <header class="custom-header-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button id="sidebar-toggle" class="btn d-md-none me-3">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="logo-center">
                    <i class="fas fa-graduation-cap me-2"></i><span class="d-none d-sm-inline">CBScholarships</span><span class="d-inline d-sm-none">CBS</span>
                </h1>
            </div>
            <!-- Dropdown User -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-user me-2"></i> <span class="d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span>
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
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
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
        <div id="sidebar-wrapper" class="sidebar-wrapper">
            @include('admin.layouts.nav')
        </div>

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

        // Sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarWrapper = document.getElementById('sidebar-wrapper');
            const content = document.querySelector('.content');
            const closeBtn = document.querySelector('.btn-close-sidebar');
            
            // Check screen size and set initial state
            function checkScreen() {
                if (window.innerWidth < 768) {
                    sidebarWrapper.classList.add('sidebar-hidden');
                    content.classList.add('content-expanded');
                } else {
                    sidebarWrapper.classList.remove('sidebar-hidden');
                    content.classList.remove('content-expanded');
                }
            }
            
            // Initial check
            checkScreen();
            
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', function() {
                sidebarWrapper.classList.toggle('sidebar-active');
                document.body.classList.toggle('sidebar-open');
            });
            
            // Close sidebar when clicking the close button
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    sidebarWrapper.classList.remove('sidebar-active');
                    document.body.classList.remove('sidebar-open');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 768 && 
                    sidebarWrapper.classList.contains('sidebar-active') && 
                    !sidebarWrapper.contains(event.target) && 
                    !sidebarToggle.contains(event.target)) {
                    sidebarWrapper.classList.remove('sidebar-active');
                    document.body.classList.remove('sidebar-open');
                }
            });
            
            // Handle resize
            window.addEventListener('resize', checkScreen);
        });
    </script>
    
    @stack('scripts')
</body>

</html>
