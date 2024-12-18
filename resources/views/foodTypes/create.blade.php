@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Tipo de Alimento
                        <small class="ml-3 mr-3">|</small><small>Crear Tipo de Alimento</small>
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
                            <a href="{!! url()->current() !!}">Tipo de Alimentos</a>
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
                        <a class="nav-link" href="{!! route('food-types.index') !!}">
                            <i class="fa fa-list mr-2"></i>Lista de Tipos de Alimento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}">
                            <i class="fa fa-plus mr-2"></i>Crear Tipo de Alimento
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-conte  nt-center">
                    <form name="food-type-form" id="food-type-form" action="{{ route('food-types.store') }}" method="POST" class="col-md-8">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="food-type-name" class="control-label">Nombre del Tipo de Alimento:</label>
                            <input class="form-control" placeholder="Ej: Frutas, Verduras, Proteínas" required
                                name="nombre" type="text" id="food-type-name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="food-type-description" class="control-label">Descripción:</label>
                            <textarea class="form-control" placeholder="Breve descripción del tipo de alimento" required name="descripcion"
                                id="food-type-description"></textarea>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Agregar Tipo de Alimento
                                </button>
                                <a href="{!! route('food-types.index') !!}" class="btn btn-default">
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
    <script src="{{ asset('js/createFoodType.js') }}"></script>
@stop
