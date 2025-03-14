@extends('layouts.app')
@section('app_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- DataTables -->
@endsection
@section('app_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Profile</h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Profile</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Email</strong>

                            <p class="text-muted">
                                {{ Auth::user()->email }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Verified Account</strong>

                            <p class="text-muted">
                                {{ is_null(Auth::user()->email_verified_at) ? 'not verified' : 'verified' }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Registered At</strong>

                            <p class="text-muted">
                                {{ Auth::user()->created_at->diffForHumans() }}
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Status</strong>

                            <p class="text-muted">{{ Auth::user()->is_active == 1 ? 'active' : 'non active' }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header p-2">
                                    Configuration your email
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <form action="javascript:;" method="post" id="form-change-email">
                                        @csrf
                                        <label for="new-email">Email</label>
                                        <input type="email" name="new_email" placeholder="input your new email"
                                            id="new-email" class="form-control" value="{{ Auth::user()->email }}">
                                        <button type="submit" id="button-update-password"
                                            class="btn btn-primary mt-3">Change
                                            email</button>
                                    </form>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header p-2">
                                    Configuration your profile
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <form action="javascript:;" method="post" id="form-change-profile">
                                        @csrf
                                        <label for="name">Name</label>
                                        <input type="text" name="name" placeholder="input your name" id="phone"
                                            class="form-control" value="{{ Auth::user()->name }}">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" placeholder="input your phone" id="phone"
                                            class="form-control" value="{{ Auth::user()->phone }}">
                                        <button type="submit" id="button-update-password"
                                            class="btn btn-primary mt-3">Change
                                            email</button>
                                    </form>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header p-2">
                                    Configuration your password
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <form action="javascript:;" method="post" id="form-update-password">
                                        @csrf
                                        <label for="old-password">Old password</label>
                                        <input type="password" name="old_password" placeholder="input your old password"
                                            id="old-password" class="form-control">
                                        <label for="new-password">New password</label>
                                        <input type="password" name="new_password" placeholder="input your new password"
                                            id="new-password" class="form-control">
                                        <button type="submit" id="button-update-password"
                                            class="btn btn-primary mt-3">Change
                                            password</button>
                                    </form>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>

                <!-- /.col -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@push('app_scripts')
    <!-- toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- sweet alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dist/user/profile.min.js?qwd=') . time() }}"></script>
@endpush
