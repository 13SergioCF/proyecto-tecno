@extends('adminlte::page')

@section('title', 'Gestión de Días y Turnos')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Días y Turnos
                        <small class="ml-3 mr-3">|</small><small>Crear Relación</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> Inicio
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('daythunders.index') }}">Lista de Relaciones</a>
                        </li>
                        <li class="breadcrumb-item active">Crear Relación</li>
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
                        <a class="nav-link" href="{{ route('daythunders.index') }}">
                            <i class="fa fa-list mr-2"></i> Lista de Relaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fa fa-plus mr-2"></i> Crear Relación
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form action="{{ route('daythunders.store') }}" method="POST" class="col-md-8">
                        @csrf
                        <!-- Selección de Día -->
                        <div class="form-group mb-3">
                            <label for="day-select" class="control-label">Seleccionar Día:</label>
                            <select class="form-control" name="id_dia" id="day-select" required>
                                <option value="">-- Seleccione un Día --</option>
                                @foreach ($days as $day)
                                    <option value="{{ $day->id_dia }}">{{ $day->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selección de Turno -->
                        <div class="form-group mb-3">
                            <label for="thunder-select" class="control-label">Seleccionar Turno:</label>
                            <select class="form-control" name="id_turno" id="thunder-select" required>
                                <option value="">-- Seleccione un Turno --</option>
                                @foreach ($thunders as $thunder)
                                    <option value="{{ $thunder->id_turno }}">{{ $thunder->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Crear Relación
                                </button>
                                <a href="{{ route('daythunders.index') }}" class="btn btn-default">
                                    <i class="fa fa-undo"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/createDayThunder.js') }}"></script>
@stop
