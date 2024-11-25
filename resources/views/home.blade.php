@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Bienvenido a la página para los gordos</p>

    {{-- Mostrar el rol del usuario autenticado --}}
    @if(auth()->check())
        <p>Rol del usuario: 
            @foreach(auth()->user()->getRoleNames() as $role)
                {{ $role }}
            @endforeach
        </p>
    @else
        <p>No hay un usuario autenticado.</p>
    @endif
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
