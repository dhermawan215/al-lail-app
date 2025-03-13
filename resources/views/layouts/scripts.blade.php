<script src="{{ asset('temp/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('temp/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('temp/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('temp/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('temp/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('temp/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('temp/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('temp/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('temp/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('temp/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('temp/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('temp/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('temp/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('temp/dist/js/adminlte.js') }}"></script>

<script>
    var url = "{{ url('') }}";

    $(document).ready(function() {
        $("#form-logout").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(form[0]);

            if (confirm("Are you sure to logout?")) {
                $.ajax({
                    url: url + "/logout",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(responses) {
                        toastr.success("success!");
                        setTimeout(() => {
                            window.location = responses.url;
                        }, 2500);
                    },
                    error: function(response) {},
                });
            }
        });
    });
</script>