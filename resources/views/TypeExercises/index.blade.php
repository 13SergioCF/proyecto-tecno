@extends('adminlte::page')

@section('title', 'Dashboard')

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
@stop
@section('content')

    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <div class="btn-group mb-3" role="group">
                        <a href="#" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="#" class="btn btn-success btn-lg">
                            <i class="fas fa-file-excel"></i> Excel
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
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Lista
                            de Ejercicios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('exercise-types.create') !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Ejercicio</a>
                    </li>
                </ul>
            </div>
            <div class="container">
                <h2 class="my-4">Lista de Ejercicios</h2>
                <div class="row">
                    @foreach ($ejercicios as $ejercicio)
                        <div class="col-md-15 mb-2"> <!-- Card más ancha ocupando 6 columnas -->
                            <div class="card h-100 shadow-lg"
                                style="display: flex; flex-direction: row; max-height: 200px;">
                                <img src="#" class="card-img-left" alt="Imagen del Ejercicio"
                                    style="width: 40%; object-fit: cover;">
                                <div class="card-body" style="flex: 1;">
                                    <h5 class="card-title">{{ $ejercicio->nombre }}</h5>
                                    <p class="card-text">{{ $ejercicio->descripcion }}</p>
                                    <p class="card-text">
                                        @if ($ejercicio->estado == 'inactivo')
                                            <span class="badge bg-danger">{{ $ejercicio->estado }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $ejercicio->estado }}</span>
                                        @endif
                                    </p>
                                    <p>

                                        <button type="button" class="btn btn-danger btn-sm delete-exercise-types"
                                            data-id="{{ $ejercicio->id }}" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                    </p>
                                    <a href="{{ route('exercise-types.edit', $ejercicio->id) }}"
                                        class="btn btn-warning mt-2" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-primary mt-2">Ver
                                        Detalles</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                        <a href="#" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="#" class="btn btn-success btn-lg">
                            <i class="fas fa-file-excel"></i> Excel
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
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>Lista
                            de Ejercicios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('exercise-types.create') !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Ejercicio</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ejercicios as $ejercicio)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ejercicio->nombre }}</td>
                                <td>{{ $ejercicio->descripcion }}</td>
                                <td>
                                    @if ($ejercicio->estado == 'inactivo')
                                        <span class="badge bg-danger">{{ $ejercicio->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $ejercicio->estado }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('exercise-types.edit', $ejercicio->id) }}"
                                        class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-exercise-types"
                                        data-id="{{ $ejercicio->id }}" title="Eliminar">
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
@stop
@section('js')
    <script src="{{ asset('js/dataTable/dataTableAll.js') }}"></script>
    <script src="{{ asset('js/sweetAlert2/index_exercise_type.js') }}"></script>
@endsection
