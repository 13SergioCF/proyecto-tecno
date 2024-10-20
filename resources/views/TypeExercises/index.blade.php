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
                        <a class="nav-link" href="{!! route('types.create') !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Ejercicio</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="ejercicios" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
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
                                    <a href="{{ route('types.edit', $ejercicio->id) }}" class="btn btn-warning btn-sm"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('exercises.destroy', $ejercicio->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@if (session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-check-circle"></i> Operación exitosa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-thumbs-up fa-3x text-success mb-3"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endif
