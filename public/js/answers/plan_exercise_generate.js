$(function () {
    const planGenerate = $("#planGenerate"); // Botón "Generar Plan"
    const loading = $("#loading");
    const progressBar = document.getElementById("progress-bar");
    const icons = document.querySelectorAll("#loading-section i");
    const loadingTitle = document.getElementById("loading-title");
    const loadingSubtitle = document.getElementById("loading-subtitle");
    const messageContainer = $("#messageContainer");
    const message = $("#message");

    let progress = 0;
    const progressInterval = 800; // Tiempo en ms entre cada avance
    const step = 25;

    planGenerate.on("click", function (event) {
        // Evitar la acción predeterminada del botón
        event.preventDefault();

        // Ocultar el mensaje y mostrar el loading
        messageContainer.hide();
        planGenerate.hide(); // Oculta el botón después de hacer clic
        loading.fadeIn(500); // Mostrar la vista de carga

        // Asegurar que la vista de carga se muestre antes de iniciar la solicitud AJAX
        setTimeout(() => {
            // Reiniciar barra de progreso
            progress = 0;
            progressBar.style.width = `${progress}%`;

            // Realizar solicitud AJAX
            $.ajax({
                url: `${base_url}plan/generate`,
                type: "POST",
                headers: { "X-CSRF-TOKEN": _crf },
                success: function (response) {
                    // Simular animación de progreso
                    const interval = setInterval(() => {
                        progress = Math.min(progress + step, 100); // Incrementa el progreso
                        progressBar.style.width = `${progress}%`;

                        // Mostrar íconos progresivamente
                        const iconIndex = progress / step - 1;
                        if (icons[iconIndex]) {
                            icons[iconIndex].classList.add("text-success");
                        }

                        // Detener la animación y mostrar mensaje de éxito
                        if (progress === 100) {
                            clearInterval(interval);
                            loadingTitle.textContent = "¡Plan Generado!";
                            loadingSubtitle.textContent = "Tu plan de ejercicios está listo.";
                            messageContainer.fadeIn(500);
                            message.text("El plan de ejercicios ha sido generado exitosamente.");

                            setTimeout(() => {
                                loading.fadeOut(500);
                                planGenerate.fadeIn(500); // Mostrar el botón de nuevo si es necesario
                            }, 1000);
                        }
                    }, progressInterval);
                },
                error: function (xhr, status, error) {
                    loading.fadeOut(500);
                    planGenerate.fadeIn(500); // Reaparecer el botón para intentar nuevamente
                    messageContainer.fadeIn(500);
                    message.text("Ocurrió un error al generar el plan de ejercicios. Por favor, intenta nuevamente.");
                }
            });
        }, 500); // Retraso para asegurar que el `loading` se renderice
    });
});
