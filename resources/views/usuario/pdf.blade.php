<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Lista de Usuarios</h1>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Ap. Paterno</th>
            <th>Ap. Materno</th>
            <th>Genero</th>
            <th>Fecha Nacimiento</th>
            <th>Email</th>
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->apellido_paterno }}</td>
                <td>{{ $user->apellido_materno }}</td>
                <td>{{ $user->genero }}</td>
                <td>{{ $user->fecha_nacimiento }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
