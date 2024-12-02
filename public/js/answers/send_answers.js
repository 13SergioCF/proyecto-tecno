$(function () {
    const form = $("#answer-form");
    const saveButton = $("#saveButton");
    const messageContainer = $("#messageContainer");
    const message = $("#message");
    const planGenerate = $("#planGenerate"); // Botón "Generar Plan"

    const typeMessage = (text, speed = 50) => {
        return new Promise((resolve) => {
            let i = 0;
            const interval = setInterval(() => {
                if (i < text.length) {
                    message.text(message.text() + text[i]);
                    i++;
                    // Desplaza el scrollbar hacia el final del contenedor
                    messageContainer.scrollTop(messageContainer[0].scrollHeight);
                } else {
                    clearInterval(interval);
                    resolve();
                }
            }, speed);
        });
    };

    const moveToNextStep = () => {
        const activePanel = $(".multisteps-form__panel.js-active");
        const activeProgressBtn = $(".multisteps-form__progress-btn.js-active");
        const nextPanel = activePanel.next(".multisteps-form__panel");
        const nextProgressBtn = activeProgressBtn.next(".multisteps-form__progress-btn");

        if (nextPanel.length) {
            activePanel.removeClass("js-active");
            nextPanel.addClass("js-active");
        }

        if (nextProgressBtn.length) {
            activeProgressBtn.removeClass("js-active");
            nextProgressBtn.addClass("js-active");
        }
    };

    saveButton.on("click", async function (e) {
        e.preventDefault();
        const data = form.serialize();

        saveButton.html("").addClass("saving").append($("<div>").addClass("spinner"));

        $.ajax({
            url: `${base_url}answers`,
            headers: { "X-CSRF-TOKEN": _crf },
            type: "POST",
            data,
            success: async function () {
                saveButton.removeClass("saving").addClass("saved").html("").append($("<div>").addClass("checkmark"));
                moveToNextStep();

                messageContainer.addClass("show");
                message.text("");
                await typeMessage("¡Respuestas guardadas! Generando tus recomendaciones...", 50);

                $.ajax({
                    url: `${base_url}recomendations/generate`,
                    type: "POST",
                    headers: { "X-CSRF-TOKEN": _crf },
                    success: async function (recommendationResponse) {
                        message.text("");
                        await typeMessage(recommendationResponse.recommendations, 10);

                        // Mostrar el botón "Generar Plan" después de las recomendaciones
                        planGenerate.fadeIn(500);
                    },
                    error: function () {
                        message.text("Ocurrió un error al generar las recomendaciones. Por favor, intenta nuevamente.");
                    }
                });
            },
            error: function () {
                saveButton.removeClass("saving saved").text("Guardar");
                messageContainer.addClass("show");
                message.text("Ocurrió un error al guardar tus respuestas. Por favor, intenta nuevamente.");
            }
        });
    });
});