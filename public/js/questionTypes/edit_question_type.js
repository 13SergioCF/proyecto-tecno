$(function () {
    const form = $("#edit-question-type-form");
    form.on("submit", function (e) {
        e.preventDefault();
        const data = form.serialize();
        const id = $(e.currentTarget).data("id");
        $.ajax({
            url: `${base_url}question-types/${id}`,
            headers: { "X-CSRF-TOKEN": _crf },
            type: "PUT",
            data,
            async success(response) {
                await SwalHandler.success(response.message)
                window.location.href = `${base_url}question-types`;
            },
            error: _callBackAjaxError,

        });
    });
});
