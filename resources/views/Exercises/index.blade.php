@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <a href="{{ route('exercises.create') }}" class="btn btn-primary" type="button">Crear nuevo usuario</a>

    {{-- Aquí puedes añadir el código HTML de la tabla --}}
    <table id="usuario" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ap. Paterno</th>
                <th>Ap. Materno</th>
                <th>Genero</th>
                <th>Fecha Nacimiento </th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        {{-- <tbody>
            @foreach ($exercises as $exercise)
                <tr>
                    <td>{{ $exercise->name }}</td>
                    <td>{{ $exercise->apellido_paterno }}</td>
                    <td>{{ $exercise->apellido_materno }}</td>
                    <td>{{ $exercise->genero }}</td>
                    <td>{{ $exercise->fecha_nacimiento }}</td>
                    <td>{{ $exercise->email }}</td>
                    <td>{{ $exercise->roles->pluck('name')->join(', ') }}</td> <!-- Mostrar el rol del usuario -->

                    <td>
                        <a href="#" class="btn btn-warning btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('exercises.destroy', $exercise->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>



                </tr>
            @endforeach
        </tbody> --}}
    </table>
@stop

@section('css')
    {{-- Incluir estilos de DataTables si es necesario --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stop

@section('js')
    {{-- Incluir la librería DataTables y el código de inicialización --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script> --}}
@stop
