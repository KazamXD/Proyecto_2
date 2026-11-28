<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Editar usuario - SIGEL</title>

    <link rel="stylesheet"
          href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="mb-4">
        <h1 class="fw-bold">Editar usuario</h1>
        <p class="text-muted">
            Modificar los datos del usuario de SIGEL.
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
                  action="{{ route('usuarios.update', $usuario) }}">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            Nombre
                        </label>

                        <input type="text"
                               id="nombre"
                               name="nombre"
                               class="form-control"
                               value="{{ old('nombre', $usuario->nombre) }}"
                               maxlength="100"
                               required>
                    </div>

                    <!-- Apellido -->
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">
                            Apellido
                        </label>

                        <input type="text"
                               id="apellido"
                               name="apellido"
                               class="form-control"
                               value="{{ old('apellido', $usuario->apellido) }}"
                               maxlength="100"
                               required>
                    </div>

                    <!-- Nombre de usuario -->
                    <div class="col-md-6">
                        <label for="nom_usuario" class="form-label">
                            Nombre de usuario
                        </label>

                        <input type="text"
                               id="nom_usuario"
                               name="nom_usuario"
                               class="form-control"
                               value="{{ old('nom_usuario', $usuario->nom_usuario) }}"
                               maxlength="50"
                               required>
                    </div>

                    <!-- Correo -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">
                            Correo electrónico
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $usuario->email) }}"
                               required>
                    </div>

                    <!-- Rol -->
                    <div class="col-md-6">
                        <label for="rol_id" class="form-label">
                            Rol
                        </label>

                        <select name="rol_id"
                                id="rol_id"
                                class="form-select"
                                required>

                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id_rol }}"
                                    @selected(old('rol_id', $usuario->rol_id) == $rol->id_rol)>
                                    {{ $rol->nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Contraseña nueva -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Nueva contraseña (opcional)
                        </label>

                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               minlength="10">

                        <div class="form-text">
                            Déjala vacía para conservar la contraseña actual.
                        </div>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="col-md-6">
                        <label for="password_confirmation"
                               class="form-label">
                            Confirmar nueva contraseña
                        </label>

                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control">
                    </div>

                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit"
                            class="btn btn-success">
                        Guardar cambios
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

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
