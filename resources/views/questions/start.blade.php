<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida de Nutricionista</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/questions/start.css">
</head>

<body>
    <!-- Contenedor de bienvenida -->
    <div id="welcome-container" class="welcome-container">
        <div class="message-bubble" id="message-bubble">
        </div>
        <div class="nutritionist">
            <img src="{{ asset('img/nutricionista.png') }}" alt="Nutricionista">
        </div>

        <button id="start-button">Iniciar</button>
        <div id="loading-screen" class="loading-screen" style="display: none;">
            <div class="spinner"></div>
        </div>
    </div>
    <script src="{{ asset('js/questions/message_bubble.js') }}"></script>
    <script src="{{ asset('js/questions/start_question.js') }}"></script>
</body>

</html>
