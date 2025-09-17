<!-- Sidebar -->
<ul id="sidebar" class="navbar-nav sidebar sidebar-dark">
    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start py-3 px-3" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15" style="transition: transform 0.5s;">
            <img src="{{ asset('logo/intel amfibi.png') }}" alt="Logo" 
                 style="width:40px; height:40px; object-fit:contain;">
        </div>
        <div class="sidebar-brand-text fw-bold sidebar-text" style="font-size: 1.2rem; margin-left: 30px;">
            SIMAK
        </div>
    </a>

    <hr class="sidebar-divider my-2">

    <!-- Main Menu Heading -->
    <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
        Main Menu
    </div>

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>
    </li>

    @role('admin|guru_mi')
    <hr class="sidebar-divider my-2">

    <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
        Manajemen MI
    </div>

    <!-- Data Siswa -->
    <li class="nav-item {{ request()->is('siswa-mi*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('siswa-mi.index') }}">
            <i class="fas fa-user-graduate me-2"></i>
            <span class="sidebar-text">Data Siswa</span>
        </a>
    </li>

    <!-- Data Guru -->
    <li class="nav-item {{ request()->is('guru-mi*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('guru-mi.index') }}">
            <i class="fas fa-chalkboard-teacher me-2"></i>
            <span class="sidebar-text">Data Guru</span>
        </a>
    </li>

    <!-- Administrasi -->
    <li class="nav-item {{ request()->is('pembayaran-mi*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('pembayaran-mi.index') }}">
            <i class="fas fa-credit-card me-2"></i>
            <span class="sidebar-text">Administrasi</span>
        </a>
    </li>
    @endrole

    @role('admin|guru_tk')
    <hr class="sidebar-divider my-2">

    <div class="sidebar-heading px-3 text-uppercase text-white fw-bold sidebar-text" style="font-size:0.85rem; opacity:0.8;">
        Manajemen TK
    </div>

    <!-- Data Siswa -->
    <li class="nav-item {{ request()->is('siswa-tk*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('siswa-tk.index') }}">
            <i class="fas fa-user-graduate me-2"></i>
            <span class="sidebar-text">Data Siswa</span>
        </a>
    </li>

    <!-- Data Guru -->
    <li class="nav-item {{ request()->is('guru-tk*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('guru-tk.index') }}">
            <i class="fas fa-chalkboard-teacher me-2"></i>
            <span class="sidebar-text">Data Guru</span>
        </a>
    </li>

    <!-- Administrasi -->
    <li class="nav-item {{ request()->is('pembayaran-tk*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-2 px-3 rounded hover-bg-light" href="{{ route('pembayaran-tk.index') }}">
            <i class="fas fa-credit-card me-2"></i>
            <span class="sidebar-text">Administrasi</span>
        </a>
    </li>
     @endrole
</ul>

<!-- Tombol Toggle -->
<button id="toggleSidebar" 
    style="position:fixed;
           top:10px;
           left:230px;
           z-index:1000;
           border:none;
           background:#4e73df;
           color:white;
           padding:6px 10px;
           border-radius:6px;
           cursor:pointer;
           transition: left 0.3s ease;">
    <i id="toggleIcon" class="fas fa-angle-left"></i>
</button>

<style>
    /* Sidebar Style */
    .sidebar {
        background: linear-gradient(180deg, #4e73df, #224abe);
        border-radius: 12px;
        box-shadow: 2px 4px 12px rgba(0,0,0,0.15);
        padding:0.5rem 0;
        width: 220px;
        position: fixed;
        top:0;
        left:0;
        height:100vh;
        transition: transform 0.3s ease;
        overflow-x: hidden;
        z-index: 999;
    }

    /* Mode collapsed → geser keluar layar */
    .sidebar.collapsed {
        transform: translateX(-100%);
    }

    /* Text hilang smooth */
    .sidebar.collapsed .sidebar-text {
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    /* Konten utama responsif */
    #content-wrapper {
        margin-left: 220px; 
        transition: margin-left 0.3s ease;
    }
    .sidebar.collapsed ~ #content-wrapper {
        margin-left: 0; 
    }

    .hover-bg-light:hover {
        background-color: rgba(255,255,255,0.15);
        transition: all 0.3s ease;
    }

    .rotate-n-15:hover {
        transform: rotate(-10deg) scale(1.1);
    }

    .nav-item .nav-link.active {
        background-color: rgba(255,255,255,0.25);
        font-weight: 600;
    }

    .sidebar-heading {
        margin-top: 0.5rem;
        margin-bottom: 0.25rem;
    }
</style>

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
            toggleIcon.classList.remove("fa-angle-left");
            toggleIcon.classList.add("fa-angle-right");
        } else {
            toggleBtn.style.left = "230px"; 
            contentWrapper.style.marginLeft = "220px";
            toggleIcon.classList.remove("fa-angle-right");
            toggleIcon.classList.add("fa-angle-left");
        }
    });
</script>
