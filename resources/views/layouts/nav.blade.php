<!-- Sidebar Navigation -->
<nav class="sidebar col-md-3 col-lg-2 d-flex flex-column">
    <div class="sidebar-header mb-4">
        <h4 class="text-center text-uppercase fw-bold"
            style="color: var(--wm-white); border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 10px;">
            <i class="fas fa-bars me-2"></i>Menu
        </h4>
    </div>
    <ul class="nav flex-column">
        @auth('mahasiswa')
        <li class="nav-item mb-2">
            <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ Request::is('mahasiswa/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        @endauth
        <li class="nav-item mb-2">
            <a href="{{ url('/beasiswa') }}" class="nav-link {{ Request::is('beasiswa') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap me-2"></i> Beasiswa
            </a>
        </li>
        @auth('mahasiswa')
        <li class="nav-item mb-2">
            <a href="{{ url('/pengajuan') }}" class="nav-link {{ Request::is('pengajuan*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn me-2"></i> Daftar Pengajuan
            </a>
        </li>
            <li class="nav-item mb-2">
                <a href="{{ url('/report') }}" class="nav-link {{ Request::is('report*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt me-2"></i> Laporan
                </a>
            </li>
        @endauth
    </ul>
</nav>
