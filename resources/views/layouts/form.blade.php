<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>Preguntas Médicas</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel="stylesheet" href="/css/questions/index.css">
    <link rel="stylesheet" href="/css/questions/bols.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-8 m-auto">
                        <form class="multisteps-form__form" name="answer-form" id="answer-form" class="col-md-8">
                            @csrf
                            @foreach (array_chunk($questions->all(), 5) as $index => $chunk)
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white {{ $index === 0 ? 'js-active' : '' }}"
                                    data-animation="slideHorz">
                                    <h3 id="typing-effect" class="multisteps-form__title">Preguntas del Paso
                                        {{ $index + 1 }}</h3>
                                    <div class="multisteps-form__content">
                                        @foreach ($chunk as $question)
                                            <div class="form-row mt-1">
                                                <label class="d-block mb-2">{{ $question->contenido }}</label>

                                                @if ($question->formato === 'eleccion_multiple')
                                                    @if ($question->seleccion_multiple === 'si')
                                                        <!-- Opciones de selección múltiple con checkboxes -->
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
                                                        <!-- Opciones de selección única con radio buttons -->
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
                                                    <!-- Campo para preguntas de redacción -->
                                                    <input class="multisteps-form__input form-control" type="text"
                                                        name="answers[{{ $question->id }}]"
                                                        placeholder="Escribe tu respuesta" />
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="button-row d-flex mt-4">
                                            @if ($index > 0)
                                                <button class="btn btn-primary js-btn-prev" type="button"
                                                    title="Prev">Prev</button>
                                            @endif
                                            @if ($index < count($questions) / 5 - 1)
                                                <a href="{!! route('questions.index') !!}" class="btn btn-default"><i
                                                        class="fa fa-undo"></i>
                                                    Cancelar</a>
                                                <button class="btn btn-primary ml-auto js-btn-next" type="button"
                                                    title="Next">Next</button>
                                            @else
                                                <button type="submit" class="btn btn-success ml-auto"><i
                                                        class="fas fa-paper-plane"></i> Enviar</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    <script src="{{ asset('js/questions/bols.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/utils/SwalHandler.js') }}"></script>
    <script src="{{ asset('js/answers/send_answers.js') }}"></script>
</body>

</html>
