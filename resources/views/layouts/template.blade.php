<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header') {{-- jika ada file head --}}

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-H6DkIsQz3uM6CZSkKd7Tqz+6cKx5PiEvXnYDbZk9xBv5Oebzp9tWwz7P/5L3Za2E" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <!-- ================= Skydash CSS ================= -->
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('skydash/template/images/favicon.png') }}" />

    <!-- plugins:css -->


    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <!-- (tambahkan jika ada plugin tambahan di halaman ini) -->
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->

    <link rel="shortcut icon" href="{{ asset('skydash/template/images/favicon.png') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>


    <!-- Custom CSS -->
    @stack('css')
</head>

<body>

    <div class="container-fluid page-body-wrapper">
        {{-- 
@if (Auth::user()->role == 'admin')
    @include('layouts.sidebar')
@elseif(Auth::user()->role == 'alumni')
    @include('layouts.sidebarAlumni')
@endif
--}}

@if (Auth::check())
    @if (Auth::user()->role == 'admin')
        @include('layouts.sidebar')
    @elseif (Auth::user()->role == 'alumni')
        @include('layouts.sidebarAlumni')
    @endif
@endif

        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content') {{-- konten utama tampil di sini --}}

            </div>
        </div>
    </div>


    @include('layouts.footer') {{-- jika ada footer --}}

    <!-- ================= Skydash JS ================= -->
    <script src="{{ asset('skydash/template/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/template/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('skydash/template/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('skydash/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('skydash/template/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('skydash/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/template/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('skydash/template/js/template.js') }}"></script>
    <script src="{{ asset('skydash/template/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/template/js/todolist.js') }}"></script>
    <script src="{{ asset('skydash/template/js/dashboard.js') }}"></script>
    <script src="{{ asset('skydash/template/js/Chart.roundedBarCharts.js') }}"></script>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->


    <!-- CSRF AJAX Setup -->


    <!-- Custom Script -->

    <!-- bisa dihapus, cuma coba -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4.6 Bundle (termasuk Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FontAwesome (untuk ikon seperti spinner, dll) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>

    @stack('js')
</body>

</html>
