<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header') {{-- jika ada file head --}}

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- ================= Skydash CSS ================= -->
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('skydash/template/images/favicon.png') }}" />

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <!-- (tambahkan jika ada plugin tambahan di halaman ini) -->
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->

    <link rel="shortcut icon" href="{{ asset('skydash/template/images/favicon.png') }}">

    <!-- Custom CSS -->
    @stack('css')
</head>

<body>
    <div class="container-fluid page-body-wrapper">
        @include('layouts.sidebar') {{-- ini sidebar --}}

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
    @stack('js')
</body>

</html>
