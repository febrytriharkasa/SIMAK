<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Yayasan Faisal</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Menu MI -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMI" 
                aria-expanded="true" aria-controls="collapseMI">
                <i class="fas fa-school"></i>
                <span>Manajemen MI</span>
            </a>
            <div id="collapseMI" class="collapse" aria-labelledby="headingMI" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Halaman MI:</h6>
                    <a class="collapse-item" href="{{ route('siswa-mi.index') }}">Data Siswa</a>
                    <a class="collapse-item" href="{{ route('guru-mi.index') }}">Data Guru</a>
                    <a class="collapse-item" href="{{ route('pembayaran-mi.index') }}">Administrasi</a>
                </div>
            </div>
        </li>
</ul>
