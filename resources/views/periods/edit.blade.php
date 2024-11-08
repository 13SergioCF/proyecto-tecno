
@extends('adminlte::page')

@section('title', 'Editar Periodo')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        Gestión de Periodos
                        <small class="ml-3 mr-3">|</small><small>Editar Periodo</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> {{ trans('lang.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{!! route('periods.index') !!}">Lista de Periodos</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{!! url()->current() !!}">Editar Periodo</a>
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
                        <a class="nav-link" href="{!! route('periods.index') !!}">
                            <i class="fa fa-list mr-2"></i> Lista de Periodos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}">
                            <i class="fa fa-edit mr-2"></i> Editar Periodo
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row my-5 justify-content-center">
                    <form name="period-form" id="period-form" action="{{ route('periods.update', $period->id) }}" method="POST" class="col-md-8">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="fecha_inicio" class="control-label">Fecha de Inicio:</label>
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                   name="fecha_inicio" id="fecha_inicio" required value="{{ old('fecha_inicio', $period->fecha_inicio) }}">
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="fecha_final" class="control-label">Fecha Final:</label>
                            <input type="date" class="form-control @error('fecha_final') is-invalid @enderror" 
                                   name="fecha_final" id="fecha_final" required value="{{ old('fecha_final', $period->fecha_final) }}">
                            @error('fecha_final')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Actualizar Periodo
                                </button>
                                <a href="{!! route('periods.index') !!}" class="btn btn-default">
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
    <script src="{{ asset('js/editPeriod.js') }}"></script>
@stop
