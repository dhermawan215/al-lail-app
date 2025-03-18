@extends('layouts.app')
@section('app_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('temp/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('temp/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('app_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Financial Post Management</h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button id="btn-refresh" class="btn btn-sm btn-success">Refresh</button>
                            <button id="btn-reload" class="btn btn-sm btn-info">Reload Page</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table-financial-post">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th>Masjid</th>
                                        <th>Post name</th>
                                        <th>Creator</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@push('app_scripts')
    <!-- toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- sweet alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('temp/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('temp/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('dist/admin/financial-post.min.js?qwd=') . time() }}"></script>
@endpush
