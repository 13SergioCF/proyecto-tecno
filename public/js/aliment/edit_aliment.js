$(function () {
    const form = $("#edit-aliment-form");

    form.on("submit", function (e) {
        e.preventDefault();

        const data = new FormData(form[0]); // Capturar datos del formulario con archivos
        const id = form.attr("action").split("/").pop(); // Obtener ID del alimento

        $.ajax({
            url: `/aliments/${id}`, // Ruta para actualizar
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            type: "POST", // Laravel interpretará como PUT si usas @method en el formulario
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: response.message,
                    }).then(() => {
                        window.location.href = "/aliments"; // Redirigir al índice
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                }
            },
            error: function (jqXHR) {
                console.error(jqXHR.responseText); // Depurar error en consola
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: `Ocurrió un error: ${jqXHR.responseText}`,
                });
            },
        });
    });
});
