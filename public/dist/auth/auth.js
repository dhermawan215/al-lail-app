var Index = (function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    //save data
    var handleSubmit = function () {
        $("#login-form").submit(function (e) {
            e.preventDefault();
            const form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                url: `${url}/login/process`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (responses) {
                    setTimeout(() => {
                        window.location = responses.url;
                    }, 2000);
                },
                error: function (response) {
                    toastr.error("error, please check email and password");
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
