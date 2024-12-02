@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>contato Administration</h1>
@stop

@section('content')
    <p>contacto Management</p>
    <div class="card">
        <div class="card-body">
            <header>
                <h1></h1>
            </header>
            <main>
                <form action="{{ route('contacto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- With label, invalid feedback disabled, and form group class --}}
                    <div class="row">
                        <x-adminlte-input name="asunto" id="asunto" label="Asunto" placeholder="Ingrese el asunto"
                            fgroup-class="col-md-6" disable-feedback /> <br><br>

                        @error('asunto')
                            <small style="color: red">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="row">
                        <x-adminlte-input name="nombre" id="nombre" label="Nombre" placeholder="Ingrese el Nombre"
                            fgroup-class="col-md-6" disable-feedback />
                        @error('nombre')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <x-adminlte-input name="correo_remitente" id="correo_remitente" label="Ingrese su correo"
                            placeholder="Ingrese su correo" fgroup-class="col-md-6" disable-feedback />
                        @error('correo_remitente')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <x-adminlte-input name="correo_destino" id="correo_destino" label="Correo destinno"
                            placeholder="Ingrese su correo" fgroup-class="col-md-6" disable-feedback 
                            value="{{ old('correo_destino', 'correo@defecto.com') }}" />
                        @error('correo_destino')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>



                    <div class="col-md-6">
                        {{-- With prepend slot, sm size, and label --}}
                        <x-adminlte-textarea name="mensaje" id="mensaje" label="mensaje" rows=5 label-class="text-warning"
                            igroup-size="sm" placeholder="Escriba el mensaje...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-lg fa-file-alt text-warning"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>

                        {{-- Placeholder, sm size, and prepend icon --}}
                        <x-adminlte-input-file name="adjunto" id="adjunto"  label="Adjunto" igroup-size="sm" placeholder="Choose a file...">
                            <x-slot name="prependSlot">
                                <div class="input-group-texst bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>

                        @error('mensaje')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <x-adminlte-button class="btn-flat" type="submit" label="Enviar" theme="primary"
                            icon="fas fa-lg fa-envelope" />
                    </div>
                </form>
                @if (Session::has('info'))
                    <strong>Enviado! {{ Session::get('info') }}</strong>
                @endif
            </main>

        </div>
    </div>
@stop
@section('js')

    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>

@stop
