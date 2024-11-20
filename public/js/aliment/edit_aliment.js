$(function () {
    const form = $("#edit-aliment-form");

    form.on("submit", function (e) {
        e.preventDefault();

        const data = form.serialize();
        const id = form.attr("action").split("/").pop();

        $.ajax({
            url: `/aliments/${id}`,
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            type: "PUT",
            data: data,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "Alimento actualizado correctamente.",
                }).then(() => {
                    window.location.href = "/aliments";
                });
            },
            error: function (jqXHR) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error al actualizar el alimento.",
                });
            },
        });
    });
});
