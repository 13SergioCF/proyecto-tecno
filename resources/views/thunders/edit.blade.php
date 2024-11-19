@extends('adminlte::page')

@section('title', 'Gestión de Turnos')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Turnos
                        <small class="ml-3 mr-3">|</small><small>Editar Turno</small>
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
                            <a href="{!! url()->current() !!}">Turnos</a>
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
                        <a class="nav-link" href="{!! route('thunders.index') !!}">
                            <i class="fa fa-list mr-2"></i> Lista de Turnos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}">
                            <i class="fa fa-edit mr-2"></i> Editar Turno
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="thunder-form" id="thunder-form" action="{{ route('thunders.update', $thunder->id_turno) }}" method="POST" class="col-md-8">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="thunder-name" class="control-label">Nombre del Turno:</label>
                            <input class="form-control" placeholder="Ej: Turno Mañana, Turno Tarde" required
                                name="nombre" type="text" id="thunder-name" value="{{ old('nombre', $thunder->nombre) }}">
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Actualizar Turno
                                </button>
                                <a href="{!! route('thunders.index') !!}" class="btn btn-default">
                                    <i class="fa fa-undo"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/createThunder.js') }}"></script>
@stop
