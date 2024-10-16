@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <h1>Crear Usuario</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" required>

    <label for="apellido_paterno">Apellido Paterno:</label>
    <input type="text" name="apellido_paterno" id="apellido_paterno">

    <label for="apellido_materno">Apellido Materno:</label>
    <input type="text" name="apellido_materno" id="apellido_materno">

    <label for="genero">Género:</label>
    <select name="genero" id="genero">
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
        <option value="Otro">Otro</option>
    </select>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>

    <label for="role">Rol:</label>
    <select name="role" id="role">
        @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>

    <button type="submit">Crear</button>
</form>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop