@extends('adminlte::page')

@section('title', 'Recommendation')
@section('content')
    <div class="container">
        <h1>Recomendación en JSON</h1>
        <pre>{{ json_encode($recommendationJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
@endsection
