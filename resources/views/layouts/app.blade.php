<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Al-lail App | {{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="al lail adalah aplikasi pencatatan laporan keuangan khusus masjid dan mushola, tersedia secara gratis">
    <!-- Google Font: Source Sans Pro -->
    @include('layouts.styles')
    @yield('app_styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('app_content')
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.footer')

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    @include('layouts.scripts')
    @stack('app_scripts')
</body>

</html>
