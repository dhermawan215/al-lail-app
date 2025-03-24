<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Al-lail App | Register success</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('temp/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-header text-center ">
                <h2 class="h1">Al-Lail App</h2>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Registrasi berhasil, Silahkan cek email untuk aktivasi akun, dan login jika
                    sudah berhasil</p>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login</a>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('temp/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('temp/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('temp/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        var url = "{{ url('') }}";
    </script>
    <script src="{{ asset('dist/auth/register.min.js?awx=') . time() }}"></script>
</body>

</html>
