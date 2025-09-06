<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('download.png') }}" alt="Logo" 
                style="width: 40px; height: 40px; object-fit: contain;">
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

    @role('admin|guru_mi')
    <!-- Menu MI -->
    <li class="nav-item {{ request()->is('siswa-mi*') || request()->is('guru-mi*') || request()->is('pembayaran-mi*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMI" 
            aria-expanded="{{ request()->is('siswa-mi*') || request()->is('guru-mi*') || request()->is('pembayaran-mi*') ? 'true' : 'false' }}" 
            aria-controls="collapseMI">
            <i class="fas fa-school"></i>
            <span>Manajemen MI</span>
            <i class="fas fa-chevron-down ml-auto small"></i>
        </a>
        <div id="collapseMI" class="collapse {{ request()->is('siswa-mi*') || request()->is('guru-mi*') || request()->is('pembayaran-mi*') ? 'show' : '' }}" 
            aria-labelledby="headingMI" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <a class="collapse-item d-flex align-items-center {{ request()->is('siswa-mi*') ? 'active' : '' }}" href="{{ route('siswa-mi.index') }}">
                    <i class="fas fa-user-graduate text-primary mr-2"></i> Data Siswa
                </a>
                <a class="collapse-item d-flex align-items-center {{ request()->is('guru-mi*') ? 'active' : '' }}" href="{{ route('guru-mi.index') }}">
                    <i class="fas fa-chalkboard-teacher text-success mr-2"></i> Data Guru
                </a>
                <a class="collapse-item d-flex align-items-center {{ request()->is('pembayaran-mi*') ? 'active' : '' }}" href="{{ route('pembayaran-mi.index') }}">
                    <i class="fas fa-file-invoice-dollar text-warning mr-2"></i> Administrasi
                </a>
            </div>
        </div>
    </li>
    @endrole    

    @role('admin|guru_tk')
    <!-- Menu TK -->
    <li class="nav-item {{ request()->is('siswa-tk*') || request()->is('guru-tk*') || request()->is('pembayaran-tk*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTK" 
            aria-expanded="{{ request()->is('siswa-tk*') || request()->is('guru-tk*') || request()->is('pembayaran-tk*') ? 'true' : 'false' }}" 
            aria-controls="collapseTK">
            <i class="fas fa-school"></i>
            <span>Manajemen TK</span>
            <i class="fas fa-chevron-down ml-auto small"></i>
        </a>
        <div id="collapseTK" class="collapse {{ request()->is('siswa-tk*') || request()->is('guru-tk*') || request()->is('pembayaran-tk*') ? 'show' : '' }}" 
            aria-labelledby="headingTK" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <a class="collapse-item d-flex align-items-center {{ request()->is('siswa-tk*') ? 'active' : '' }}" href="{{ route('siswa-tk.index') }}">
                    <i class="fas fa-user-graduate text-primary mr-2"></i> Data Siswa
                </a>
                <a class="collapse-item d-flex align-items-center {{ request()->is('guru-tk*') ? 'active' : '' }}" href="{{ route('guru-tk.index') }}">
                    <i class="fas fa-chalkboard-teacher text-success mr-2"></i> Data Guru
                </a>
                <a class="collapse-item d-flex align-items-center {{ request()->is('pembayaran-tk*') ? 'active' : '' }}" href="{{ route('pembayaran-tk.index') }}">
                    <i class="fas fa-file-invoice-dollar text-warning mr-2"></i> Administrasi
                </a>
            </div>
        </div>
    </li>
    @endrole

    @role('admin')
    <hr class="sidebar-divider d-none d-md-block">

    <!-- User -->
    <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-user"></i>
            <span>User</span>
        </a>
    </li>

    <!-- Tombol Regis -->
    <li class="nav-item {{ request()->is('register') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('register') }}">
            <i class="fas fa-user-plus"></i>
            <span>Registrasi</span>
        </a>
    </li>
    @endrole

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>
