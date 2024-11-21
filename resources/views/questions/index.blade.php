@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Preguntas
                        <small class="ml-3 mr-3">|</small><small>Lista de preguntas</small>
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
                            <a href="{!! url()->current() !!}">Preguntas</a>
                        </li>
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
                            de Preguntas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('questions.create') !!}"><i class="fa fa-plus mr-2"></i>Crear
                            Pregunta</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Contenido</th>
                            <th>Tipo de pregunta</th>
                            <th>Formato</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->contenido }}</td>
                                <td>{{ $question->questionType->nombre }}</td>
                                <th>{{ $question->formato }}</th>
                                <td>
                                    @if ($question->estado == 'inactivo')
                                        <span class="badge bg-danger">{{ $question->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $question->estado }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-question"
                                        data-id="{{ $question->id }}" title="Eliminar">
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
    <script src="{{ asset('js/questions/index_question.js') }}"></script>
@endsection
