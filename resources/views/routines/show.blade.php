@extends('adminlte::page')

@section('title', 'routines')
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-4xl">
        <a href="{{ url('/') }}" class="btn btn-ghost mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
            </svg>
            Volver
        </a>

        <div class="card">
            <div class="card-header space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-3xl">{{ $routine->nombre }}</h3>
                    <span
                        class="badge {{ $routine->nivel_dificultad === 'principiante' ? 'badge-secondary' : ($routine->nivel_dificultad === 'intermedio' ? 'badge-default' : 'badge-destructive') }}">
                        {{ $routine->nivel_dificultad }}
                    </span>
                </div>

                <p class="text-muted-foreground">{{ $routine->descripcion }}</p>

                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z" />
                        </svg>
                        {{ $routine->duracion_estimada }} min
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z" />
                        </svg>
                        {{ $routine->frecuencia_semanal }}x / semana
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z" />
                        </svg>
                        {{ $routine->objetivo }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z" />
                        </svg>
                        {{ $routine->calorias_quemadas }} calorías
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tabs">
                    <ul class="tabs-list grid grid-cols-3">
                        <li><a href="#exercises" class="tabs-trigger">Ejercicios</a></li>
                        <li><a href="#stats" class="tabs-trigger">Estadísticas</a></li>
                        <li><a href="#progress" class="tabs-trigger">Progreso</a></li>
                    </ul>
                    <div class="tabs-content" id="exercises">
                        <div class="grid gap-4 mt-4">
                            @if ($routine->ejercicios && $routine->ejercicios->count() > 0)
                                @foreach ($routine->ejercicios as $ejercicio)
                                    <div class="card" key="{{ $ejercicio->id }}">
                                        <div class="card-content p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-semibold text-lg">{{ $ejercicio->nombre }}</h4>
                                                    <p class="text-sm text-muted-foreground">{{ $ejercicio->descripcion }}
                                                    </p>
                                                </div>
                                                <span
                                                    class="badge {{ $ejercicio->dificultad === 'principiante' ? 'badge-secondary' : ($ejercicio->dificultad === 'intermedio' ? 'badge-default' : 'badge-destructive') }}">
                                                    {{ $ejercicio->dificultad }}
                                                </span>
                                            </div>
                                            <div class="flex flex-wrap gap-4 mt-2 text-sm text-muted-foreground">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M4 4v16h16V4H4z" />
                                                    </svg>
                                                    {{ $ejercicio->series }} series x {{ $ejercicio->repeticiones }} reps
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M4 4v16h16V4H4z" />
                                                    </svg>
                                                    {{ $ejercicio->duracion_estimada }} min
                                                </div>
                                                <div>
                                                    Descanso: {{ $ejercicio->descanso }}s
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <span class="text-sm font-medium">Músculos trabajados: </span>
                                                @foreach ($ejercicio->musculos_trabajados as $musculo)
                                                    <span class="badge badge-outline mr-1">{{ $musculo }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No hay ejercicios disponibles para esta rutina.</p>
                            @endif
                        </div>
                    </div>
                    <div class="tabs-content" id="stats">
                        <!-- Estadísticas Aquí -->
                        <!-- Implementa la lógica para mostrar gráficos de barra -->
                    </div>
                    <div class="tabs-content" id="progress">
                        <!-- Progreso de la Rutina -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
