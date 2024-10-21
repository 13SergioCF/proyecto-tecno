@extends('adminlte::page')

@section('title', 'Dashboard Colorido')

@section('content_header')
    <h1>Dashboard de Gestión Nutricional y Ejercicios</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4 col-12">
            <!-- Información de Alimentos -->
            <div class="info-box mb-3 bg-primary">
                <span class="info-box-icon"><i class="fas fa-utensils"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Alimentos</span>
                    <span class="info-box-number" id="randomAlimentos">0</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <!-- Información de Nutrientes -->
            <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fas fa-apple-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Nutrientes</span>
                    <span class="info-box-number" id="randomNutrientes">0</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <!-- Información de Pacientes -->
            <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Pacientes</span>
                    <span class="info-box-number" id="randomPacientes">0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-12">
            <!-- Información de Ejercicios -->
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-dumbbell"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Ejercicios</span>
                    <span class="info-box-number" id="randomEjercicios">0</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <!-- Información de Tipos de Ejercicios -->
            <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-running"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Tipos de Ejercicios</span>
                    <span class="info-box-number" id="randomTiposEjercicios">0</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <!-- Información de Rutinas -->
            <div class="info-box mb-3 bg-dark">
                <span class="info-box-icon"><i class="fas fa-list-ul"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Rutinas</span>
                    <span class="info-box-number" id="randomRutinas">0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-12">
            <!-- Gráfico de Alimentos -->
            <div class="card bg-gradient-primary">
                <div class="card-header">
                    <h3 class="card-title">Distribución de Alimentos</h3>
                </div>
                <div class="card-body">
                    <canvas id="foodChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <!-- Gráfico de Ejercicios -->
            <div class="card bg-gradient-info">
                <div class="card-header">
                    <h3 class="card-title">Distribución de Ejercicios</h3>
                </div>
                <div class="card-body">
                    <canvas id="exerciseChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 col-12">
            <!-- Últimos Alimentos Agregados -->
            <div class="card bg-gradient-info">
                <div class="card-header">
                    <h3 class="card-title">Últimos Alimentos Agregados</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Alimento 1</li>
                        <li class="list-group-item">Alimento 2</li>
                        <li class="list-group-item">Alimento 3</li>
                        <li class="list-group-item">Alimento 4</li>
                        <li class="list-group-item">Alimento 5</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <!-- Últimos Ejercicios Agregados -->
            <div class="card bg-gradient-secondary">
                <div class="card-header">
                    <h3 class="card-title">Últimos Ejercicios Agregados</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Ejercicio 1</li>
                        <li class="list-group-item">Ejercicio 2</li>
                        <li class="list-group-item">Ejercicio 3</li>
                        <li class="list-group-item">Ejercicio 4</li>
                        <li class="list-group-item">Ejercicio 5</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .info-box {
            border-radius: 10px;
            padding: 20px;
            color: white;
        }

        .info-box-icon {
            font-size: 50px;
            margin-right: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .list-group-item {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Simulando la carga de datos aleatorios
        document.addEventListener('DOMContentLoaded', function() {
            const randomAlimentos = Math.floor(Math.random() * 100);
            const randomNutrientes = Math.floor(Math.random() * 50);
            const randomPacientes = Math.floor(Math.random() * 200);
            const randomEjercicios = Math.floor(Math.random() * 80);
            const randomTiposEjercicios = Math.floor(Math.random() * 30);
            const randomRutinas = Math.floor(Math.random() * 25);

            document.getElementById('randomAlimentos').innerText = randomAlimentos;
            document.getElementById('randomNutrientes').innerText = randomNutrientes;
            document.getElementById('randomPacientes').innerText = randomPacientes;
            document.getElementById('randomEjercicios').innerText = randomEjercicios;
            document.getElementById('randomTiposEjercicios').innerText = randomTiposEjercicios;
            document.getElementById('randomRutinas').innerText = randomRutinas;

            // Datos aleatorios para los gráficos
            const foodData = {
                labels: ['Frutas', 'Verduras', 'Proteínas', 'Granos', 'Lácteos'],
                datasets: [{
                    label: 'Cantidad de Alimentos',
                    data: Array.from({ length: 5 }, () => Math.floor(Math.random() * 20)),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            };

            const exerciseData = {
                labels: ['Cardio', 'Fuerza', 'Flexibilidad', 'Balance'],
                datasets: [{
                    label: 'Cantidad de Ejercicios',
                    data: Array.from({ length: 4 }, () => Math.floor(Math.random() * 20)),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            };

            // Creando los gráficos
            const ctxFood = document.getElementById('foodChart').getContext('2d');
            new Chart(ctxFood, {
                type: 'bar',
                data: foodData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.5)',
                            },
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.5)',
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white',
                            },
                        },
                    },
                }
            });

            const ctxExercise = document.getElementById('exerciseChart').getContext('2d');
            new Chart(ctxExercise, {
                type: 'pie',
                data: exerciseData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white',
                            },
                        },
                    },
                }
            });
        });
    </script>
@stop
