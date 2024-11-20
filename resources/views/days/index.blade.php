@extends('adminlte::page')

@section('title', 'Gestión de Días')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Días
                        <small class="ml-3 mr-3">|</small><small>Lista de Días</small>
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
                            <a href="{!! url()->current() !!}">Días</a>
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
                        <a class="nav-link active" href="{!! url()->current() !!}">
                            <i class="fa fa-list mr-2"></i> Lista de Días
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('days.create') !!}">
                            <i class="fa fa-plus mr-2"></i> Crear Día
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $day) <!-- Cambié $day por $days para iterar sobre todos los días -->
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $day->nombre }}</td>
                                <td>
                                    <a href="{{ route('days.edit', $day->id_dia) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('days.destroy', $day->id_dia) }}" method="POST" style="display:inline;">
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

@section('js')
    {{-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ asset('js/dataTable/dataTableAll.js') }}"></script>
@stop
