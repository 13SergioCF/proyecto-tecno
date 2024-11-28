@extends('adminlte::page')

@section('title', 'Gestión de Alimentos')
@section('css')
    <link rel="stylesheet" href="/css/aliments/index.css">
@endsection
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
@endsection

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
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($aliments as $alimento)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow border-0 custom-card">
                                <div class="card-body">
                                    <!-- Encabezado: Categoría y Estado -->
                                    <div class="header">
                                        <span class="badge badge-primary">{{ ucfirst($alimento->categoria) }}</span>
                                        <span
                                            class="badge badge-{{ $alimento->estado == 'inactivo' ? 'danger' : 'success' }}">
                                            {{ ucfirst($alimento->estado) }}
                                        </span>
                                    </div>

                                    <!-- Nombre del alimento -->
                                    <h2 class="title">{{ $alimento->nombre }}</h2>

                                    <!-- Detalles -->
                                    <div class="details">
                                        <div class="detail-item">
                                            <i class="fas fa-weight"></i>
                                            <span>{{ $alimento->calorias }} kcal</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-seedling"></i>
                                            <span>{{ $alimento->macronutrientes }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-drumstick-bite"></i>
                                            <span>{{ $alimento->proteinas }} g proteína</span>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="actions">
                                        <a href="{{ route('aliments.show', $alimento->id) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('aliments.edit', $alimento->id) }}"
                                            class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <button type="button" class="btn btn-outline-danger delete-aliment"
                                            data-id="{{ $alimento->id }}">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/aliments/index_aliment.js') }}"></script>
@endsection
