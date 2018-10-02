<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="success" content="{{ session('success') }}">
    <meta name="danger" content="{{ session('danger') }}">

    <title>@yield('title') - Nico's Burgers</title>
    <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}" />

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower/font-awesome/css/font-awesome.min.css') }}">
    <!-- Toastr style -->
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/admin-lte.min.css') }}">
    <!-- AdminLTE Skin -->
    <link rel="stylesheet" href="{{ asset('dist/css/skin-blue-light.min.css') }}">
    <!-- App Styles -->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('inicio') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><img src="{{ asset('dist/img/logo.png') }}" style="height: 20px;" alt="Nico's Burgers"></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><img src="{{ asset('dist/img/logo.png') }}" style="height: 40px;" alt="Nico's Burgers"></span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </nav>
        </header>

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li>
                        <a href="{{ route('inicio') }}">
                            <i class="fa fa-dashboard"></i> <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registros') }}">
                            <i class="fa fa-list-alt"></i> <span>Registros</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('insumos') }}">
                            <i class="fa fa-apple"></i> <span>Insumos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('productos') }}">
                            <i class="fa fa-cutlery"></i> <span>Productos</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content content-main">

                @yield('content')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer text-center">
            <strong>Copyright &copy; {{ date('Y') }} Nico's Burgers</strong>. All rights reserved.
        </footer>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('bower/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('bower/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- App -->
    <script src="{{ asset('dist/js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
