@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <h1>Editar Usuario</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" value="{{ $user->name }}" required>

    <label for="apellido_paterno">Apellido Paterno:</label>
    <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ $user->apellido_paterno }}">

    <label for="apellido_materno">Apellido Materno:</label>
    <input type="text" name="apellido_materno" id="apellido_materno" value="{{ $user->apellido_materno }}">

    <label for="genero">Género:</label>
    <select name="genero" id="genero">
        <option value="M" {{ $user->genero == 'M' ? 'selected' : '' }}>Masculino</option>
        <option value="F" {{ $user->genero == 'F' ? 'selected' : '' }}>Femenino</option>
        <option value="Otro" {{ $user->genero == 'Otro' ? 'selected' : '' }}>Otro</option>
    </select>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $user->fecha_nacimiento }}">

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="{{ $user->email }}" required>

    <label for="password">Nueva Contraseña (Opcional):</label>
    <input type="password" name="password" id="password">

    <label for="role">Rol:</label>
    <select name="role" id="role">
        @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
        @endforeach
    </select>

    <button type="submit">Actualizar</button>
</form>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop