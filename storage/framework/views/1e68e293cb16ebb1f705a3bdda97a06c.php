<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Software | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed"> 
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/img/AdminLTELogo.png"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                

                <!-- Messages Dropdown Menu -->
                
                <!-- Notifications Dropdown Menu -->
                
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo e(route('dashboard')); ?>" class="brand-link">
                <img src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/img/AdminLTELogo.png" alt="ID Card Generator"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">ID Card Generator</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/img/user2-160x160.jpg"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo e(auth()->user()->name ?? null); ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-header">MODULES</li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('students.index')); ?>" class="nav-link <?php echo e(request()->routeIs('students.*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Students</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('registrations.index')); ?>" class="nav-link <?php echo e(request()->routeIs('registrations.*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-clipboard-check"></i>
                                <p>Registrations</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('print.index')); ?>" class="nav-link <?php echo e(request()->routeIs('print.*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-print"></i>
                                <p>Print ID Cards</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('templates.index')); ?>" class="nav-link <?php echo e(request()->routeIs('templates.*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-palette"></i>
                                <p>ID Templates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('campuses.index')); ?>" class="nav-link <?php echo e(request()->routeIs('campuses.*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Campuses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('classes.index')); ?>" class="nav-link <?php echo e(request()->routeIs('classes.*') ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-chalkboard"></i>
                                <p>Classes</p>
                            </a>
                        </li>
                        <li class="nav-header">ACCOUNT</li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('logout')); ?>" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php echo $__env->yieldContent('content'); ?>

        </div>
        <!-- /.content-wrapper -->
        

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/moment/moment.min.js"></script>
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <!-- Summernote -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/js/pages/dashboard.js"></script>

    <script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/toastr/toastr.min.js"></script>

    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(event) {
                event.preventDefault();

                // Create a new FormData object to handle the form, including file uploads
                const formData = new FormData(this);
                const url = $(this).attr('action');
                const method = 'POST'; // Always POST when using _method spoofing in Laravel
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: method, // This will still be POST for Laravel but include _method PUT
                    data: formData,
                    contentType: false, // Important for file uploads
                    processData: false, // Important for file uploads
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = 'Validation error:\n';
                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessage += `${key}: ${errors[key].join(', ')}\n`;
                                }
                            }
                            toastr.error(errorMessage);
                        } else {
                            console.error('Error updating student:', xhr.responseText);
                            toastr.error('Please try again.');
                        }
                    }
                });
            });
        });
    </script>





    <?php echo $__env->yieldContent('script'); ?>

</body>

</html>
<?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/layouts/app.blade.php ENDPATH**/ ?>