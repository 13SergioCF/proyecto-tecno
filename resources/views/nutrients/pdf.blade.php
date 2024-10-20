<!DOCTYPE html>
<html>
<head>
    <title>Nutrientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        img {
            width: 100px; /* Ajusta el tamaño del logo según sea necesario */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('path/to/logo.png') }}" alt="Logo de la Empresa"> <!-- Cambia la ruta al logo -->
        <h1>Nutrientes</h1>
        <p>Nombre de la Empresa</p>
        <p>Dirección de la Empresa</p>
        <p>Teléfono: (123) 456-7890</p>
        <p>Email: contacto@empresa.com</p>
    </header>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nutrients as $nutrient)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $nutrient->nombre }}</td>
                    <td>{{ $nutrient->descripcion }}</td>
                    <td>{{ $nutrient->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <p>&copy; {{ date('Y') }} Nombre de la Empresa. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
