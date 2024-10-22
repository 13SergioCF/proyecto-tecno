@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestion de Usuarios
                        <small class="ml-3 mr-3">|</small><small>Crear Usuario</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> {{ trans('lang.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{!! url()->current() !!}">Usuarios</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">

                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('users.index') !!}"><i class="fa fa-list mr-2"></i>Lista de
                            Usuarios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Usuario</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="user-form" id="user-form" class="col-md-8">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="control-label">Nombre:</label>
                            <input class="form-control" placeholder="Nombre(s)" required name="name" type="text"
                                id="name">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="apellido_paterno" class="control-label">Apellido Paterno:</label>
                                <input class="form-control" placeholder="Paterno" required name="apellido_paterno"
                                    type="text" id="apellido_paterno">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="apellido_materno" class="control-label">Apellido Materno:</label>
                                <input class="form-control" placeholder="Materno" required name="apellido_materno"
                                    type="text" id="apellido_materno">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="genero" class="control-label">Género:</label>
                            <select name="genero" id="genero" class="form-control">
                                <option selected>Genero</option>
                                <option value="M">Masculino</option>
                                <option value="D">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_nacimiento" class="control-label">Fecha de Nacimiento:</label>
                            <input class="form-control" placeholder="Fecha de Nacimiento" required name="fecha_nacimiento"
                                type="date" id="fecha_nacimiento">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="email" class="control-label">Email:</label>
                                <input class="form-control" placeholder="Correo Electrónico" required name="email"
                                    type="email" id="email">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="password" class="control-label">Contraseña:</label>
                                <input class="form-control" placeholder="Contraseña" required name="password"
                                    type="password" id="password">
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="rol" class="control-label">Rol:</label>
                            <select name="rol" id="rol" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Guardar
                                    Usuario</button>
                                <a href="{!! route('users.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>
                                    Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@stop

@section('js')
    <script src="{{ asset('js/users/create_user.js') }}"></script>
@stop
