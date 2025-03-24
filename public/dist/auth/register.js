var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    //save data
    var handleSubmit = function () {
        $("#register-form").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                url: `${url}/register-membership/process`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    toastr.success(responses.message);
                    setTimeout(() => {
                        window.location = responses.url;
                    }, 2000);
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
            handleSubmit();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
