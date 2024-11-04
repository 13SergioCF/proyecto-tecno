function showAlert(type, message) {
    Swal.fire({
        icon: type,
        title: type === 'success' ? '¡Éxito!' : 'Error',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}
$(function () {
    const form = $("#question-form");
    form.on("submit", function (e) {
        e.preventDefault();
        const data = form.serialize();

        $.ajax({
            url: `${base_url}questions`,
            headers: { "X-CSRF-TOKEN": _crf },
            type: "POST",
            data,
            async success(response) {
                await SwalHandler.success(response.message)
                window.location.href = `${base_url}questions`;
            },
            error: _callBackAjaxError,

        });
    });
});
