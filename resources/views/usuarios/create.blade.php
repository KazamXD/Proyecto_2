
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Registrar usuario - SIGEL</title>

    <link rel="stylesheet"
          href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="mb-4">
        <h1 class="fw-bold">Registrar usuario</h1>
        <p class="text-muted">
            Completa la información del nuevo usuario de SIGEL.
        </p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Revisa los siguientes errores:</strong>

                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                action="{{ route('usuarios.store') }}">
                @csrf

                <div class="row g-3">

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            Nombre
                        </label>

                        <input type="text"
                               name="nombre"
                               id="nombre"
                               class="form-control"
                               value="{{ old('nombre') }}"
                               maxlength="100"
                               required>
                    </div>

                    <!-- Apellido -->
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">
                            Apellido
                        </label>

                        <input type="text"
                               name="apellido"
                               id="apellido"
                               class="form-control"
                               value="{{ old('apellido') }}"
                               maxlength="100"
                               required>
                    </div>

                    <!-- Usuario -->
                    <div class="col-md-6">
                        <label for="nom_usuario" class="form-label">
                            Nombre de usuario
                        </label>

                        <input type="text"
                               name="nom_usuario"
                               id="nom_usuario"
                               class="form-control"
                               value="{{ old('nom_usuario') }}"
                               required>
                    </div>

                    <!-- Correo -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">
                            Correo electrónico
                        </label>

                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    <!-- Rol -->
                    <div class="col-md-6">
                        <label for="rol_id" class="form-label">
                            Rol
                        </label>

                        <select
                            name="rol_id"
                            id="rol_id"
                            class="form-select"
                            required
                        >
                            <option value="">Seleccione un rol</option>

                            @foreach ($roles as $rol)
                                <option
                                    value="{{ $rol->id_rol }}"
                                    @selected(old('rol_id') == $rol->id_rol)
                                >
                                    {{ $rol->nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Contraseña -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Contraseña
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               minlength="10"
                               required>

                        <div class="form-text">
                            Mínimo 10 caracteres.
                        </div>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="col-md-6">
                        <label for="password_confirmation"
                               class="form-label">
                            Confirmar contraseña
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               minlength="10"
                               required>
                    </div>

                </div>

                <div class="d-flex gap-2 mt-4">

                    <!-- Se activará cuando creemos store() -->
                    <button type="submit" class="btn btn-success">
                        Guardar usuario
                    </button>

                    <a href="{{ route('usuarios.index') }}"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
