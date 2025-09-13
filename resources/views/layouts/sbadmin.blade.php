<!-- resources/views/layouts/sbadmin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('download.png') }}" type="image/png">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* === SIDEBAR === */
        .sidebar { background: linear-gradient(180deg, #4e73df, #224abe); border-radius: 12px; box-shadow: 2px 4px 12px rgba(0,0,0,0.15); padding: 0.5rem 0; width: 220px; position: fixed; top: 70px; left: 0; height: calc(100vh - 70px); transition: transform 0.3s ease; overflow-x: hidden; z-index: 1040; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar.collapsed .sidebar-text { opacity: 0; transition: opacity 0.2s ease; }
        .hover-bg-light:hover { background-color: rgba(255,255,255,0.15); transition: all 0.3s ease; }
        .rotate-n-15:hover { transform: rotate(-10deg) scale(1.1); }
        .nav-item .nav-link.active { background-color: rgba(255,255,255,0.25); font-weight: 600; }

        /* === TOPBAR === */
        .topbar { z-index: 1050; height: 70px; }

        /* === CONTENT WRAPPER === */
        #content-wrapper { margin-left: 220px; padding-top: 80px; transition: margin-left 0.3s ease; }
        .sidebar.collapsed ~ #content-wrapper { margin-left: 0; }
    </style>
</head>

<body id="page-top">
<div id="wrapper">
    <!-- Sidebar -->
    <ul id="sidebar" class="navbar-nav sidebar sidebar-dark">
        <!-- Sidebar Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-start py-3 px-3" href="{{ url('/dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15" style="transition: transform 0.5s;">
                <img src="{{ asset('logo/intel amfibi.png') }}" alt="Logo" style="width:40px; height:40px; object-fit:contain;">
            </div>
            <div class="sidebar-brand-text ms-2 fw-bold sidebar-text" style="font-size: 1.2rem;">
                SIMAK
            </div>
        </a>

        <hr class="sidebar-divider my-2">

        <!-- Dashboard Admin -->
        @role('admin')
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt me-2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>
        @endrole

        <!-- Dashboard Guru -->
       @role('guru_mi')
        <li class="nav-item {{ request()->is('guru/mi/dashboard') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" 
            href="{{ route('guru-mi.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                <span class="sidebar-text">Dashboard Guru MI</span>
            </a>
        </li>
        @endrole

        @role('guru_tk')
        <li class="nav-item {{ request()->is('guru/tk/dashboard') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" 
            href="{{ route('guru-tk.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                <span class="sidebar-text">Dashboard Guru TK</span>
            </a>
        </li>
        @endrole

        

        <!-- Manajemen MI -->
        @hasanyrole('admin|guru_mi')
            <hr class="sidebar-divider my-2">
            <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
                Manajemen MI
            </div>

            <li class="nav-item {{ request()->is('siswa-mi*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('siswa-mi.index') }}">
                    <i class="fas fa-user-graduate me-2"></i>
                    <span class="sidebar-text">Data Siswa</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('guru-mi*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('guru-mi.index') }}">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    <span class="sidebar-text">Data Guru</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('pembayaran-mi*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('pembayaran-mi.index') }}">
                    <i class="fas fa-credit-card me-2"></i>
                    <span class="sidebar-text">Administrasi</span>
                </a>
            </li>
        @endhasanyrole

        <!-- Manajemen TK -->
        @hasanyrole('admin|guru_tk')
            <hr class="sidebar-divider my-2">
            <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
                Manajemen TK
            </div>

            <li class="nav-item {{ request()->is('siswa-tk*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('siswa-tk.index') }}">
                    <i class="fas fa-user-graduate me-2"></i>
                    <span class="sidebar-text">Data Siswa</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('guru-tk*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('guru-tk.index') }}">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    <span class="sidebar-text">Data Guru</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('pembayaran-tk*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('pembayaran-tk.index') }}">
                    <i class="fas fa-credit-card me-2"></i>
                    <span class="sidebar-text">Administrasi</span>
                </a>
            </li>
        @endhasanyrole

        <!-- Manajemen User (Admin) -->
        @role('admin')
            <hr class="sidebar-divider my-2">
            <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
                Pengguna
            </div>

            <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('users.index') }}">
                    <i class="fas fa-user me-2"></i>
                    <span class="sidebar-text">User</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('register') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('register') }}">
                    <i class="fas fa-user-plus me-2"></i>
                    <span class="sidebar-text">Registrasi</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('user-approvals*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('user.approvals.index') }}">
                    <i class="fas fa-user-check me-2"></i>
                    <span class="sidebar-text">Approval</span>
                </a>
            </li>
        @endrole

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span class="sidebar-text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

    <!-- Toggle Sidebar Button -->
    <button id="toggleSidebar" style="position:fixed; top:80px; left:230px; z-index:1100; border:none; background:#4e73df; color:white; padding:6px 10px; border-radius:6px; cursor:pointer; transition: left 0.3s ease;">
        <i id="toggleIcon" class="fas fa-angle-left"></i>
    </button>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar fixed-top shadow">
            <div class="container-fluid">
                <h3 class="fw-bold mb-0 text-primary" style="margin-left: 30px;">Sistem Menejemen Al Kushnaniyah</h3>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-profile rounded-circle me-2"
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=435ebe&color=fff"
                                 width="32" height="32">
                            <span class="me-2 text-dark fw-bold small">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="content" class="container-fluid">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white mt-auto py-3 shadow-sm">
            <div class="container my-auto text-center">
                <span class="text-muted small">© {{ date('Y') }} SIMAK MI - AMPEL</span>
            </div>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    const contentWrapper = document.getElementById('content-wrapper');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        if (sidebar.classList.contains('collapsed')) {
            toggleBtn.style.left = "10px";
            contentWrapper.style.marginLeft = "0";
            toggleIcon.classList.replace("fa-angle-left", "fa-angle-right");
        } else {
            toggleBtn.style.left = "230px";
            contentWrapper.style.marginLeft = "220px";
            toggleIcon.classList.replace("fa-angle-right", "fa-angle-left");
        }
    });
</script>

@stack('scripts')
</body>
</html>
