@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/questions/loading.css">
@endsection
<div class="card w-100 max-w-md bg-light shadow">
    <div class="card-header text-center">
        <h5 class="card-title font-weight-bold text-success" id="loading-title">
            Preparando tu Plan de Bienestar
        </h5>
        <p id="loading-subtitle" class="text-muted">
            Optimizando tu dieta y rutina de ejercicios...
        </p>
    </div>
    <div class="card-body">
        <div id="loading-section">
            <div class="progress mb-4" style="height: 20px;">
                <div id="progress-bar" class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                    style="width: 0%;"></div>
            </div>
            <div class="d-flex justify-content-between text-muted">
                <i class="fas fa-apple-alt fs-4"></i>
                <i class="fas fa-dumbbell fs-4"></i>
                <i class="fas fa-carrot fs-4"></i>
                <i class="fas fa-fish fs-4"></i>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script src="{{ asset('js/answers/loading.js') }}"></script>
@endsection
