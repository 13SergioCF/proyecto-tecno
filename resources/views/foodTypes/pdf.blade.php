<!DOCTYPE html>
<html>
<head>
    <title>Tipos de Alimento</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tipos de Alimento</h1>
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
            @foreach ($foodTypes as $foodType)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $foodType->nombre }}</td>
                    <td>{{ $foodType->descripcion }}</td>
                    <td>{{ $foodType->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
