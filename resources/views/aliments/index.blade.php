@extends('adminlte::page')

@section('title', 'Editar Alimento')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Alimentos
                        <small class="ml-3 mr-3">|</small><small>Lista de Alimentos</small>
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
                            <a href="{!! url()->current() !!}">Alimentos</a>
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
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}">
                            <i class="fa fa-list mr-2"></i> Lista de Alimentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('aliments.create') !!}">
                            <i class="fa fa-plus mr-2"></i> Crear Alimento
                        </a>
                    </li>
                </ul>
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        <label for="filter">Filtrar por Estado:</label>
                        <select id="filter" class="form-control">
                            <option value="all">Todos</option>
                            <option value="activo">Activos</option>
                            <option value="inactivo">Inactivos</option>
                        </select>
                    </div>
                    <div>
                        <div class="btn-group mb-3" role="group">
                            <a href="{{ route('aliments.exportPdf') }}" class="btn btn-danger btn-lg">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="alimentos" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>tipo de alimento</th>
                            <th>Estado</th>
                            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aliments as $aliment)
                            <tr class="status-{{ strtolower($aliment->estado) }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $aliment->nombre }}</td>
                                <td>{{ $aliment->descripcion }}</td>
                                <td>{{ $aliment->foodType ? $aliment->foodType->nombre : 'N/A' }}</td> 

                                <td>
                                    @if ($aliment->estado == 'inactivo')
                                        <span class="badge bg-danger">{{ $aliment->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $aliment->estado }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($aliment->estado == 'activo')
                                        <a href="{{ route('aliments.edit', $aliment->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('aliments.destroy', $aliment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Sin acciones</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#alimentos').DataTable();

            // Filtrar la tabla por estado
            $('#filter').change(function() {
                var status = $(this).val();

                table.rows().every(function() {
                    var row = this.node();
                    // Mostrar todas las filas si se selecciona "Todos"
                    if (status === 'all') {
                        $(row).show();
                    } else {
                        // Mostrar solo filas con la clase correspondiente
                        if ($(row).hasClass('status-' + status)) {
                            $(row).show();
                        } else {
                            $(row).hide();
                        }
                    }
                });
                table.draw(); // Redibujar la tabla para aplicar los cambios
            });
        });
    </script>
@stop
