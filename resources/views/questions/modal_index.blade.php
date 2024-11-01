@extends('adminlte::page')

@section('title', 'Dashboard')

<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Bienvenido/a</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Gracias por iniciar sesión por primera vez. Por favor, responde las siguientes preguntas:</p>
                <form id="questionForm">
                    <!-- Pregunta 1 -->
                    <div class="form-group">
                        <label for="question1">¿Cuál es tu nombre?</label>
                        <input type="text" class="form-control" id="question1" name="question1" required>
                    </div>
                    <!-- Pregunta 2 -->
                    <div class="form-group">
                        <label for="question2">¿Cuál es tu edad?</label>
                        <input type="number" class="form-control" id="question2" name="question2" required>
                    </div>
                    <!-- Pregunta 3 -->
                    <div class="form-group">
                        <label for="question3">¿Cuál es tu ocupación?</label>
                        <input type="text" class="form-control" id="question3" name="question3" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="questionForm">Enviar</button>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script src="{{ asset('js/questions/modal_question.js') }}"></script>
@endsection
