<link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">

<div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start-center">
            <a class="navbar-brand brand-logo me-5 mr-2" href="index.html">
                <img src="{{ asset('skydash/template/images/logotracer.png') }}" class="me-2" alt="logo">
                {{-- Span ini akan kita kontrol visibilitasnya dengan CSS --}}
                <span class="logo-text font-weight-bold mr-2">Tracer Study</span>
            </a>
            <a class="navbar-brand brand-logo-mini" href="index.html">
                <img src="{{ asset('skydash/template/images/logotracer.png') }}" alt="logo">
            </a>
        </div>

        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>

            <ul class="navbar-nav mr-lg-2">
                <li class="nav-item nav-search d-none d-lg-block">
                    <div class="input-group">
                        <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                            <span class="input-group-text" id="search">
                                <i class="mdi mdi-magnify"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                            aria-label="search" aria-describedby="search" />
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                        data-toggle="dropdown">
                        <i class="mdi mdi-bell-ring-outline"></i>
                        <span class="count"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                        aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                        <a class="dropdown-item preview-item" href="#">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-success">
                                    <i class="ti-info-alt mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">Just now</p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item" href="#">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-warning">
                                    <i class="ti-settings mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">Settings</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">Private message</p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item" href="#">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-info">
                                    <i class="ti-user mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">2 days ago</p>
                            </div>
                        </a>
                    </div>
                </li>

                <!-- Admin Profile Section -->
                <li class="nav-item nav-profile dropdown">
                    <!-- Modified: Added direct link to profile when clicking the avatar/name -->
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown"
                        id="profileDropdown">
                        <div class="admin-profile-avatar mr-2">
                            @if (Auth::check() && Auth::user()->admin)
                                {{ strtoupper(substr(Auth::user()->admin->nama, 0, 2)) }}
                            @else
                                {{ strtoupper(substr(Auth::user()->username ?? 'AD', 0, 2)) }}
                            @endif
                        </div>
                        <div class="admin-profile-info d-none d-md-block">
                            <span class="admin-name">
                                @if (Auth::check() && Auth::user()->admin)
                                    {{ Auth::user()->admin->nama }}
                                @else
                                    {{ Auth::user()->username ?? 'Admin' }}
                                @endif
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <!-- Fixed: Corrected route name to match your routes -->
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="ti-settings text-primary"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
        </div>
    </nav>
</div>

<style>
    .admin-profile-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e80c1, #3a9bd1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        flex-shrink: 0;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .admin-profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(30, 128, 193, 0.3);
    }

    .admin-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #24272e;
        margin-bottom: 2px;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .admin-name:hover {
        color: #1e80c1;
    }

    .nav-link.dropdown-toggle {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    .nav-link.dropdown-toggle:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .dropdown-divider {
        margin: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        border-radius: 6px;
        margin: 0.25rem 0.5rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .dropdown-item i {
        margin-right: 0.5rem;
        width: 16px;
        text-align: center;
    }

    /* Enhanced dropdown styling */
    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        border-radius: 12px;
        padding: 0.5rem;
        min-width: 200px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .admin-profile-avatar {
            width: 35px;
            height: 35px;
            font-size: 0.75rem;
        }

        .admin-profile-info {
            display: none !important;
        }

        .dropdown-menu {
            min-width: 180px;
        }
    }

    /* Add smooth animation for dropdown */
    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Sembunyikan teks secara default untuk brand-logo-mini (jika tidak terlihat) */
    .navbar-brand-wrapper .brand-logo-mini+.logo-text {
        display: none;
        /* Pastikan teks tidak muncul jika menggunakan mini logo */
    }

    /* Default: teks terlihat saat sidebar terbuka penuh */
    .navbar-brand-wrapper .brand-logo .logo-text {
        display: inline-block;
        /* Pastikan teks terlihat */
        opacity: 1;
        visibility: visible;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        /* Transisi halus */
    }

    /* Ketika sidebar hanya menampilkan ikon (diciutkan) */
    .sidebar-icon-only .navbar-brand-wrapper .brand-logo .logo-text {
        display: none;
        /* Sembunyikan teks */
        opacity: 0;
        visibility: hidden;
    }

    /* Pastikan logo selalu terlihat */
    .navbar-brand-wrapper .brand-logo img {
        display: inline-block;
        transition: none;
    }

    .navbar .navbar-brand-wrapper .brand-logo-mini img {
        width: calc(70px - 30px);
        max-width: 100%;
        margin-left: 20px;
    }
</style>

<!-- Enhanced JavaScript for better interaction -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click handler for avatar/name to go directly to profile
        const profileLink = document.querySelector('#profileDropdown');
        const profileAvatar = document.querySelector('.admin-profile-avatar');
        const profileName = document.querySelector('.admin-name');

        // Add direct click to profile when clicking avatar or name (without dropdown)
        if (profileAvatar) {
            profileAvatar.addEventListener('click', function(e) {
                // If user holds Ctrl/Cmd, allow dropdown to show
                if (!e.ctrlKey && !e.metaKey) {
                    e.stopPropagation();
                    e.preventDefault();
                    window.location.href = "{{ route('admin.profile') }}";
                }
            });
        }

        if (profileName) {
            profileName.addEventListener('click', function(e) {
                // If user holds Ctrl/Cmd, allow dropdown to show
                if (!e.ctrlKey && !e.metaKey) {
                    e.stopPropagation();
                    e.preventDefault();
                    window.location.href = "{{ route('admin.profile') }}";
                }
            });
        }

        // Enhanced dropdown animation
        const dropdownToggle = document.querySelector('#profileDropdown');
        const dropdownMenu = document.querySelector('#profileDropdown + .dropdown-menu');

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', function(e) {
                setTimeout(() => {
                    if (dropdownMenu.classList.contains('show')) {
                        dropdownMenu.style.opacity = '1';
                        dropdownMenu.style.visibility = 'visible';
                        dropdownMenu.style.transform = 'translateY(0)';
                    }
                }, 10);
            });
        }
    });
</script>
