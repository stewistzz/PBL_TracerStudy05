<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        
        {{-- sidebar Sebaran untuk admin --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-arrow-expand-all menu-icon"></i>
                <span class="menu-title">Sebaran</span>
                <i class="mdi mdi-menu-down ml-auto"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('kategori_profesi.index') }}">Jenis
                            Profesi</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/profesi') }}">Profesi</a></li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.kesesuaian') }}">Kesesuaian</a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- end sebaran --}}

        {{-- sidebar instansi --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('instansi.index') }}">
                <i class="mdi mdi-domain menu-icon"></i>
                <span class="menu-title">Instansi</span>
            </a>
        </li>

        {{-- sidebar masa tunggu --}}
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
                <i class="mdi mdi-menu-down ml-auto"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('data_pengguna.index') }}">Data Pengguna</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kepuasan.index') }}">Tabel Kepuasan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kepuasan.grafik') }}">Grafik Kepuasan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('jawaban_pengguna.index') }}">Jawaban Pengguna</a></li>
                </ul>
            </div>
        </li>
        {{-- end penilaian --}}

     {{-- alumni sidebar admin --}}
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
        <i class="mdi mdi-account-group menu-icon"></i>
        <span class="menu-title">Alumni</span>
        <i class="mdi mdi-menu-down ml-auto"></i>
    </a>
    <div class="collapse" id="tables">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{ route('alumni.index') }}">Data Alumni</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('alumni_tracer.index') }}">Data Tracer</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('jawaban_alumni.index') }}">Jawaban Alumni</a></li>
        </ul>
    </div>
</li>
        {{-- end sidebar alumni --}}

        {{-- Data Ueer --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Data user</span>
            </a>
        </li>

        {{-- sidebar Kuisioner admin --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="mdi mdi-comment-question-outline menu-icon"></i>
                <span class="menu-title">Kuisioner</span>
                <i class="mdi mdi-menu-down ml-auto"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('kategori_pertanyaan.index') }}">Kategori</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('pertanyaan.index') }}">Pertanyaan</a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- end kuisioner admin --}}

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
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

<style>
    /* Buat sidebar tetap di kiri dan menempel saat scroll */
    .sidebar {
        position: fixed;
    }

    /* Tambahkan padding/margin pada konten utama agar tidak tertutup sidebar */
    .main-panel {
        margin-left: 250px;
        /* sesuaikan dengan lebar sidebar */
    }
</style>
