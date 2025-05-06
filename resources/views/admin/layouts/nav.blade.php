<!-- Sidebar Navigation -->
<nav class="sidebar col-md-3 col-lg-2 d-flex flex-column">
    <div class="sidebar-header mb-4 d-flex justify-content-between align-items-center">
        <h4 class="text-uppercase fw-bold mb-0">
            <i class="fas fa-bars me-2"></i>Menu
        </h4>
        <button class="btn-close-sidebar d-md-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> <span>Home</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.beasiswa.index') }}"
                class="nav-link {{ Request::is('admin/beasiswa') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap me-2"></i> <span>Beasiswa</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.jenis-beasiswa.index') }}"
                class="nav-link {{ Request::is('admin/jenis-beasiswa') ? 'active' : '' }}">
                <i class="fas fa-tags me-2"></i> <span>Jenis Beasiswa</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.periode.index') }}"
                class="nav-link {{ Request::is('admin/periode*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt me-2"></i> <span>Periode Beasiswa</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.syarat.index') }}"
                class="nav-link {{ Request::is('admin/syarat') ? 'active' : '' }}">
                <i class="fas fa-check-circle me-2"></i> <span>Syarat</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.pengajuan.index') }}"
                class="nav-link {{ Request::is('admin/pengajuan') ? 'active' : '' }}">
                <i class="fas fa-bullhorn me-2"></i> <span>Daftar Pengajuan</span>
                &nbsp;
                <span class="badge text-bg-warning">
                    {{ getCountPengajuan() }}
                </span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.laporan.index') }}"
                class="nav-link {{ Request::is('admin/laporan') ? 'active' : '' }}">
                <i class="fas fa-file-alt me-2"></i> <span>Laporan</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.mahasiswa.index') }}"
                class="nav-link {{ Request::is('admin/mahasiswa') ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i> <span>Mahasiswa</span>
                &nbsp;
                <span class="badge text-bg-primary">
                    {{ getMahasiswa() }}
                </span>
            </a>
        </li>
    </ul>
</nav>
