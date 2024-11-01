@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Rutinas
                        <small class="ml-3 mr-3">|</small><small>Lista de Rutinas</small>
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
                            <a href="{!! url()->current() !!}">Rutinas</a>
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
                        <a href="#" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="#" class="btn btn-success btn-lg">
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
                            de Rutinas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('routines.create') !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Rutina</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Nivel</th>
                            <th>Duración</th>
                            <th>Objetivo</th>
                            <th>Frecuencia Semanal</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routines as $routine)
                            <tr>
                                <td>{{ $routine->id }}</td>
                                <td>{{ $routine->nombre }}</td>
                                <td>{{ $routine->descripcion }}</td>
                                <td>{{ $routine->nivel }}</td>
                                <td>{{ $routine->duracion_estimada }}</td>
                                <td>{{ $routine->objetivo }}</td>
                                <td>{{ $routine->frecuencia_semanal }}</td>
                                <td>
                                    @if ($routine->estado == 'inactivo')
                                        <span class="badge bg-danger">{{ $routine->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $routine->estado }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('routines.edit', $routine->id) }}" class="btn btn-warning btn-sm"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-routine"
                                        data-id="{{ $routine->id }}" title="Eliminar">
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
    <script src="{{ asset('js/routines/index_routine.js') }}"></script>
@stop
