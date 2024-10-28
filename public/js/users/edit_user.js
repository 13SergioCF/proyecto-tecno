$(function () {
    const form = $("#edit-user-form");
    form.on("submit", function (e) {
        e.preventDefault();
        const data = form.serialize();
        const id = $(e.currentTarget).data("id");
        $.ajax({
            url: `${base_url}users/${id}`,
            headers: { "X-CSRF-TOKEN": _crf },
            type: "PUT",
            data,
            async success(response) {
                await SwalHandler.success(response.message)
                window.location.href = `${base_url}users`;
            },
            error: _callBackAjaxError,

        });
    });
});
