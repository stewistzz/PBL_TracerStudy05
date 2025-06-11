<!-- partial:partials/_sidebar.html -->
<link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- sidebar Sebaran untuk admin --}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#ui-basic" role="button" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="mdi mdi-arrow-expand-all menu-icon"></i>
                <span class="menu-title">Sebaran</span>
                <i class="mdi mdi-menu-down ml-auto rotate-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('kategori_profesi.index') }}">Jenis
                            Profesi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/profesi') }}">Profesi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.kesesuaian') }}">Kesesuaian</a></li>
                </ul>
            </div>
        </li>

        {{-- sidebar Instansi --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('instansi*') ? 'active' : '' }}" href="{{ route('instansi.index') }}">
                <i class="mdi mdi-domain menu-icon"></i>
                <span class="menu-title">Instansi</span>
            </a>
        </li>


        {{-- Masa tunggu --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('masa_tunggu') ? 'active' : '' }}"
                href="{{ route('masa_tunggu.index') }}">
                <i class="mdi mdi-timer-sand menu-icon"></i>
                <span class="menu-title">Masa tunggu</span>
            </a>
        </li>

        {{-- sidebar Penilaian --}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#charts" aria-expanded="false"
                aria-controls="charts">
                <i class="mdi mdi-star-circle menu-icon"></i>
                <span class="menu-title">Pengguna</span>
                <i class="mdi mdi-menu-down ml-auto rotate-icon"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('data_pengguna.index') }}">Data Pengguna</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kepuasan.index') }}">Tabel Kepuasan</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kepuasan.grafik') }}">Grafik Kepuasan</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('jawaban_pengguna.index') }}">Jawaban
                            Pengguna</a></li>
                </ul>
            </div>
        </li>

        {{-- alumni sidebar --}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#tables" aria-expanded="false"
                aria-controls="tables">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Alumni</span>
                <i class="mdi mdi-menu-down ml-auto rotate-icon"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('alumni.index') }}">Data Alumni</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('alumni_tracer.index') }}">Data Tracer</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('jawaban_alumni.index') }}">Jawaban
                            Alumni</a></li>
                </ul>
            </div>
        </li>

        {{-- Data User --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Data User</span>
            </a>
        </li>

        {{-- sidebar Kuisioner --}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#icons" aria-expanded="false"
                aria-controls="icons">
                <i class="mdi mdi-comment-question-outline menu-icon"></i>
                <span class="menu-title">Kuisioner</span>
                <i class="mdi mdi-menu-down ml-auto rotate-icon"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('kategori_pertanyaan.index') }}">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pertanyaan.index') }}">Pertanyaan</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- sidebar Admin --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                <i class="mdi mdi-account-key menu-icon"></i>
                <span class="menu-title">Admin</span>
            </a>
        </li>

        {{-- logout --}}
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



<!-- Pastikan jQuery dan Bootstrap JS sudah ada sebelum ini -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]');

        navLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetSelector = this.getAttribute('href');
                const target = document.querySelector(targetSelector);
                const icon = this.querySelector('.rotate-icon');

                // Toggle current submenu
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                if (isExpanded) {
                    icon.classList.remove('rotate');
                } else {
                    icon.classList.add('rotate');
                }

                // Tutup semua menu lain
                document.querySelectorAll('.sidebar .collapse').forEach(function(collapseEl) {
                    if (collapseEl !== target) {
                        const toggleBtn = document.querySelector('[href="#' + collapseEl
                            .id + '"]');
                        collapseEl.classList.remove('show');
                        if (toggleBtn) {
                            toggleBtn.setAttribute('aria-expanded', 'false');
                            const otherIcon = toggleBtn.querySelector('.rotate-icon');
                            if (otherIcon) {
                                otherIcon.classList.remove('rotate');
                            }
                        }
                    }
                });
            });
        });
    });
</script>
