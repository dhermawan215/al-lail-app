@extends('layouts.app')
@section('app_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('temp/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('temp/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('temp/plugins/select2/css/select2.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
            height: auto !important;
        }
    </style>
@endsection
@section('app_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Members > Manajemen Kas Keuangan</h3>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            Data Kas Masjid: {{ $masjid }}
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="gap-3">
                                <div class="form-group mr-2">
                                    <label for="start-date">
                                        Tanggal Awal
                                    </label>
                                    <input type="date" name="start_date" id="start-date-period" class="form-control">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="end-date">
                                        Tanggal Akhir
                                    </label>
                                    <input type="date" name="start_date" id="end-date-period" class="form-control">
                                </div>
                                <div class="form-group">

                                    <button class="btn btn-success form-control" id="btn-search-period" type="button">Cari
                                        Laporan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="gap-3">
                                <div class="form-group mr-2">
                                    <label for="start-date">
                                        Tanggal Awal
                                    </label>
                                    <input type="date" name="start_date" id="start-date-export" class="form-control">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="end-date">
                                        Tanggal Akhir
                                    </label>
                                    <input type="date" name="start_date" id="end-date-export" class="form-control">
                                </div>
                                <div class="form-group">

                                    <button class="btn btn-primary" id="excel-export" type="button">Cetak Laporan
                                        Excel</button>
                                    <button class="btn btn-danger" id="pdf-export" type="button">Cetak Laporan Pdf</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            Filter berdasarkan category keuangan
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select name="category_transaction" id="category-transaction-filter" class="form-control">
                                    <option value="" selected>-Pilih kategori keuangan-</option>
                                    @foreach ($category as $cv)
                                        <option value="{{ $cv->id }}">{{ $cv->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pos Keuangan</label>
                                <select name="financial_post" id="financial-post-filter" class="form-control">
                                    <option value="" selected>-Pilih pos keuangan-</option>
                                    @foreach ($financial as $fv)
                                        <option value="{{ $fv->id }}">{{ $fv->post_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" id="btn-search-filter">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            Jumlah
                        </div>
                        <div class="card-body">
                            <h3>Pemasukan: <span class="text-primary"id="pemasukan-keuangan"></span></h3>
                            <hr>
                            <h3>Pengeluaran: <span class="text-primary"id="pengeluaran-keuangan"></span></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-lg-12 col-sm-12">
                                <button id="btn-refresh" class="btn btn-sm btn-success">Refresh</button>
                                <button id="btn-reload" class="btn btn-sm btn-info">Reload Page</button>
                                <button id="btn-add" data-toggle="modal" data-target="#modal-add-data"
                                    class="btn btn-sm btn-primary">Tambah Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table-transaction">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">No</th>
                                        <th>Kategori</th>
                                        <th>Pos Keuangan</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Dibuat</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal tambah laporan keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" method="post" id="form-add-transaction">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label for="kategori">Kategori Keuangan</label>
                            <select name="category" id="kategori" class="form-control"></select>
                        </div>
                        <div class="row">
                            <label for="fin-post">Pos Keuangan</label>
                            <select name="finacial" id="fin-post" class="form-control"></select>
                        </div>
                        <div class="row">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <label for="jumlah">Jumlah/Amount</label>
                            <input type="number" placeholder="masukan jumlah uang" name="amount" id="jumlah"
                                class="form-control">
                        </div>
                        <div class="row">
                            <label for="transaction-date">Tanggal Transaksi</label>
                            <input type="date" placeholder="tanggal transaksi" name="transaction_date"
                                id="transaction-date" class="form-control">
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
    <!-- modal edit -->
    <div class="modal fade" id="modal-edit-data" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal edit laporan keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:;" method="post" id="form-edit-transaction">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description-edit" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <label for="jumlah">Jumlah/Amount</label>
                            <input type="number" placeholder="masukan jumlah uang" name="amount" id="jumlah-edit"
                                class="form-control">
                        </div>
                        <div class="row">
                            <label for="transaction-date">Tanggal Transaksi</label>
                            <input type="date" placeholder="tanggal transaksi" name="transaction_date"
                                id="transaction-date-edit" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Update</button>
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
    <script src="{{ asset('temp/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dist/members/report.min.js?qwd=') . time() }}"></script>
@endpush
