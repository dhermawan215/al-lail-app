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
                    <h3 class="m-0">Category Transaction</h3>
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
                            <button id="btn-add" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#modal-add-data">+ Add Data</button>
                            <button id="btn-delete" class="btn btn-sm btn-danger">Delete</button>
                        </div>
                        <div class="card-body">
                            <div class="ml-1">
                                <table class="table table-striped" id="table-category-transaction" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px;">#</th>
                                            <th style="width: 20px;">No</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        <!-- modal add data-->
        <div class="modal fade" id="modal-add-data" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal add category transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:;" method="post" id="form-add-category-transaction">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category-name">Category name</label>
                                <input type="text" name="category_name" class="form-control" id="category-name"
                                    placeholder="input category name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal edit data-->
        <div class="modal fade" id="modal-edit-data" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal edit category transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:;" method="post" id="form-update-category-transaction">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category-name">Category name</label>
                                <input type="text" name="category_name" class="form-control" id="category-name-edit"
                                    placeholder="input category name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    <script src="{{ asset('dist/admin/category-transaction.min.js?qwd=') . time() }}"></script>
@endpush
