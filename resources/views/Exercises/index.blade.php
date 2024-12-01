@extends('adminlte::page')

@section('title', 'Gestión de Ejercicios')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Ejercicios
                        <small class="ml-3 mr-3">|</small><small>Lista de Ejercicios</small>
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
@endsection

@section('content')

    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <div class="btn-group mb-3" role="group">
                        <a href="{{ route('exercises.exportPdf') }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </a>
                        <a href="#" class="btn btn-success btn-lg">
                            <i class="fas fa-file-excel"></i> Exportar Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}">
                            <i class="fa fa-list mr-2"></i>Lista de Ejercicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('exercises.create') !!}">
                            <i class="fa fa-plus mr-2"></i>Crear Ejercicio
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Duración</th>
                            <th>Dificultad</th>
                            <th>Estado</th>
                            <th>Imagen</th>
                            <th>Video</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exercises as $exercise)
                            <tr>
                                <td>{{ $exercise->id }}</td>
                                <td>{{ $exercise->nombre }}</td>
                                <td>{{ $exercise->descripcion }}</td>
                                <td>{{ $exercise->exerciseType->nombre ?? 'N/A' }}</td>
                                <td>{{ $exercise->duracion_estimada }} minutos</td>
                                <td>{{ ucfirst($exercise->dificultad) }}</td>
                                <td>
                                    <span class="badge {{ $exercise->estado == 'inactivo' ? 'bg-danger' : 'bg-success' }}">
                                        {{ ucfirst($exercise->estado) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($exercise->imagen_url)
                                        <img src="{{ $exercise->imagen_url }}" alt="Imagen de {{ $exercise->nombre }}"
                                            width="100" height="100" style="object-fit: cover;">
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>
                                    @if ($exercise->video_url)
                                        <video width="150" height="100" controls>
                                            <source src="{{ $exercise->video_url }}" type="video/mp4">
                                            Tu navegador no soporta reproducción de video.
                                        </video>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('exercises.edit', $exercise->id) }}" class="btn btn-warning btn-sm"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-exercise"
                                        data-id="{{ $exercise->id }}" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/dataTable/dataTableAll.js') }}"></script>
    <script src="{{ asset('js/exercises/index_exercise.js') }}"></script>
@endsection
