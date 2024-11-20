// Número de bolas
const numBalls = 10;
const balls = [];

// Crear las bolas y agregarlas al body
for (let i = 0; i < numBalls; i++) {
    const ball = document.createElement("div");
    ball.classList.add("ball");

    // Posición inicial aleatoria
    ball.style.left = `${Math.random() * window.innerWidth}px`;
    ball.style.top = `${Math.random() * window.innerHeight}px`;

    // Velocidad aleatoria
    ball.dx = (Math.random() - 0.5) * 4;
    ball.dy = (Math.random() - 0.5) * 4;

    balls.push(ball);
    document.body.appendChild(ball);
}

// Función para actualizar la posición de las bolas
function update() {
    balls.forEach(ball => {
        let x = parseFloat(ball.style.left);
        let y = parseFloat(ball.style.top);

        // Actualizar posición
        x += ball.dx;
        y += ball.dy;

        // Verificar colisión con los bordes
        if (x <= 0 || x >= window.innerWidth - 30) ball.dx *= -1;
        if (y <= 0 || y >= window.innerHeight - 30) ball.dy *= -1;

        ball.style.left = `${x}px`;
        ball.style.top = `${y}px`;
    });

    requestAnimationFrame(update);
}

// Iniciar animación
update();


document.addEventListener("DOMContentLoaded", function () {
    const text = "Preguntas del Paso 1";
    const speed = 100; // Velocidad de escritura (en milisegundos)
    let index = 0;

    function typeEffect() {
        if (index < text.length) {
            document.getElementById("typing-effect").textContent += text.charAt(index);
            index++;
            setTimeout(typeEffect, speed);
        }
    }

    document.getElementById("typing-effect").textContent = ""; // Limpia el contenido antes de escribir
    typeEffect();
});
