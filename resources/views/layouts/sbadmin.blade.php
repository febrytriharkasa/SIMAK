<!-- resources/views/layouts/sbadmin.blade.php -->
<!DOCTYPE html>
<html lang="en">
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil tema dari localStorage
        let theme = localStorage.getItem("data-bs-theme") || "light";

        if (theme === "system") {
            theme = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", theme);

        // ubah ikon dropdown sesuai tema
        const icon = document.getElementById("themeIcon");
        if (theme === "light") {
            icon.className = "bi bi-sun";
        } else if (theme === "dark") {
            icon.className = "bi bi-moon";
        } else {
            icon.className = "bi bi-laptop";
        }
    });
    </script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/png">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/custom-dark.css') }}" rel="stylesheet">
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
                <img src="{{ asset('logo/logo.png') }}" alt="Logo" style="width:40px; height:40px; object-fit:contain;">
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

        <li class="nav-item {{ request()->is('evaluasi*') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('evaluasi.index') }}">
                <i class="bi bi-clipboard-check me-2"></i>
                <span class="sidebar-text">Evaluasi Kinerja</span>
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

             <li class="nav-item {{ request()->is('laporan-pembayaran-mi*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('laporan-pembayaran-mi.index') }}">
                    <i class="fas fa-credit-card me-2"></i>
                    <span class="sidebar-text">Laporan Administrasi</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('nilai') || request()->is('nilai/*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('nilai.index') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span class="sidebar-text">Input Nilai</span>
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

              <li class="nav-item {{ request()->is('laporan-pembayaran-tk*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('laporan-pembayaran-tk.index') }}">
                    <i class="fas fa-credit-card me-2"></i>
                    <span class="sidebar-text">Laporan Administrasi</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('nilai-tk') || request()->is('nilai-tk/*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('nilai-tk.index') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span class="sidebar-text">Input Nilai</span>
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

            <li class="nav-item {{ request()->is('roles*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('admin.password-requests') }}">
                    <i class="fas fa-user-shield me-2"></i>
                    <span class="sidebar-text">Request Password</span>
                    @if(isset($pendingRequests) && $pendingRequests > 0)
                        <span class="badge bg-danger ms-auto">{{ $pendingRequests }}</span>
                    @endif
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
            <h3 class="fw-bold mb-0 topbar-title" style="margin-left: 30px;">
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

                        <img src="{{ Auth::user()->foto 
                            ? route('profile.avatar', ['id' => Auth::user()->id, 'v' => time()]) 
                            : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=435ebe&color=fff' }}" 
                            alt="User Avatar" 
                            class="rounded-circle" 
                            style="width: 40px; height: 40px; object-fit: cover;">

                        <span id="usernameText" class="fw-bold small" style="margin-left: 10px;">
                            {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <!-- Profil -->
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Logout -->
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
        <footer class="sticky-footer  py-3">
            <div class=>
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