// script.js

document.addEventListener('DOMContentLoaded', function () {
    const welcomeContainer = document.getElementById('welcome-container');
    const startButton = document.getElementById('start-button');

    // Muestra el contenedor de bienvenida después de un breve retraso
    setTimeout(() => {
        welcomeContainer.classList.add('show');
    }, 500); // 500 ms de retraso para la animación

    // Redirige al usuario a la ruta "preguntas" cuando hace clic en "Iniciar"
    startButton.addEventListener('click', () => {
        // Añade una animación de salida (opcional)
        welcomeContainer.style.opacity = '0';
        welcomeContainer.style.transform = 'translateY(-50px)';

        // Espera a que termine la animación antes de redirigir
        setTimeout(() => {
            window.location.href = '/preguntas'; // Redirige a la ruta "preguntas"
        }, 600);
    });
});
