<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- ================= Skydash CSS ================= -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/feather/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/ti-icons/css/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/css/vendor.bundle.base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/js/select.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/css/vertical-layout-light/style.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('skydash/template/images/favicon.png')); ?>" />

    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/feather/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/ti-icons/css/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/css/vendor.bundle.base.css')); ?>">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <!-- (tambahkan jika ada plugin tambahan di halaman ini) -->
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/css/vertical-layout-light/style.css')); ?>">
    <!-- endinject -->

    <link rel="shortcut icon" href="<?php echo e(asset('skydash/template/images/favicon.png')); ?>">

    <!-- Custom CSS -->
    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body>
    <div class="container-fluid page-body-wrapper">
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

        <div class="main-panel">
            <div class="content-wrapper">
                <?php echo $__env->yieldContent('content'); ?> 

            </div>
        </div>
    </div>


    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

    <!-- ================= Skydash JS ================= -->
    <script src="<?php echo e(asset('skydash/template/vendors/js/vendor.bundle.base.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/vendors/chart.js/Chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/vendors/datatables.net-bs4/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/dataTables.select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/off-canvas.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/hoverable-collapse.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/template.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/settings.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/todolist.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/dashboard.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/template/js/Chart.roundedBarCharts.js')); ?>"></script>

    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/feather/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/ti-icons/css/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/template/vendors/css/vendor.bundle.base.css')); ?>">
    <!-- endinject -->


    <!-- CSRF AJAX Setup -->


    <!-- Custom Script -->
    <?php echo $__env->yieldPushContent('js'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\PBL_TracerStudy05\resources\views/layouts/template.blade.php ENDPATH**/ ?>