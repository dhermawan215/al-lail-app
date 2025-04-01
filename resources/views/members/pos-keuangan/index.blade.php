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
                    <h3 class="m-0">Members > Pos Keuangan</h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Members</a></li>
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
                            <div class="col-lg-12 col-sm-12">
                                <button id="btn-refresh" class="btn btn-sm btn-success">Refresh</button>
                                <button id="btn-reload" class="btn btn-sm btn-info">Reload Page</button>
                                <button id="btn-add" data-toggle="modal" data-target="#modal-add-data"
                                    class="btn btn-sm btn-primary">Tambah Data</button>
                                <button id="btn-delete" class="btn btn-sm btn-danger">Hapus Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table-pos-keuangan">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">#</th>
                                        <th style="width: 15px">No</th>
                                        <th>Name</th>
                                        <th>Action</th>
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
    <!-- modal detail -->
    <div class="modal fade" id="modal-add-data" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal tambah pos keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" method="post" id="form-add-pos-keuangan">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label for="post-name">Nama Pos Keuangan</label>
                            <input type="text" placeholder="masukan nama pos keuangan anda" name="post_name"
                                id="post-name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- modal edit data -->
    <div class="modal fade" id="modal-edit-data" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal edit pos keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" method="post" id="form-edit-pos-keuangan">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label for="post-name">Nama Pos Keuangan</label>
                            <input type="text" placeholder="masukan nama pos keuangan anda" name="post_name"
                                id="post-name-edit" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
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

    <script src="{{ asset('dist/members/pos-keuangan.min.js?qwd=') . time() }}"></script>
@endpush
