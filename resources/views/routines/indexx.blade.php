@extends('adminlte::page')

@section('title', 'Dashboard')
@section('css')
    <link rel="stylesheet" href="/css/routines/index.css">
@endsection
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
@endsection

@section('content')
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
                <div class="row">
                    @foreach ($routines as $routine)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow border-0 custom-card">
                                <div class="card-body">
                                    <!-- Encabezado: Nivel y Estado -->
                                    <div class="header">
                                        <span class="badge badge-primary">{{ ucfirst($routine->nivel) }}</span>
                                        <span
                                            class="badge badge-{{ $routine->estado == 'inactivo' ? 'danger' : 'success' }}">
                                            {{ ucfirst($routine->estado) }}
                                        </span>
                                    </div>

                                    <!-- Título de la rutina -->
                                    <h2 class="title">{{ $routine->nombre }}</h2>

                                    <!-- Detalles -->
                                    <div class="details">
                                        <div class="detail-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $routine->duracion_estimada }} min</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>{{ $routine->frecuencia_semanal }}x / semana</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-bullseye"></i>
                                            <span>{{ $routine->objetivo }}</span>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="actions">
                                        <a href="{{ route('routines.show', $routine->id) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('routines.edit', $routine->id) }}"
                                            class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <button type="button" class="btn btn-outline-danger delete-routine"
                                            data-id="{{ $routine->id }}">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('js/dataTable/dataTableAll.js') }}"></script>
    <script src="{{ asset('js/routines/index_routine.js') }}"></script>
@endsection
