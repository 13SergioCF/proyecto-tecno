@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestion de Tipo de Ejercicio
                        <small class="ml-3 mr-3">|</small><small>Crear Rutina</small>
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

    <div class="content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('routines.index') !!}"><i class="fa fa-list mr-2"></i>Lista de
                            Rutinas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Editar
                            Rutina</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="edit-routine-form" data-id={{ $routine->id }} id="edit-routine-form" class="col-md-8">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="routine-name" class="control-label">Nombre de la rutina:</label>
                            <input class="form-control" placeholder="Ej: Piernas, Brazos, Pectorales" required
                                name="nombre" type="text" id="routine-name" value="{{ $routine->nombre }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="routine-description" class="control-label">Descripción:</label>
                            <textarea class="form-control" placeholder="Breve descripción de la rutina" required name="descripcion"
                                id="routine-description">{{ $routine->descripcion }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="nivel" class="control-label">Nivel:</label>
                                <select name="nivel" id="nivel" class="form-control" required>
                                    <option value="" disabled>Seleccione el Nivel</option>
                                    <option value="principiante" {{ $routine->nivel == 'principiante' ? 'selected' : '' }}>
                                        Principiante</option>
                                    <option value="intermedio" {{ $routine->nivel == 'intermedio' ? 'selected' : '' }}>
                                        Intermedio</option>
                                    <option value="avanzado" {{ $routine->nivel == 'avanzado' ? 'selected' : '' }}>
                                        Avanzado
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="routine-duration" class="control-label">Duración (minutos):</label>
                                <input class="form-control" placeholder="Ej: 30" required name="duracion_estimada"
                                    type="number" id="routine-duration" min="1"
                                    value="{{ $routine->duracion_estimada }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="objetivo" class="control-label">Objetivo:</label>
                                <input class="form-control" placeholder="Objetivo de la rutina" required name="objetivo"
                                    type="text" id="objetivo" value="{{ $routine->objetivo }}">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="frecuencia_semanal" class="control-label">Frecuencia Semanal:</label>
                                <input class="form-control" placeholder="Repeticiones Semanal" required
                                    name="frecuencia_semanal" type="number" id="frecuencia_semanal"
                                    value="{{ $routine->frecuencia_semanal }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="activo" {{ $routine->estado == 'activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="inactivo" {{ $routine->estado == 'inactivo' ? 'selected' : '' }}>
                                    Inactivo
                            </select>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info edit-routine">
                                    <i class="fa fa-save"></i> Guardar Cambios
                                </button>
                                <a href="{!! route('routines.index') !!}" class="btn btn-default">
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
    <script src="{{ asset('js/routines/edit_routine.js') }}"></script>
@endsection
