var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;
    const nameOfModule = "masjid";

    var handleDataTable = function () {
        table = $("#table-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 15,
            dom: "Bftip",
            buttons: ["pageLength", "csv", "excel", "pdf", "print"],
            searching: true,
            paging: true,
            lengthMenu: [
                [15, 25, 50],
                [15, 25, 50],
            ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            columnsDefs: [
                { searchable: false, target: [0, 1] },
                { orderable: false, target: 0 },
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + "/admin/masjid-management/list",
                type: "POST",
                data: function (d) {
                    d._token = csrf_token;
                    d.filter_verification = $("#filter-verification").val();
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "code", orderable: false },
                { data: "name", orderable: false },
                { data: "phone", orderable: false },
                { data: "verified", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {},
        });
        $("#filter-verification").change(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        // btn refresh on click
        $("#btn-refresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
        // btn refresh on click
        $("#btn-reload").click(function (e) {
            e.preventDefault();
            window.location.reload();
        });
    };

    var handleVerifiying = function () {
        $(document).on("click", ".btn-verification", function () {
            const dataV = $(this).data("v");
            $.ajax({
                type: "POST",
                url: url + "/admin/masjid-management/verifiying",
                data: {
                    _token: csrf_token,
                    xvalue: dataV,
                },
                dataType: "json",
                success: function (response) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        table.ajax.reload();
                    }, 1500);
                },
                error: function (response) {
                    toastr.error(response.message);
                },
            });
        });
    };

    var handleDetail = function () {
        $(document).on("click", ".btn-detail", function () {
            const d = $(this).data("d");
            $.ajax({
                type: "POST",
                url: url + "/admin/masjid-management/detail",
                data: {
                    _token: csrf_token,
                    dValue: d,
                },
                dataType: "json",
                success: function (response) {
                    const responseData = response.data;
                    $("#masjid-url").val(responseData.masjid_url);
                    $("#masjid-code").val(responseData.masjid_code);
                    $("#verification").val(responseData.verification);
                    $("#user").val(responseData.user);
                    $("#masjid-name").val(responseData.masjid_name);
                    $("#phone").val(responseData.phone);
                    $("#registered").val(responseData.registered);
                    $("#user-email").val(responseData.email);
                    $("#address").val(responseData.address);
                    $("#masjid-image").attr("src", responseData.image);
                },
            });
        });
    };
    return {
        init: function () {
            handleDataTable();
            handleVerifiying();
            handleDetail();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
