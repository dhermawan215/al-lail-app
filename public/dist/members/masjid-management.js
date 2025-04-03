var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;
    var aSelected = [];
    const nameOfModule = "masjid-management";

    var handleDataTable = function () {
        table = $("#table-" + nameOfModule).DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 15,
            // dom: "Bftip",
            // buttons: ["pageLength", "csv", "excel", "pdf", "print"],
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
                url: url + "/members/masjid-management/list",
                type: "POST",
                data: {
                    _token: csrf_token,
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "code", orderable: false },
                { data: "name", orderable: false },
                { data: "phone", orderable: false },
                { data: "verified", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                const masjidRegistered = settings.json.masjidRegistered;
                if (masjidRegistered === "1") {
                    $("#btn-add").attr("disabled", "");
                } else {
                    $("#btn-add").removeAttr("disabled");
                }
                $(".data-menu-cbox").on("click", function () {
                    handleAddDeleteAselected(
                        $(this).val(),
                        $(this).parents()[1]
                    );
                });
                $("#btn-delete").attr("disabled", "");
                aSelected.splice(0, aSelected.length);
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
    //push data to variable aSelected
    var handleAddDeleteAselected = function (value, parentElement) {
        var check_value = $.inArray(value, aSelected);
        if (check_value !== -1) {
            $(parentElement).removeClass("table-success");
            aSelected.splice(check_value, 1);
        } else {
            $(parentElement).addClass("table-success");
            aSelected.push(value);
        }

        handleBtnDisableEnable();
    };
    //control button disabled enable
    var handleBtnDisableEnable = function () {
        if (aSelected.length > 0) {
            $("#btn-delete").removeAttr("disabled");
        } else {
            $("#btn-delete").attr("disabled", "");
        }
    };

    var handleDetail = function () {
        $(document).on("click", ".btn-detail", function () {
            const d = $(this).data("d");
            $.ajax({
                type: "POST",
                url: url + "/members/masjid-management/detail",
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
    //save data
    var handleSubmit = function () {
        $("#form-add-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                url: `${url}/members/masjid-management/save`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    //edit data

    var handleEdit = function () {
        $(document).on("click", ".btn-edit", function () {
            const d = $(this).data("e");
            $.ajax({
                type: "POST",
                url: url + "/members/masjid-management/edit",
                data: {
                    _token: csrf_token,
                    x_edit: d,
                },
                dataType: "json",
                success: function (response) {
                    const responseData = response.data;
                    $("#masjid-name-edit").val(responseData.name);
                    $("#phone-edit").val(responseData.phone);
                    $("#address-edit").val(responseData.address);
                    $("#masjid-image-edit").attr("src", responseData.image);
                    handleUpdate(responseData.x);
                },
            });
        });
    };
    //update data
    var handleUpdate = function (xv) {
        $("#form-edit-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("dvalue", xv);

            $.ajax({
                url: `${url}/members/masjid-management/update`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    //delete data
    var handleDelete = function () {
        $("#btn-delete").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url + "/members/masjid-management/delete",
                        data: {
                            _token: csrf_token,
                            x_data: aSelected,
                        },
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                );
                                setTimeout(() => {
                                    table.ajax.reload();
                                }, 1500);
                            }
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Internal Server Error",
                            });
                        },
                    });
                }
            });
        });
    };
    return {
        init: function () {
            handleDataTable();
            handleDetail();
            handleDelete();
            handleEdit();
            handleSubmit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
