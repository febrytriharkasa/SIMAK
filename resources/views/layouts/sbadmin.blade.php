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
        .sidebar { 
            background: linear-gradient(180deg, #4e73df, #224abe); 
            border-radius: 12px; 
            box-shadow: 2px 4px 12px rgba(0,0,0,0.15); 
            padding: 0.5rem 0; 
            width: 220px; 
            position: fixed; 
            top: 70px; 
            left: 0; 
            height: calc(100vh - 70px); 
            transition: transform 0.3s ease; 
            overflow-x: hidden; 
            z-index: 1040; 
            display: flex;
            flex-direction: column;
        }
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

        /* Light mode (default) */
        [data-bs-theme="light"] .sidebar {
            background: linear-gradient(180deg, #4e73df, #224abe);
            color: #fff;
        }

        /* Dark mode */
        [data-bs-theme="dark"] .sidebar {
            background: linear-gradient(180deg, #1f1f2e, #111827);
            color: #f8f9fa;
        }
        [data-bs-theme="dark"] .sidebar .nav-link {
            color: #f8f9fa;
        }
        [data-bs-theme="dark"] .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }
        [data-bs-theme="dark"] .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
        }

        /* BODY */
        [data-bs-theme="light"] body {
            background-color: #f8f9fc;
            color: #000;
        }
        [data-bs-theme="dark"] body {
            background-color: #1e1e2f;
            color: #f8f9fa;
        }

        /* TOPBAR */
        [data-bs-theme="light"] .topbar {
            background-color: #ffffff !important;
            color: #000 !important;
        }
        [data-bs-theme="dark"] .topbar {
            background-color: #2c2c3c !important;
            color: #f8f9fa !important;
        }

        /* FOOTER */
        [data-bs-theme="light"] .sticky-footer {
            background-color: #ffffff !important;
            color: #000 !important;
        }
        [data-bs-theme="dark"] .sticky-footer {
            background-color: #2c2c3c !important;
            color: #f8f9fa !important;
        }

        /* CARD */
        [data-bs-theme="light"] .card {
            background-color: #ffffff;
            color: #000;
        }
        [data-bs-theme="dark"] .card {
            background-color: #2a2a3b;
            color: #f8f9fa;
            border-color: #444;
        }

        /* CONTENT WRAPPER */
        [data-bs-theme="dark"] #content-wrapper {
            background-color: #1e1e2f;
        }

        .logout-item {
            margin-top: 400px;
        }

        /* ========================= */
        /* === TEKS SESUAI TEMA === */
        /* ========================= */

        /* Default Light */
        [data-bs-theme="light"] body,
        [data-bs-theme="light"] #content-wrapper,
        [data-bs-theme="light"] .sidebar,
        [data-bs-theme="light"] .topbar,
        [data-bs-theme="light"] .sticky-footer {
            color: #212529 !important; /* teks gelap */
        }

        /* Dark */
        [data-bs-theme="dark"] body,
        [data-bs-theme="dark"] #content-wrapper,
        [data-bs-theme="dark"] .sidebar,
        [data-bs-theme="dark"] .topbar,
        [data-bs-theme="dark"] .sticky-footer {
            color: #f8f9fa !important; /* teks terang */
        }

        /* Pastikan heading dan span ikut */
        [data-bs-theme="light"] h1, 
        [data-bs-theme="light"] h2, 
        [data-bs-theme="light"] h3, 
        [data-bs-theme="light"] h4, 
        [data-bs-theme="light"] h5, 
        [data-bs-theme="light"] h6,
        [data-bs-theme="light"] p,
        [data-bs-theme="light"] span,
        [data-bs-theme="light"] a,
        [data-bs-theme="light"] li {
            color: #212529 !important;
        }

        [data-bs-theme="dark"] h1, 
        [data-bs-theme="dark"] h2, 
        [data-bs-theme="dark"] h3, 
        [data-bs-theme="dark"] h4, 
        [data-bs-theme="dark"] h5, 
        [data-bs-theme="dark"] h6,
        [data-bs-theme="dark"] p,
        [data-bs-theme="dark"] span,
        [data-bs-theme="dark"] a,
        [data-bs-theme="dark"] li {
            color: #f8f9fa !important;
        }

        /* ========================= */
        /* === KUNCI TEKS SIDEBAR === */
        /* ========================= */

        .sidebar-brand-text {
            color: #fff !important;
        }
        /* Semua teks sidebar tetap putih */
        .sidebar .nav-link,
        .sidebar .nav-link i,
        .sidebar .sidebar-heading,
        .sidebar .nav-item,
        .sidebar .nav-item a,
        .sidebar .nav-item span {
            color: #ffffff !important;
        }

        /* Aktif tetap kontras */
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.25) !important;
            font-weight: 600;
            color: #ffffff !important;
        }

        /* Hover tetap terang */
        .sidebar .nav-link:hover {
            color: #f8f9fa !important;
            background-color: rgba(255,255,255,0.15) !important;
        }


    </style>

    <script>
    function setTheme(theme) {
        localStorage.setItem("data-bs-theme", theme);
        if (theme === "system") {
            theme = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", theme);

        // ubah ikon utama dropdown sesuai tema
        let icon = document.getElementById("themeIcon");
        if (theme === "light") {
            icon.className = "bi bi-sun";
        } else if (theme === "dark") {
            icon.className = "bi bi-moon";
        } else {
            icon.className = "bi bi-laptop";
        }
    }
</script>

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
        <hr class="sidebar-divider my-2">
            <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
                Main Menu
            </div>

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
            <li class="nav-item logout-item d-flex justify-content-center">
                <a class="nav-link d-flex align-items-center justify-content-center py-3 px-3 rounded hover-bg-light"
                href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-5x"></i> 
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
            <h3 class="fw-bold mb-0 text-primary" style="margin-left: 30px;">
                Sistem Menejemen Al Kushnaniyah
            </h3>

            <!-- Right side navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Theme Dropdown -->
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="themeDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i id="themeIcon" class="bi bi-brightness-high-fill me-1" style="font-size: 1.5rem;"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
                        <li>
                            <a class="dropdown-item" href="javascript:setTheme('light')">
                                <i class="bi bi-sun me-2 text-warning"></i> Light
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:setTheme('dark')">
                                <i class="bi bi-moon me-2 text-primary"></i> Dark
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:setTheme('system')">
                                <i class="bi bi-laptop me-2 text-secondary"></i> System
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="img-profile rounded-circle me-2"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=435ebe&color=fff"
                            width="32" height="32">
                        <span id="usernameText" class="fw-bold small">{{ Auth::user()->name }}</span>
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
