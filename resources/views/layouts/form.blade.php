<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preguntas Médicas</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/questions/index.css">
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
                                    type="button" title="Paso {{ $index + 1 }}">Paso {{ $index + 1 }}</button>
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
                            @foreach (array_chunk($questions->all(), 5) as $index => $chunk)
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white {{ $index === 0 ? 'js-active' : '' }}"
                                    data-animation="slideHorz">
                                    <h3 class="multisteps-form__title">Preguntas del Paso {{ $index + 1 }}</h3>
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

                            <!-- Paso final para peso y talla -->
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
                                        <input class="multisteps-form__input form-control" type="number" step="0.01"
                                            name="talla" placeholder="Ingresa tu talla en metros" required>
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
                            {{-- <div class="col-8">
                                <livewire:male-human-body />
                            </div> --}}
                            <!-- Nuevo paso: Músculos a entrenar -->
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz"
                                style="width: 100%; height: 800px;">
                                <h3 class="multisteps-form__title text-center">Músculos a Entrenar</h3>
                                <div class="multisteps-form__content d-flex flex-column justify-content-center align-items-center"
                                    style="width: 100%; height: 600px;">
                                    <!-- Aquí agregamos las tarjetas -->
                                    <div class="row">
                                        @if (isset($muscles) && $muscles->count() > 0)
                                            @foreach ($muscles as $muscle)
                                                <div class="col-md-3 mb-3"> <!-- Cambiado de col-md-4 a col-md-3 -->
                                                    <div class="card muscle-card text-center">
                                                        <div class="card-body" style="width: 150px; height: 150px;">
                                                            <h5 class="card-title">{{ $muscle->nombre }}</h5>
                                                            <input type="checkbox" name="muscles[]"
                                                                value="{{ $muscle->id }}"
                                                                id="muscle-{{ $muscle->id }}">
                                                            <label
                                                                for="muscle-{{ $muscle->id }}">Seleccionar</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No hay músculos disponibles para seleccionar.</p>
                                        @endif
                                    </div>

                                    <!-- Botones de navegación -->
                                    <div class="button-row d-flex mt-4 w-100 justify-content-between">
                                        <button class="btn btn-primary js-btn-prev" type="button"
                                            title="Prev">Prev</button>
                                        <button id="saveButton" class="btn btn-success ml-auto" type="submit"
                                            title="Guardar">Guardar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz"
                                style="width: 100%; height: 800px;">
                                <h3 class="multisteps-form__title text-center">Recomendacion de tu ayudante nutricional</h3>
                                <div class="multisteps-form__content d-flex flex-column justify-content-center align-items-center"
                                    style="width: 100%; height: 600px;">
                                    <!-- Aquí agregamos las tarjetas -->
                                    <div id="messageContainer" class="message-container">
                                        <p id="message"></p>
                                    </div>
                                    <!-- Botones de navegación -->
                                    <div class="button-row d-flex mt-4 w-100 justify-content-between">

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
    {{-- <script src="{{ asset('js/answers/prueba.js') }}"></script> --}}
    <script src="{{ asset('js/questions/bols.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/utils/SwalHandler.js') }}"></script>
    <script src="{{ asset('js/answers/send_answers.js') }}"></script>
    <script src="{{ asset('js/answers/status_medical.js') }}"></script>
</body>

</html>
