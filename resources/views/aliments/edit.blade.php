@extends('adminlte::page')

@section('title', 'Editar Alimento')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Alimento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> {{ trans('lang.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('aliments.index') }}">Alimentos</a>
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
                <h3 class="card-title">Editar Alimento: {{ $aliment->nombre }}</h3>
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

                <form action="{{ route('aliments.update', $aliment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre del Alimento</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $aliment->nombre) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $aliment->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="aliment-food-type">Tipo de Alimento:</label>
                        <select class="form-control" name="food_type_id" id="aliment-food-type" required>
                            <option value="">Seleccione un tipo de alimento</option>
                            @foreach ($foodTypes as $id => $nombre)
                                <option value="{{ $id }}" {{ $aliment->food_type_id == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select class="form-control" name="estado" id="estado" required>
                            <option value="activo" {{ $aliment->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $aliment->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="{{ route('aliments.index') }}" class="btn btn-secondary">Cancelar</a>
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
        console.log('Editando alimento');
    </script>
@stop
