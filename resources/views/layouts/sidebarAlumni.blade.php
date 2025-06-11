<link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('alumni.dashboard') }}">
                <i class="mdi mdi-view-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- Sidebar Kuisioner --}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-arrow-expand-all menu-icon"></i>
                <span class="menu-title">Kuisioner</span>
                <i class="mdi mdi-menu-down ml-auto rotate-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tracer-study.index') }}">Tracer Study</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- Logout --}}
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
</nav>

<!-- Script harus urut dan sesuai versi Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .rotate-icon.rotate {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(link => {
            link.addEventListener('click', function () {
                const icon = this.querySelector('.rotate-icon');
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Rotate icon for the clicked one
                if (icon) {
                    icon.classList.toggle('rotate', !isExpanded);
                }

                // Reset other icons
                document.querySelectorAll('.rotate-icon').forEach(otherIcon => {
                    if (otherIcon !== icon) {
                        otherIcon.classList.remove('rotate');
                    }
                });
            });
        });
    });
</script>
