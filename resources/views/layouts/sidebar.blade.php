<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="dashboard">
                <i class="mdi mdi-view-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        {{-- sidebar Sebaran untuk admin --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-arrow-expand-all menu-icon"></i>
                <span class="menu-title">Sebaran</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/ui-features/buttons.html">Jenis Profesi</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="pages/ui-features/dropdowns.html">Profesi</a></li>
                    <li class="nav-item"><a class="nav-link" href="pages/ui-features/typography.html">Kesesuaian</a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- end sebaran --}}

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="mdi mdi-timer-sand menu-icon"></i>
                <span class="menu-title">Masa Tunggu</span>
            </a>
        </li>

        {{-- sidebar Penilaian untuk admin --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="mdi mdi-star-circle menu-icon"></i>
                <span class="menu-title">Pengguna</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/ui-features/buttons.html">Tabel Kepuasan</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="pages/ui-features/dropdowns.html">Grafik Kepuasan</a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- end penilaian --}}

        {{-- alumni sidebar admin --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Alumni</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="#">Data Alumni</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Data Tracer</a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- end sidebar alumni --}}


        {{-- sidebar Kuisioner admin --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="mdi mdi-comment-question-outline menu-icon"></i>
                <span class="menu-title">Kuisioner</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Alumni</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Pengguna</a></li>
                </ul>
            </div>
        </li>
        {{-- end kuisioner admin --}}

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="mdi mdi-account-key menu-icon"></i>
                <span class="menu-title">Admin</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>


    </ul>
</nav>
<!-- partial -->
