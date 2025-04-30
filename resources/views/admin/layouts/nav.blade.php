<!-- Sidebar Navigation -->
<nav class="sidebar col-md-3 col-lg-2 d-flex flex-column">
    <div class="sidebar-header mb-4">
        <h4 class="text-center text-uppercase fw-bold"
            style="color: var(--wm-white); border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 10px;">
            <i class="fas fa-bars me-2"></i>Menu
        </h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Home
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.beasiswa.index') }}" class="nav-link {{ Request::is('admin/beasiswa') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap me-2"></i> Beasiswa
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.pengajuan.index') }}" class="nav-link {{ Request::is('admin/pengajuan') ? 'active' : '' }}">
                <i class="fas fa-bullhorn me-2"></i> Daftar Pengajuan
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ Request::is('admin/laporan') ? 'active' : '' }}">
                <i class="fas fa-file-alt me-2"></i> Laporan
            </a>
        </li>
    </ul>
</nav>
