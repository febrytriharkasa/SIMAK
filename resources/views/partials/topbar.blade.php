<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar shadow"
     style="height: 60px; position: fixed; top: 0; left: 220px; right: 0; z-index: 998; transition: left 0.3s ease;">
    <div class="container-fluid d-flex justify-content-between">

        <!-- Profil User -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 d-none d-lg-inline text-gray-600 small">
                        {{ Auth::user()->name }}
                    </span>
                    <img class="img-profile rounded-circle"
                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff"
                         width="35" height="35">
                </a>

                <!-- Dropdown -->
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                            Ganti Password
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
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
