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

<style>
    .sidebar {
        background-color: var(--wm-gray);
        padding: 20px;
        color: var(--wm-white);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        background-color: transparent;
        padding: 12px 15px;
        border-radius: 6px;
        transition: all 0.3s ease;
        font-weight: 400;
        display: flex;
        align-items: center;
        margin: 5px 0;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
        transform: translateX(5px);
        color: var(--wm-white) !important;
    }

    .nav-link.active {
        background: linear-gradient(90deg, var(--wm-blue), var(--wm-pink));
        color: var(--wm-white) !important;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(30, 80, 226, 0.3);
    }

    .nav-link i {
        width: 20px;
        text-align: center;
    }

    .sidebar-header {
        padding: 10px 0;
        margin-bottom: 20px;
    }
</style>
