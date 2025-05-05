var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    var table;
    const nameOfModule = "transaction";

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
                url: url + "/members/report-financial/list",
                type: "POST",
                data: function (d) {
                    d.category_transaction = $(
                        "#category-transaction-filter"
                    ).val();
                    d.financial_post = $("#financial-post-filter").val();
                    d.start_date_filter = $("#start-date-period").val();
                    d.end_date_filter = $("#end-date-period").val();
                    d._token = csrf_token;
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "category", orderable: false },
                { data: "financial", orderable: false },
                { data: "date", orderable: false },
                { data: "description", orderable: false },
                { data: "amout", orderable: false },
                { data: "created", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                let json = settings.json;

                if (json && json.summary) {
                    $("#pemasukan-keuangan").text(
                        formatRupiah(json.summary.income)
                    );
                    $("#pengeluaran-keuangan").text(
                        formatRupiah(json.summary.expense)
                    );
                }
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

        $("#btn-search-filter").on("click", function (e) {
            e.preventDefault();
            table.ajax.reload(); // Reload datatable dengan filter baru
        });
        $("#btn-search-period").on("click", function (e) {
            e.preventDefault();
            table.ajax.reload(); // Reload datatable dengan filter baru
        });
    };

    function formatRupiah(angka) {
        if (!angka) return "Rp 0";
        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    //handle select option for category
    var handleCategory = function () {
        $("#kategori").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "pilih kategori keuangan",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/members/report-financial/income-outcome",

                data: function (params) {
                    return {
                        _token: csrf_token,
                        search: params.term,
                        page: params.page || 1, // search term
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: true,
                        },
                    };
                },
            },
            templateResult: format,
            templateSelection: formatSelection,
        });
    };
    //handle select option for financial post
    var handleFinancial = function () {
        $("#fin-post").select2({
            // minimumInputLength: 1,
            allowClear: true,
            placeholder: "pilih kategori keuangan",
            dataType: "json",
            ajax: {
                method: "POST",

                url: url + "/members/report-financial/financial-post",

                data: function (params) {
                    return {
                        _token: csrf_token,
                        search: params.term,
                        page: params.page || 1, // search term
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: true,
                        },
                    };
                },
            },
            templateResult: format,
            templateSelection: formatSelection,
        });
    };
    //select 2 main function
    function format(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatSelection(repo) {
        return repo.text;
    }

    //save data
    var handleSubmit = function () {
        $("#form-add-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                url: `${url}/members/report-financial/save`,
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
    //handle edit data
    var handleEdit = function () {
        $(document).on("click", ".btn-edit", function () {
            const dataBtn = $(this).data("edit");
            $.ajax({
                type: "POST",
                url: `${url}/members/report-financial/edit`,
                data: {
                    _token: csrf_token,
                    vx: dataBtn,
                },
                dataType: "json",
                success: function (response) {
                    const dataResponse = response.data;
                    $("#description-edit").val(dataResponse.description);
                    $("#jumlah-edit").val(dataResponse.amount);
                    $("#transaction-date-edit").val(
                        dataResponse.transaction_date
                    );
                    handleUpdate(dataResponse.xc);
                },
                error: function (response) {
                    toastr.error("error, when get the data");
                },
            });
        });
    };
    var handleUpdate = function (xv) {
        $("#form-edit-" + nameOfModule).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("data_xv", xv);

            $.ajax({
                url: `${url}/members/report-financial/update`,
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

    return {
        init: function () {
            handleDataTable();
            handleCategory();
            handleFinancial();
            handleSubmit();
            handleEdit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
