@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestion de Ejercicios
                        <small class="ml-3 mr-3">|</small><small>Crear Ejercicio</small>
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
                            <a href="{!! url()->current() !!}">Ejercicios</a>
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
                        <a class="nav-link" href="{!! route('exercises.index') !!}"><i class="fa fa-list mr-2"></i>Lista de
                            Ejercicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Ejercicio</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="exercise-form" id="exercise-form" action="{{ route('exercises.store') }}" method="POST"
                        class="col-md-8">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="exercise-name" class="control-label">Nombre del Ejercicio:</label>
                            <input class="form-control" placeholder="Ej: Sentadillas, Correr, Estiramientos" required
                                name="nombre" type="text" id="exercise-name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="exercise-description" class="control-label">Descripción:</label>
                            <textarea class="form-control" placeholder="Breve descripción del ejercicio" required name="descripcion"
                                id="exercise-description"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="exercise-type" class="control-label">Tipo de Ejercicio:</label>
                            <select name="tipo_ejercicio" id="exercise-type" class="form-control">
                                <option value="" selected disabled>Seleccione el tipo de ejercicio</option>
                                {{-- @foreach ($exerciseTypes as $type) --}}
                                <option value="#">Tipo de Ejercicio</option>
                                {{-- @endforeach --}}
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="exercise-duration" class="control-label">Duración (minutos):</label>
                                <input class="form-control" placeholder="Ej: 30" required name="duracion" type="number"
                                    id="exercise-duration">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="exercise-calories" class="control-label">Calorías Quemadas:</label>
                                <input class="form-control" placeholder="Ej: 150" required name="calorias" type="number"
                                    id="exercise-calories">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Agregar
                                    Ejercicio</button>
                                <a href="{!! route('exercises.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>
                                    Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/createUser.js') }}"></script>
@stop
