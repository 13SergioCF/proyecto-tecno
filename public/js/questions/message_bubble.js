document.addEventListener("DOMContentLoaded", function () {
    const messageElement = document.getElementById("message-bubble");
    const messageText = "¡Bienvenido al sistema de nutrición! Estoy aquí para ayudarte a alcanzar tus objetivos de salud. Haz clic en 'Iniciar' para comenzar.";
    let index = 0;

    function typeWriter() {
        if (index < messageText.length) {
            messageElement.innerHTML += messageText.charAt(index);
            index++;
            setTimeout(typeWriter, 40);
        }
    }

    typeWriter();

    // Funcionalidad para el botón de inicio
    document.getElementById("start-button").addEventListener("click", function () {
        // Muestra el contenedor de carga
        document.getElementById("loading-screen").style.display = "flex";

        // Espera 3 segundos y redirige a la siguiente vista
        setTimeout(function () {
            document.getElementById("loading-screen").style.display = "none";
            window.location.href = "/preguntas"; // Cambia esta ruta a la vista que deseas cargar
        }, 5000);
    });
});
