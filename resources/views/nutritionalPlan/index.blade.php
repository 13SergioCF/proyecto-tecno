@extends('adminlte::page')

@section('title', 'Plan Nutricional y de Ejercicios')

@section('css')
    <link rel="stylesheet" href="/css/nutritional-plan/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    <div class="scrollable-content">
        <div class="container my-5" id="nutritional-plan-container">
            <h1 class="text-center mb-5">Plan Nutricional y de Ejercicios</h1>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Plan Semanal</h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabs for Nutrición y Ejercicios -->
                            <ul class="nav nav-tabs" id="planTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nutrition-tab" data-toggle="tab" href="#nutrition"
                                        role="tab">
                                        <i class="fa fa-apple-alt mr-2"></i>Nutrición
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="exercise-tab" data-toggle="tab" href="#exercise" role="tab">
                                        <i class="fa fa-dumbbell mr-2"></i>Ejercicios
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-4">
                                <!-- Nutrición Tab -->
                                <div class="tab-pane fade show active" id="nutrition" role="tabpanel">
                                    <div class="plan-day">
                                        <h4 id="currentDayNutrition">Domingo</h4>
                                        <ul id="nutritionList">
                                            <li>Desayuno: Frutas variadas</li>
                                            <li>Almuerzo: Paella de mariscos</li>
                                            <li>Cena: Ensalada mixta con nueces</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Ejercicios Tab -->
                                <div class="tab-pane fade" id="exercise" role="tabpanel">
                                    <div class="plan-day">
                                        <h4 id="currentDayExercise">Domingo</h4>
                                        <ul id="exerciseList">
                                            <li>Día de descanso activo</li>
                                            <li>Estiramientos suaves</li>
                                            <li>Meditación</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-outline-primary" id="prevDay">
                                    <i class="fa fa-chevron-left mr-2"></i>Anterior
                                </button>
                                <button class="btn btn-outline-primary" id="nextDay">
                                    Siguiente<i class="fa fa-chevron-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Línea de Tiempo -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Línea de Tiempo</h3>
                            <p class="card-description">Tu progreso semanal</p>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                    <div class="timeline-event d-flex align-items-center mb-4">
                                        <div class="timeline-day-circle {{ $loop->first ? 'bg-success' : 'bg-secondary' }}">
                                            {{ substr($day, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <h5 class="timeline-day">{{ $day }}</h5>
                                            <p class="timeline-status text-muted">Pendiente</p>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary ml-auto">
                                            Marcar como completado
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/nutritional_plan/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            let currentDayIndex = 0;

            const nutritionData = {!! json_encode($nutritionPlan) !!};
            const exerciseData = {!! json_encode($exercisePlan) !!};

            const updatePlan = () => {
                document.getElementById('currentDayNutrition').innerText = days[currentDayIndex];
                document.getElementById('currentDayExercise').innerText = days[currentDayIndex];

                const nutritionList = document.getElementById('nutritionList');
                nutritionList.innerHTML = '';
                nutritionData[days[currentDayIndex]].forEach(item => {
                    nutritionList.innerHTML += `<li>${item}</li>`;
                });

                const exerciseList = document.getElementById('exerciseList');
                exerciseList.innerHTML = '';
                exerciseData[days[currentDayIndex]].forEach(item => {
                    exerciseList.innerHTML += `<li>${item}</li>`;
                });
            };

            document.getElementById('prevDay').addEventListener('click', () => {
                currentDayIndex = (currentDayIndex - 1 + days.length) % days.length;
                updatePlan();
            });

            document.getElementById('nextDay').addEventListener('click', () => {
                currentDayIndex = (currentDayIndex + 1) % days.length;
                updatePlan();
            });

            updatePlan();
        });
    </script>
@endsection
