@extends('layouts.app')
@section('app_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Welcome {{ $userName . ' | ' . $masjid }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Last login</h3>

                            <p>IP: {{ request()->ip() }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-toggle"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>System status</h3>

                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-radio-waves"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="text-white">{{ date('l', strtotime(date('d-m-Y'))) }}|{{ date('d-m-Y') }}</h3>

                            <p>Time: <span class="" id="time-clock-dashboard"></span></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clock"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Report Bug</h3>

                            <p>development@nusatech-indonesia.com</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-email"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-9 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Grafik Laporan Keuangan
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <canvas id="line-chart-report" height="100"></canvas>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-3 connectedSortable">

                    <!-- Map card -->
                    <div class="card">
                        <div class="card-header border-0 bg-primary">
                            <h3 class="card-title">
                                <i class="ion ion-folder mr-1"></i>
                                Apps Catalog (Our Product)
                            </h3>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <a href="https://ringkasurl.com" class="text-decoration-none text-white">
                                                <h5>RingkasUrl.com</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <a href="https://nd-keyboard-test.networkdelivr.my.id/"
                                                class="text-decoration-none text-white">
                                                <h5>Keyboard Tester</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body-->

                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('app_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var csrf_token = $('meta[name="csrf-token"]').attr("content");

        $(document).ready(function() {
            updateClock(); // tampilkan langsung saat load
            setInterval(updateClock, 1000); // update tiap 1 detik
            loadGraphic();
        });

        function updateClock() {
            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            const waktu = `${jam}:${menit}:${detik}`;
            $('#time-clock-dashboard').text(waktu);
        }

        function loadGraphic() {
            $.ajax({
                url: `${url}/report-chart`, // ganti dengan route API kamu
                method: 'POST',
                data: {
                    _token: csrf_token,
                },
                dataType: 'json',
                success: function(response) {
                    createLineChart(response);
                },
                error: function() {
                    alert('Gagal mengambil data chart');
                }
            });
        }

        function createLineChart(chartData) {
            const ctx = $('#line-chart-report');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                            label: 'Pemasukan',
                            data: chartData.pemasukan,
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 128, 0, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Pengeluaran',
                            data: chartData.pengeluaran,
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 0, 0, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Laporan Keuangan Harian'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endpush
