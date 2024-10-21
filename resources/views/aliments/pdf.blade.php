<!DOCTYPE html>
<html>
<head>
    <title>Listado de Alimentos</title>
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
    <h1>Listado de Alimentos</h1>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Tipo de Alimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aliments as $aliment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $aliment->nombre }}</td>
                    <td>{{ $aliment->descripcion }}</td>
                    <td>{{ $aliment->estado }}</td>
                    <td>{{ $aliment->foodType->nombre }}</td> <!-- Accediendo al tipo de alimento -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
