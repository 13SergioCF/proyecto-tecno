    <div class="min-h-screen bg-gradient-to-b from-rose-50 to-teal-50 p-6">
        <div class="max-w-6xl mx-auto">
            <!-- Contenedor de las tarjetas con grid de 3 columnas y máximo 4 filas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-center">
                @if (isset($muscles) && $muscles->count() > 0)
                    <div class="row px-5">
                        @foreach ($muscles->take(12) as $muscle)
                            <div class="col-md-6 form-group mb-3 mx-auto" style="height: 25vh; align-items: center;">
                                <div class="card-muscle p-4 border rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
                                    id="muscle-card-{{ $muscle->id }}" data-selected="false">
                                    <div class="muscle-image">
                                        <img src="{{ $muscle->image_path }}" alt="Ilustración de {{ $muscle->name }}"
                                            class="w-full h-40 object-cover rounded-t-lg" />
                                    </div>
                                    <div class="mt-4">
                                        <h2 class="muscle-title text-xl font-semibold text-gray-800">
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
