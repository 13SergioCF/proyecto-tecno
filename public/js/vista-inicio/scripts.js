function iniciarSesion() {
    window.location.href = "/login"; // Cambia esta ruta según la configuración de tu sistema en Laravel
}

function registrarse() {
    window.location.href = "/register"; // Cambia esta ruta según la configuración de tu sistema en Laravel
}

function explorarServicios() {
    document.querySelector(".services").scrollIntoView({ behavior: "smooth" });
}


function explorarServicios() {
    document.querySelector("#services").scrollIntoView({ behavior: "smooth" });
}

function explorarServicios() {
    document.querySelector("#services").scrollIntoView({ behavior: "smooth" });
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});


document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetElement = document.querySelector(this.getAttribute('href'));

        window.scrollTo({
            top: targetElement.offsetTop - 80, // Ajusta el valor para dar espacio al encabezado fijo
            behavior: 'smooth'
        });
    });
});

