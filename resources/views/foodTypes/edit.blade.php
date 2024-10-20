@extends('adminlte::page')

@section('title', 'Editar Tipo de Alimento')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Editar Tipo de Alimento
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> {{ trans('lang.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('food-types.index') }}">Tipos de Alimento</a>
                        </li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Tipo de Alimento: {{ $foodType->nombre }}</h3> <!-- Cambiado aquí -->
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('food-types.update', $foodType->id) }}" method="POST"> <!-- Cambiado aquí -->
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre del Tipo de Alimento</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $foodType->nombre) }}" required> <!-- Cambiado aquí -->
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"
                            required>{{ old('descripcion', $foodType->descripcion) }}</textarea> <!-- Cambiado aquí -->
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="activo" {{ $foodType->estado == 'activo' ? 'selected' : '' }}>Activo</option> <!-- Cambiado aquí -->
                            <option value="inactivo" {{ $foodType->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option> <!-- Cambiado aquí -->
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="{{ route('food-types.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@stop

@section('js')
    <script>
        console.log('Editando tipo de alimento');
    </script>
@stop
