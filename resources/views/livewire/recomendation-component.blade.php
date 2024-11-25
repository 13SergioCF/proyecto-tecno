@push('css_lib')
    <link rel="stylesheet" href="/css/recomendations/index.css">
@endpush
<div>
    <h2>Bienvenido, {{ auth()->user()->name }}</h2>
    <p>Soy tu guía nutricionista virtual. Aquí recibirás recomendaciones personalizadas basadas en tus respuestas.</p>
    <div wire:loading>
        <p>Generando recomendaciones...</p>
    </div>

    @if ($recommendations)
        <div class="recommendations">
            <h3>Tus Recomendaciones</h3>
            <p id="recommendationText">{!! nl2br($recommendations) !!}</p>
        </div>
    @endif
</div>
@push('scripts_lib')
    <script src="{{ asset('js/recomendations/index.js') }}"></script>
@endpush
