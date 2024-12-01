$(function () {
    const form = $("#answer-form");
    const saveButton = $("#saveButton");
    const messageContainer = $("#messageContainer");
    const message = $("#message");
    const loading = $("#loading");
    const progressBar = document.getElementById('progress-bar');
    const icons = document.querySelectorAll('#loading-section i');
    const loadingTitle = document.getElementById('loading-title');
    const loadingSubtitle = document.getElementById('loading-subtitle');

    let progress = 0;
    const progressInterval = 800; // Tiempo en ms entre cada avance
    const step = 25;


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
                        await typeMessage(recommendationResponse.recommendations, 50);
                        messageContainer.fadeOut(500, function () {
                            setTimeout(() => {
                                loading.fadeIn(500); // Aparece el loading con animación
                                const interval = setInterval(() => {
                                    progress = Math.min(progress + step, 100); // Aumenta el progreso hasta un máximo de 100
                                    progressBar.style.width = `${progress}%`;

                                    // Mostrar íconos progresivamente
                                    const iconIndex = progress / step - 1;
                                    if (icons[iconIndex]) {
                                        icons[iconIndex].classList.add('text-success');
                                    }
                                    // Si el progreso llega al 100%, actualizar el título y redirigir a la ruta
                                    if (progress === 100) {
                                        clearInterval(interval);
                                        loadingTitle.textContent = 'Proceso Completo';
                                        loadingSubtitle.textContent = '¡Todo listo!';

                                        // Redirigir a la ruta plan-nutritional
                                        setTimeout(() => {
                                            window.location.href = '/plan-nutricional'; // Cambia la URL a la ruta deseada
                                        }, 800); // Pequeño retraso antes de redirigir
                                    }
                                }, progressInterval);
                            }, 1000);
                        });
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
