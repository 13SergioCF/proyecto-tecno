@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestion de Tipo de Ejercicio
                        <small class="ml-3 mr-3">|</small><small>Crear Tipo de Ejercicio</small>
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
                            <a href="{!! url()->current() !!}">Tipo de Ejercicios</a>
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
                        <a class="nav-link" href="{!! route('exercise-types.index') !!}"><i class="fa fa-list mr-2"></i>Lista de Tipos de
                            Ejercicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Crear Tipo
                            de Ejercicio</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="exercise-type-form" id="exercise-type-form" class="col-md-8">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="exercise-type-name" class="control-label">Nombre del Tipo de Ejercicio:</label>
                            <input class="form-control" placeholder="Ej: Cardio, Fuerza, Flexibilidad" required
                                name="nombre" type="text" id="exercise-type-name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="exercise-type-description" class="control-label">Descripción:</label>
                            <textarea class="form-control" placeholder="Breve descripción del tipo de ejercicio" required name="descripcion"
                                id="exercise-type-description"></textarea>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Agregar Tipo de
                                    Ejercicio</button>
                                <a href="{!! route('exercise-types.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>
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
    <script src="{{ asset('js/sweetAlert2/create_exercise_type.js') }}"></script>
@endsection
