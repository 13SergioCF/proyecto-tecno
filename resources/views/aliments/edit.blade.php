@extends('adminlte::page')

@section('title', 'Editar Alimento')

@section('content_header')
    <div class="content-header">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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

                <form id="edit-aliment-form" action="{{ route('aliments.update', $aliment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                
                    <!-- Campo: Nombre -->
                    <div class="form-group">
                        <label for="nombre">Nombre del Alimento</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $aliment->nombre) }}" required>
                    </div>
                
                    <!-- Campo: Descripción -->
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $aliment->descripcion) }}</textarea>
                    </div>
                
                    <!-- Campo: Tipo de Alimento -->
                    <div class="form-group">
                        <label for="aliment-food-type">Tipo de Alimento:</label>
                        <select class="form-control" name="food_type_id" id="aliment-food-type" required>
                            <option value="">Seleccione un tipo de alimento</option>
                            @foreach ($foodTypes as $id => $nombre)
                                <option value="{{ $id }}" {{ $aliment->food_type_id == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Campo: Estado -->
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select class="form-control" name="estado" id="estado" required>
                            <option value="activo" {{ $aliment->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $aliment->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                
                    <!-- Campo: Imagen -->
                    <div class="form-group">
                        <label for="imagen">Imagen:</label>
                        <input type="file" name="imagen" accept="image/*">
                        @if($aliment->imagen_url)
                            <div class="mt-2">
                                <img src="{{ $aliment->imagen_url }}" alt="Imagen actual" style="max-width: 200px;">
                            </div>
                        @else
                            <p>No se ha subido una imagen.</p>
                        @endif
                    </div>
                
                    <!-- Campo: Video -->
                    <div class="form-group">
                        <label for="video">Video:</label>
                        <input type="file" name="video" accept="video/*">
                        @if($aliment->video_url)
                            <div class="mt-2">
                                <video width="200" controls>
                                    <source src="{{ $aliment->video_url }}" type="video/mp4">
                                    Tu navegador no soporta el formato de video.
                                </video>
                            </div>
                        @else
                            <p>No se ha subido un video.</p>
                        @endif
                    </div>
                
                    <!-- Botón de guardar -->
                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-save"></i> Guardar Cambios
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
@stop

@section('js')
    <script src="{{ asset('js/aliment/edit_aliment.js') }}"></script>
@stop
