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
                <!-- Columna Principal -->
                <div class="col-lg-8 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Plan Semanal</h3>
                        </div>
                        <div class="card-body">
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
                                <!-- Nutrición -->
                                <div class="tab-pane fade show active" id="nutrition" role="tabpanel">
                                    <h4 id="currentDayNutrition">Lunes</h4>
                                    <ul id="nutritionList">
                                        @if (isset($nutritionPlan['Lunes']))
                                            @foreach ($nutritionPlan['Lunes'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        @else
                                            <li>No hay datos de nutrición disponibles para hoy.</li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- Ejercicios -->
                                <div class="tab-pane fade" id="exercise" role="tabpanel">
                                    <h4 id="currentDayExercise">Lunes</h4>
                                    <ul id="exerciseList">
                                        @if (isset($exercisePlan['Lunes']))
                                            @foreach ($exercisePlan['Lunes'] as $exercise)
                                                <li>{{ $exercise }}</li>
                                            @endforeach
                                        @else
                                            <li>No hay datos de ejercicios disponibles para hoy.</li>
                                        @endif
                                    </ul>
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

                    <!-- Línea de Tiempo -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Línea de Tiempo</h3>
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
                                        <button class="btn btn-sm btn-outline-secondary ml-auto mark-completed"
                                            data-day="{{ $day }}">
                                            Marcar como completado
                                        </button>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Secundaria -->
                <div class="col-lg-4 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title">Estadísticas Semanales</h3>
                        </div>
                        <div class="card-body">
                            <p>Calorías Promedio: <strong>{{ $weeklyStats['calories'] ?? '0' }} kcal</strong></p>
                            <p>Ejercicio Total: <strong>{{ $weeklyStats['exerciseHours'] ?? '0' }} horas</strong></p>
                            <p>Días Completados: <strong>{{ $weeklyStats['completedDays'] ?? '0' }}/7</strong></p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title">Consejo del Día</h3>
                        </div>
                        <div class="card-body">
                            <p id="dailyTip">{{ $dailyTips['Lunes'] ?? 'No hay consejos disponibles.' }}</p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Gráfica de Progreso</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h3 class="card-title">Receta Saludable</h3>
                        </div>
                        <div class="card-body">
                            <p>Ensalada de Quinoa y Vegetales</p>
                            <a href="#" class="btn btn-primary">Ver Receta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            let currentDayIndex = 0;

            const nutritionData = @json($nutritionPlan);
            const exerciseData = @json($exercisePlan);
            const dailyTips = @json($dailyTips);

            const updatePlan = () => {
                document.getElementById('currentDayNutrition').innerText = days[currentDayIndex];
                document.getElementById('currentDayExercise').innerText = days[currentDayIndex];
                document.getElementById('dailyTip').innerText = dailyTips[days[currentDayIndex]];

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

            // Gráfica de Progreso
            const ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Calorías', 'Ejercicio (horas)', 'Días Completados'],
                    datasets: [{
                        label: 'Progreso Semanal',
                        data: [
                            {{ $weeklyStats['calories'] }},
                            {{ $weeklyStats['exerciseHours'] }},
                            {{ $weeklyStats['completedDays'] }}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            updatePlan();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

            // Obtener el día actual
            const today = new Date();
            const currentDay = days[today.getDay() - 1]; // Ajustar para que el índice inicie en Lunes

            // Deshabilitar botones que no correspondan al día actual
            document.querySelectorAll('.mark-completed').forEach(button => {
                if (button.dataset.day !== currentDay) {
                    button.disabled = true;
                }
            });

            // Manejar clics en "Marcar como completado"
            document.querySelectorAll('.mark-completed').forEach(button => {
                button.addEventListener('click', function() {
                    const day = this.dataset.day;

                    if (day === currentDay) {
                        // Cambiar el estado visual
                        const eventElement = this.closest('.timeline-event');
                        const statusElement = eventElement.querySelector('.timeline-status');
                        const circleElement = eventElement.querySelector('.timeline-day-circle');

                        statusElement.textContent = 'Completado';
                        statusElement.classList.remove('text-muted');
                        statusElement.classList.add('text-success');
                        circleElement.classList.remove('bg-secondary');
                        circleElement.classList.add('bg-success');

                        this.textContent = 'Completado';
                        this.disabled = true; // Deshabilitar el botón
                    } else {
                        alert('Solo puedes marcar como completado el día actual.');
                    }
                });
            });
        });
    </script>
@endsection
