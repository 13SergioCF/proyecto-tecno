document.addEventListener('DOMContentLoaded', function () {
    const progressBar = document.getElementById('progress-bar');
    const icons = document.querySelectorAll('#loading-section i');
    const loadingTitle = document.getElementById('loading-title');
    const loadingSubtitle = document.getElementById('loading-subtitle');

    let progress = 0;
    const progressInterval = 800; // Tiempo en ms entre cada avance
    const step = 25; // Incremento en el progreso (debe coincidir con el número de íconos)

    const interval = setInterval(() => {
        progress = Math.min(progress + step, 100); // Aumenta el progreso hasta un máximo de 100
        progressBar.style.width = `${progress}%`;

        // Mostrar íconos progresivamente
        const iconIndex = progress / step - 1;
        if (icons[iconIndex]) {
            icons[iconIndex].classList.add('text-success');
        }
        console.log("hola");
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
});
