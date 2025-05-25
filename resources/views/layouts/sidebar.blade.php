<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
     <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#sebaran-submenu" aria-expanded="false" aria-controls="sebaran-submenu">
        <i class="mdi mdi-arrow-expand-all menu-icon"></i>
        <span class="menu-title">Sebaran</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="sebaran-submenu">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('kategori_profesi.index') }}">Kategori Profesi</a>
            </li>
            {{-- Tambahkan submenu lainnya jika perlu --}}
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('instansi.index') }}">
        <i class="mdi mdi-domain menu-icon"></i>
        <span class="menu-title">Instansi</span>
    </a>
</li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="mdi mdi-timer-sand menu-icon"></i>
                <span class="menu-title">Masa Tunggu</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="mdi mdi-star-circle menu-icon"></i>
                <span class="menu-title">Penilaian Pengguna</span>
            </a>
        </li>
    <li class="nav-item">
    <a class="nav-link" href="{{ route('alumni.index') }}">
        <i class="mdi mdi-account-group menu-icon"></i>
        <span class="menu-title">Alumni</span>
    </a>
</li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="mdi mdi-comment-question-outline menu-icon"></i>
                <span class="menu-title">Kuisioner</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="mdi mdi-file-chart menu-icon"></i>
                <span class="menu-title">Laporan</span>
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
