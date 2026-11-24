
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Iniciar sesión - SIGEL</title>

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/bootstrap.min.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/custom.css') }}"
    >
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5 col-xl-4">

            <!-- Tarjeta de login -->
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-body p-4 p-md-5">

                    <!-- Encabezado -->
                    <div class="text-center mb-4">
                        <h1 class="fw-bold text-primary mb-2">
                            SIGEL
                        </h1>

                        <p class="text-muted small">
                            Sistema de Gestión de Préstamo
                            de Equipos de Laboratorio
                        </p>

                        <h4 class="fw-semibold mt-4">
                            Iniciar sesión
                        </h4>
                    </div>

                    <!-- Mensajes de error -->
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('mensaje'))
                        <div class="alert alert-info" role="status">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <!-- Formulario -->
                    <form
                        method="POST"
                        action="{{ route('login.procesar') }}"
                    >
                        @csrf

                        <!-- Usuario -->
                        <div class="mb-3">
                            <label
                                for="nom_usuario"
                                class="form-label"
                            >
                                Nombre de usuario
                            </label>

                            <input
                                type="text"
                                id="nom_usuario"
                                name="nom_usuario"
                                class="form-control"
                                placeholder="Ingresa tu usuario"
                                value="{{ old('nom_usuario') }}"
                                autocomplete="username"
                                required
                            >
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label
                                for="password"
                                class="form-label"
                            >
                                Contraseña
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Ingresa tu contraseña"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <!-- Botón -->
                        <div class="d-grid">
                            <button
                                type="submit"
                                class="btn btn-success btn-lg"
                            >
                                Iniciar sesión
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Pie de página -->
            <p class="text-center text-muted small mt-4">
                SIGEL - Gestión de Equipos de Laboratorio
            </p>

        </div>
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
