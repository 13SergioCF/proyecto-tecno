<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/register/form-styles.css') }}">
    <title>Registro Multistep</title>
</head>
<body>
    <div class="container">
        <h2>Registra tu Cuenta de Usuario</h2>
        <p>Llena todos los campos del formulario para avanzar al siguiente paso</p>
        <div class="stepper">
            <div class="step active">
                <div class="circle">1</div>
                <span>Cuenta</span>
            </div>
            <div class="step">
                <div class="circle">2</div>
                <span>Personal</span>
            </div>
            <div class="step">
                <div class="circle">3</div>
                <span>Finalizar</span>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registration-form">
            @csrf

            <!-- Paso 1: Cuenta -->
            <div class="form-step active">
                <h3>Información de la Cuenta</h3>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Ingresa tu correo electrónico">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Ingresa tu contraseña">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Confirma tu contraseña">
                </div>
                <button type="button" class="btn-next">Siguiente</button>
            </div>

            <!-- Paso 2: Información Personal -->
            <div class="form-step">
                <h3>Información Personal</h3>
                <div class="form-group">
                    <label for="name">Nombres</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Ingresa tus nombres">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="apellido_paterno">Apellido Paterno</label>
                    <input id="apellido_paterno" type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required placeholder="Ingresa tu apellido paterno">
                    @error('apellido_paterno')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="apellido_materno">Apellido Materno</label>
                    <input id="apellido_materno" type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" required placeholder="Ingresa tu apellido materno">
                    @error('apellido_materno')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="button" class="btn-prev">Anterior</button>
                <button type="button" class="btn-next">Siguiente</button>
            </div>

            <!-- Paso 3: Finalizar -->
            <div class="form-step">
                <h3>Finalizar Registro</h3>
                <p>Confirma todos tus datos y envía el formulario para completar el registro.</p>
                <div class="form-group">
                    <label for="genero">Género</label>
                    <select id="genero" class="form-control @error('genero') is-invalid @enderror" name="genero" required>
                        <option value="">Selecciona tu género</option>
                        <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('genero')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                    @error('fecha_nacimiento')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="button" class="btn-prev">Anterior</button>
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/register/form-scripts.js') }}"></script>
</body>
</html>
