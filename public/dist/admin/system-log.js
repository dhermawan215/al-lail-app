var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;
    const nameOfModule = "system-log";

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
                url: url + "/admin/system-log/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "email", orderable: false },
                { data: "ip", orderable: false },
                { data: "agent", orderable: false },
                { data: "message", orderable: false },
                { data: "status", orderable: false },
                { data: "info", orderable: false },
                { data: "date", orderable: false },
            ],
            drawCallback: function (settings) {},
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
    return {
        init: function () {
            handleDataTable();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
