<div>
    <h1>Recomendación Convertida a JSON</h1>

    <button wire:click="fetchLatestRecommendation">Cargar Última Recomendación</button>

    <div style="margin-top: 20px;">
        @if (!empty($recommendationJson))
            <h2>Recomendación:</h2>
            <pre>{{ json_encode($recommendationJson, JSON_PRETTY_PRINT) }}</pre>
        @else
            <p>No hay recomendaciones para mostrar.</p>
        @endif
    </div>
</div>
