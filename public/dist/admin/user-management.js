var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;
    const nameOfModule = "user-management";

    var handleDataTable = function () {
        table = $("#table-" + nameOfModule).DataTable({
            responsive: true,
            // autoWidth: true,
            bAutoWidth: false,
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
                url: url + "/admin/users-management/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "name", orderable: false },
                { data: "email", orderable: false },
                { data: "role", orderable: false },
                { data: "verified", orderable: false },
                { data: "active", orderable: false },
                // { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                $(".data-menu-cbox").on("click", function () {
                    handleAddDeleteAselected(
                        $(this).val(),
                        $(this).parents()[1]
                    );
                });
            },
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

    var handleUserActive = function () {
        $(document).on("change", ".cbx-active", function () {
            if ($(this).is(":checked")) {
                const cbxVal = $(this).data("cbxs");
                const activeVal = "1";

                $.ajax({
                    type: "POST",
                    url: `${url}/admin/users-management/user-active`,
                    data: {
                        _token: csrf_token,
                        ivwx: cbxVal,
                        active: activeVal,
                    },
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
            } else {
                const cbxVal = $(this).data("cbxs");
                const activeVal = "0";
                $.ajax({
                    type: "POST",
                    url: `${url}/admin/users-management/user-active`,
                    data: {
                        _token: csrf_token,
                        ivwx: cbxVal,
                        active: activeVal,
                    },
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
            }
        });
    };

    return {
        init: function () {
            handleDataTable();
            handleUserActive();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
