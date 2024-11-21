$(function () {
    const form = $("#answer-form");
    const saveButton = $("#saveButton"); // ID del segundo botón
    const messageContainer = $("#messageContainer");
    const message = $("#message");

    const typeMessage = (text, speed = 50) => {
        return new Promise((resolve) => {
            let i = 0;
            const interval = setInterval(() => {
                if (i < text.length) {
                    message.text(message.text() + text[i]);
                    i++;
                } else {
                    clearInterval(interval);
                    resolve();
                }
            }, speed);
        });
    };

    saveButton.on("click", async function (e) {
        e.preventDefault();
        const data = form.serialize();

        // Cambiar botón a estado "guardando"
        saveButton.html("").addClass("saving");
        const spinner = $("<div>").addClass("spinner");
        saveButton.append(spinner);

        // Realizar solicitud AJAX
        $.ajax({
            url: `${base_url}answers`,
            headers: { "X-CSRF-TOKEN": _crf },
            type: "POST",
            data,
            success: async function (response) {
                // Botón en estado "guardado"
                saveButton.removeClass("saving").addClass("saved").html("");
                const checkmark = $("<div>").addClass("checkmark");
                saveButton.append(checkmark);

                // Mostrar mensaje con efecto de escritura
                messageContainer.addClass("show");
                message.text(""); // Vaciar texto previo
                const userMessage = "¡Tus respuestas han sido guardadas exitosamente! En breve serás redirigido...";
                await typeMessage(userMessage, 50);

                // Redirigir después de unos segundos
                setTimeout(() => {
                    window.location.href = `${base_url}questions`;
                }, 3000);
            },
            error: function (xhr, status, error) {
                // Manejar error
                saveButton.removeClass("saving saved").text("Guardar");
                messageContainer.addClass("show");
                message.text("Ocurrió un error al guardar tus respuestas. Por favor, intenta nuevamente.");
            }
        });
    });
});
