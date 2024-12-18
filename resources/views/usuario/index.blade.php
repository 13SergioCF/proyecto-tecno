@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestion de Usuarios
                        <small class="ml-3 mr-3">|</small><small>Lista de Usuario</small>
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
@stop

@section('content')
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <div class="btn-group mb-3" role="group">
                        <a href="{{ route('users.export.pdf') }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('users.export.excel') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Lista
                            de Usuarios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('users.create') !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Usuario</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped " style="width:100%">
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
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->apellido_paterno }}</td>
                                <td>{{ $user->apellido_materno }}</td>
                                <td>{{ $user->genero }}</td>
                                <td>{{ $user->fecha_nacimiento }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>

                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-user"
                                        data-id="{{ $user->id }}" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script src="{{ asset('js/dataTable/dataTableAll.js') }}"></script>
    <script src="{{ asset('js/users/index_user.js') }}"></script>
@stop
