<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrición Saludable</title>
    <link rel="stylesheet" href="{{ asset('css/vista-inicio/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Encabezado -->
    <header>
        <div class="logo">Dieta Start</div>
        <nav class="nav-buttons">
            <a href="#inicio" class="btn">Inicio</a>
            <a href="#quienes-somos" class="btn">Quiénes Somos</a>
            <a href="#services" class="btn">Servicios</a>
            <a href="#contactos" class="btn">Contactos</a>
            <a href="{{ route('login') }}" class="btn btn-login">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn btn-register">Registrarse</a>
        </nav>
    </header>

<!-- Sección de bienvenida -->
    <section class="hero" id="inicio">
        <video autoplay muted loop class="background-video">
            <source src="{{ asset('videos/videos.mp4') }}" type="video/mp4">
            Tu navegador no soporta videos HTML5.
        </video>
        <div class="hero-content">
            <h1>Bienvenido a Dieta Start</h1>
            <p>Transforma tu vida con una alimentación saludable y ejercicios personalizada.</p>
            <button class="explorar-button" onclick="explorarServicios()">Explorar Servicios</button>
        </div>
    </section>





    <!-- Sección de Quiénes Somos -->
    <section class="about" id="quienes-somos">
        <div class="about-container">
            <div class="about-image">
                <a href="https://imgbb.com/"><img src="https://i.ibb.co/LvPzZ5G/dieta.jpg" alt="dieta" border="0"></a>
            </div>
            <div class="about-content">
                <h3>Sobre Nosotros</h3>
                <h1>Bienvenido a <span class="highlight">Dieta Start</span></h1>
                <h4>Expertos en Bienestar y Nutrición</h4>
                <p>Nos especializamos en crear planes de alimentación y ejercicios personalizados para mejorar tu salud y bienestar. Nuestro equipo está dedicado a ayudarte a alcanzar tus metas de forma saludable y sostenible.</p>
                <p>Confía en nosotros para guiarte en el camino hacia un estilo de vida más saludable. Juntos haremos posible el cambio que buscas.</p>
                <a href="{{ asset('cv/NutricionistaCV.pdf') }}" class="cv-button" target="_blank">Descargar Perfil</a>
            </div>
        </div>
    </section>
    

    <!-- Sección de servicios -->
    <section class="services" id="services">
        <h2>Nuestros Servicios</h2>
        <div class="service-container">
            <div class="service-card">
                <a href="https://ibb.co/pdjNsbW"><img src="https://i.ibb.co/4pRCDKs/consulta.webp" alt="Consulta Nutricional" border="0"></a>
                <h3>Consulta Nutricional</h3>
                <p>Recibe orientación personalizada de nuestros expertos en nutrición.</p>
            </div>
            <div class="service-card">
                <a href="https://ibb.co/cyTdZpW"><img src="https://i.ibb.co/dfKyV3N/alimentacion.webp" alt="Planes de Alimentacion" border="0"></a>
                <h3>Planes de Alimentación</h3>
                <p>Planes de alimentación adaptados a tus objetivos y necesidades.</p>
            </div>
            <div class="service-card">
                <a href="https://ibb.co/dcQ9gvZ"><img src="https://i.ibb.co/VNvymG6/seguimiento.webp" alt="seguimiento Personalizado" border="0"></a>
                {{-- <img src="https://ibb.co/dcQ9gvZ" alt="Seguimiento Personalizado"> --}}
                <h3>Seguimiento Personalizado</h3>
                <p>Monitoreamos tu progreso y ajustamos tu plan según tus avances.</p>
            </div>
        </div>
    </section>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 Diesta Start. Todos los derechos reservados.</p>
        <div class="social-icons" id="contactos">
            <a href="https://www.facebook.com" target="_blank" aria-label="Facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.instagram.com" target="_blank" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.tiktok.com" target="_blank" aria-label="TikTok">
                <i class="fab fa-tiktok"></i>
            </a>
        </div>
    </footer>

    <script src="{{ asset('js/vista-inicio/scripts.js') }}"></script>
</body>
</html>
