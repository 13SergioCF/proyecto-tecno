@extends('adminlte::page')

@section('title', 'Crear Alimento')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Alimentos
                        <small class="ml-3 mr-3">|</small><small>Crear Alimento</small>
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
                            <a href="{{ route('aliments.index') }}">Alimentos</a>
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
                        <a class="nav-link" href="{{ route('aliments.index') }}">
                            <i class="fa fa-list mr-2"></i>Lista de Alimentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url()->current() }}">
                            <i class="fa fa-plus mr-2"></i>Crear Alimento
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="food-form" id="food-form" action="{{ route('aliments.store') }}" method="POST" class="col-md-8" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="food-name" class="control-label">Nombre del Alimento:</label>
                            <input class="form-control" placeholder="Ej: Manzana, Pollo, Arroz" required
                                name="nombre" type="text" id="food-name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="food-description" class="control-label">Descripción:</label>
                            <textarea class="form-control" placeholder="Breve descripción del alimento" required name="descripcion"
                                id="food-description"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="food-type" class="control-label">Tipo de Alimento:</label>
                            <select class="form-control" name="food_type_id" id="food-type" required>
                                <option value="">Seleccione un tipo de alimento</option>
                                @foreach ($foodTypes as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Carga de Imagen -->
                        <div class="form-group mb-3">
                            <label for="imagen">Imagen:</label>
                            <input type="file" name="imagen" accept="image/*">
                        </div>
                    
                        <!-- Carga de Video -->
                        <div class="form-group mb-3">
                            <label for="video">Video:</label>
                            <input type="file" name="video" accept="video/*">
                        </div>
                    
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Agregar Alimento
                                </button>
                                <a href="{{ route('aliments.index') }}" class="btn btn-default">
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
    <script src="{{ asset('js/createFood.js') }}"></script>
@stop
