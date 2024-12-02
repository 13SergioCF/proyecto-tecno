<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preguntas Médicas</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/questions/loading.css">
    <link rel="stylesheet" href="/css/questions/index.css">
    <link rel="stylesheet" href="/css/questions/button_muscle.css">
    <link rel="stylesheet" href="/css/questions/bols.css">
    <link rel="stylesheet" href="/css/questions/prueba.css">
    <link rel="stylesheet" href="/css/questions/muscles.css">
</head>

<body>
    <div class="content">
        <div class="container overflow-hidden">
            <div class="multisteps-form">
                <br>
                <div class="row">
                    <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
                        <div class="multisteps-form__progress">
                            @foreach (array_chunk($questions->all(), 5) as $index => $chunk)
                                <button class="multisteps-form__progress-btn {{ $index === 0 ? 'js-active' : '' }}"
                                    type="button" title="Paso {{ $index + 1 }}">Preguntas de nutricion</button>
                            @endforeach
                            <button class="multisteps-form__progress-btn" type="button" title="Peso y Talla">Peso y
                                Talla</button>
                            <button class="multisteps-form__progress-btn" type="button"
                                title="Información Médica">Información Médica</button>
                            <button class="multisteps-form__progress-btn" type="button"
                                title="Músculos a Entrenar">Músculos a Entrenar</button>
                            <button class="multisteps-form__progress-btn" type="button"
                                title="Recomendaciones">Recomendaciones</button>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-8 m-auto">
                        <form class="multisteps-form__form" id="answer-form" method="POST">
                            @csrf
                            @foreach (array_chunk($questions->all(), 3) as $index => $chunk)
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white {{ $index === 0 ? 'js-active' : '' }}"
                                    data-animation="slideHorz">
                                    <h3 class="multisteps-form__title">Preguntas nutricionales </h3>
                                    <div class="multisteps-form__content">
                                        @foreach ($chunk as $question)
                                            <div class="form-row mt-1">
                                                <label class="d-block mb-2">{{ $question->contenido }}</label>

                                                @if ($question->formato === 'eleccion_multiple')
                                                    @if ($question->seleccion_multiple === 'si')
                                                        <div class="ml-3">
                                                            @foreach ($question->opciones as $opcion)
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="answers[{{ $question->id }}][]"
                                                                        value="{{ $opcion->id }}"
                                                                        id="option-{{ $opcion->id }}">
                                                                    <label class="form-check-label"
                                                                        for="option-{{ $opcion->id }}">
                                                                        {{ $opcion->texto }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="ml-3">
                                                            @foreach ($question->opciones as $opcion)
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="answers[{{ $question->id }}]"
                                                                        value="{{ $opcion->id }}"
                                                                        id="option-{{ $opcion->id }}">
                                                                    <label class="form-check-label"
                                                                        for="option-{{ $opcion->id }}">
                                                                        {{ $opcion->texto }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @else
                                                    <input class="multisteps-form__input form-control" type="text"
                                                        name="answers[{{ $question->id }}]"
                                                        placeholder="Escribe tu respuesta">
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="button-row d-flex mt-4">
                                            @if ($index > 0)
                                                <button class="btn btn-primary js-btn-prev" type="button"
                                                    title="Prev">Prev</button>
                                            @endif
                                            <button class="btn btn-primary ml-auto js-btn-next" type="button"
                                                title="Next">Next</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz">
                                <h3 class="multisteps-form__title">Información Adicional</h3>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-1">
                                        <label class="d-block mb-2">Peso (kg)</label>
                                        <input class="multisteps-form__input form-control" type="number" step="0.1"
                                            name="peso" placeholder="Ingresa tu peso en kg" required>
                                    </div>
                                    <div class="form-row mt-3">
                                        <label class="d-block mb-2">Talla (m)</label>
                                        <input class="multisteps-form__input form-control" type="number"
                                            step="0.01" name="talla" placeholder="Ingresa tu talla en metros"
                                            required>
                                    </div>
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-primary js-btn-prev" type="button"
                                            title="Prev">Prev</button>
                                        <button class="btn btn-primary ml-auto js-btn-next" type="button"
                                            title="Next">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                data-animation="slideHorz">
                                <h3 class="multisteps-form__title">Información Médica</h3>
                                <div class="multisteps-form__content">
                                    <!-- Pregunta sobre enfermedades -->
                                    <div class="form-group">
                                        <label for="enfermedadBase">¿Tiene alguna enfermedad de base?</label>
                                        <select id="enfermedadBase" name="enfermedadBase" class="form-control"
                                            onchange="toggleInput('enfermedadBase', 'inputEnfermedad')">
                                            <option value="no">No</option>
                                            <option value="si">Sí</option>
                                        </select>
                                    </div>
                                    <div id="inputEnfermedad" class="form-group d-none">
                                        <label for="tipoEnfermedad">Especifique el tipo de enfermedad:</label>
                                        <input type="text" id="tipoEnfermedad" name="tipoEnfermedad"
                                            class="form-control" placeholder="Tipo de enfermedad">
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="alergiaAlimento">¿Tiene alguna alergia a algún alimento?</label>
                                        <select id="alergiaAlimento" name="alergiaAlimento" class="form-control"
                                            onchange="toggleInput('alergiaAlimento', 'inputAlergia')">
                                            <option value="no">No</option>
                                            <option value="si">Sí</option>
                                        </select>
                                    </div>
                                    <div id="inputAlergia" class="form-group d-none">
                                        <label for="tipoAlergia">Especifique el tipo de alergia:</label>
                                        <input type="text" id="tipoAlergia" name="tipoAlergia"
                                            class="form-control" placeholder="Tipo de alergia">
                                    </div>


                                    <!-- Botones de navegación -->
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-primary js-btn-prev" type="button"
                                            title="Prev">Prev</button>
                                        <button class="btn btn-primary ml-auto js-btn-next" type="button"
                                            title="Next">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz"
                                style="width: 100%; height: 800px;">
                                <span class="badge" id="selected-count-badge">
                                    <span id="selected-count" class="selected-count">0</span> seleccionados
                                </span>
                                <h3 class="multisteps-form__title text-center">Músculos a Entrenar</h3>
                                <div class="flex justify-between items-center mb-8"></div>

                                <!-- Aquí está el input oculto -->

                                <div class="multisteps-form__scrollable-content"
                                    style="width: 100%; height: 550px; overflow-y: auto; overflow-x: hidden;">
                                    <div class="min-h-screen bg-gradient-to-b from-rose-50 to-teal-50 p-6">
                                        <div class="max-w-6xl mx-auto">
                                            <!-- Contenedor de las tarjetas con grid de 3 columnas y máximo 4 filas -->
                                            <div
                                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-center">
                                                @if (isset($muscles) && $muscles->count() > 0)
                                                    <div class="row px-5">
                                                        @foreach ($muscles->take(12) as $muscle)
                                                            <div class="col-md-6 form-group mb-3 mx-auto"
                                                                style="height: 30vh; align-items: center;">
                                                                <div class="card-muscle p-4 border rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
                                                                    id="muscle-card-{{ $muscle->id }}"
                                                                    data-selected="false">
                                                                    <input type="checkbox" name="muscles[]"
                                                                        value="{{ $muscle->id }}"
                                                                        id="muscle-{{ $muscle->id }}"
                                                                        class="hidden-checkbox">
                                                                    <div class="muscle-image">
                                                                        <img src="{{ $muscle->image_path }}"
                                                                            alt="Ilustración de {{ $muscle->name }}"
                                                                            class="w-full h-40 object-cover rounded-t-lg" />
                                                                    </div>
                                                                    <div class="mt-4">
                                                                        <h2
                                                                            class="muscle-title text-xl font-semibold text-gray-800">
                                                                            {{ $muscle->nombre }}
                                                                        </h2>
                                                                        <p class="muscle-description text-gray-600"
                                                                            id="muscle-status-{{ $muscle->id }}">
                                                                            Click para seleccionar
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-gray-500">No hay músculos disponibles.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-row d-flex mt-4 w-100 justify-content-between">
                                    <button class="btn btn-primary js-btn-prev" type="button"
                                        title="Prev">Prev</button>
                                    <button id="saveButton" class="btn btn-success ml-auto" type="submit"
                                        title="Guardar">Guardar</button>
                                </div>
                            </div>

                            <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                data-animation="slideHorz">
                                <h3 class="multisteps-form__title text-center">Recomendación de tu ayudante nutricional
                                </h3>
                                <div class="multisteps-form__content d-flex flex-column justify-content-center align-items-center"
                                    style="width: 100%; height: 600px;">
                                    <div id="messageContainer" class="message-container">
                                        <p id="message" style="display: block;"></p>
                                    </div>
                                    <br>
                                    <button id="planGenerate" class="btn btn-success ml-auto" type="submit"
                                        title="Guardar">Generar Plan</button>
                                    <div id="loading" class="col-8" style="display: none;">
                                        <livewire:loading />
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var base_url = "{{ URL::to('/') }}/";
        var _crf = "{{ csrf_token() }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/questions/modal_question.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/utils/SwalHandler.js') }}"></script>
    <script src="{{ asset('js/answers/send_answers.js') }}"></script>
    <script src="{{ asset('js/answers/plan_exercise_generate.js') }}"></script>
    <script src="{{ asset('js/answers/button_muscle.js') }}"></script>
    <script src="{{ asset('js/answers/status_medical.js') }}"></script>
    <script src="{{ asset('js/questions/bols.js') }}"></script>
</body>

</html>
