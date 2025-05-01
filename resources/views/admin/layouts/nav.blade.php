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
            <a href="{{ route('admin.jenis-beasiswa.index') }}" class="nav-link {{ Request::is('admin/jenis-beasiswa') ? 'active' : '' }}">
                <i class="fas fa-tags me-2"></i> Jenis Beasiswa
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.periode.index') }}" class="nav-link {{ Request::is('admin/periode*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt me-2"></i> Periode Beasiswa
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.syarat.index') }}" class="nav-link {{ Request::is('admin/syarat') ? 'active' : '' }}">
                <i class="fas fa-check-circle me-2"></i> Syarat
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
        <li class="nav-item mb-2">
            <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ Request::is('admin/mahasiswa') ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i> Mahasiswa
            </a>
        </li>
    </ul>
</nav>
