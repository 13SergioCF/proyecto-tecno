@extends('adminlte::page')

@section('title', 'Gestión de Días y Turnos')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Días y Turnos
                        <small class="ml-3 mr-3">|</small><small>Lista de Relaciones</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> Inicio
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{!! url()->current() !!}">Relaciones</a>
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
                            <i class="fa fa-list mr-2"></i> Lista de Relaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('daythunders.create') !!}">
                            <i class="fa fa-plus mr-2"></i> Crear Relación
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Día</th>
                            <th>Turno</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dayThunders as $relation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $relation->day->nombre ?? 'No definido' }}</td>
                                <td>{{ $relation->thunder->nombre ?? 'No definido' }}</td>
                                <td>
                                    <!-- Botón de Editar -->
                                    <a href="{{ route('daythunders.edit', ['id_dia' => $relation->id_dia, 'id_turno' => $relation->id_turno]) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Botón de Eliminar -->
                                    <form action="{{ route('daythunders.destroy', ['id_dia' => $relation->id_dia, 'id_turno' => $relation->id_turno]) }}" 
                                        method="POST" 
                                        style="display:inline;">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" 
                                              class="btn btn-danger btn-sm" 
                                              title="Eliminar" 
                                              onclick="return confirm('¿Estás seguro de eliminar esta relación?')">
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
    {{-- Incluye los scripts necesarios para DataTables --}}
    <script src="{{ asset('js/dataTable/dataTableAll.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable();
        });
    </script>
@stop
