<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Dashboard - SIGEL</title>

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/bootstrap.min.css') }}"
    >
</head>
<body>

<div class="d-flex">

    <!-- Menú lateral provisional -->
    <aside
        class="bg-dark text-white p-3"
        style="width: 250px; min-height: 100vh; flex-shrink: 0;"
    >
        <h4>SIGEL</h4>
        <hr>

        <a href="{{ route('dashboard') }}"
           class="btn btn-outline-light w-100 mb-3">
            Dashboard
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="btn btn-danger w-100">
                Cerrar sesión
            </button>
        </form>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-grow-1 p-4">

        <!-- Encabezado -->
        <div class="mb-4">
            <h1 class="fw-bold">Dashboard</h1>
            <p class="text-muted">
                Panel de administración de SIGEL
            </p>
        </div>

        <!-- Bienvenida -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">
                    Bienvenido, {{ $usuario->nombre }}!
                </h3>

                <p class="card-text text-muted">
                    Has iniciado sesión correctamente.
                    Selecciona una opción para comenzar.
                </p>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <h4 class="mb-3">Accesos rápidos</h4>

        <div class="row g-3 mb-4">

            @if ($puedeCrearUsuarios)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text">
                                Registrar nuevos usuarios en el sistema.
                            </p>

                            @if (Route::has('usuarios.create'))
                                <a href="{{ route('usuarios.create') }}"
                                   class="btn btn-primary">
                                    Crear usuario
                                </a>
                            @else
                                <button class="btn btn-primary" disabled>
                                    Próximamente
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($puedeVerEquipos)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Gestión de equipos</h5>
                            <p class="card-text">
                                Consultar, buscar y gestionar los equipos
                                de cómputo registrados.
                            </p>

                            <a href="{{ route('equipos.index') }}"
                               class="btn btn-success">
                                Ir a equipos
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($puedeVerCategorias)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Gestión de categorías</h5>
                            <p class="card-text">
                                Consultar las categorías y los equipos
                                asociados a cada una.
                            </p>

                            <a href="{{ route('categorias.index') }}"
                               class="btn btn-info">
                                Ir a categorías
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($puedeCrearPrestamos)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Préstamos</h5>
                            <p class="card-text">
                                Registrar un nuevo préstamo.
                            </p>

                            @if (Route::has('prestamos.create'))
                                <a href="{{ route('prestamos.create') }}"
                                   class="btn btn-warning">
                                    Nuevo préstamo
                                </a>
                            @else
                                <button class="btn btn-warning" disabled>
                                    Próximamente
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($puedeCrearSolicitudes)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Solicitudes</h5>
                            <p class="card-text">
                                Solicitar equipos para una fecha determinada.
                            </p>

                            @if (Route::has('solicitudes.create'))
                                <a href="{{ route('solicitudes.create') }}"
                                   class="btn btn-info">
                                    Nueva solicitud
                                </a>
                            @else
                                <button class="btn btn-info" disabled>
                                    Próximamente
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Permisos del usuario -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    Permisos de tu cuenta
                </h5>
            </div>

            <div class="card-body">
                @forelse ($permisos as $permiso)
                    <span class="badge bg-secondary me-1 mb-2">
                        {{ $permiso }}
                    </span>
                @empty
                    <p class="text-muted">
                        No tienes permisos asignados.
                    </p>
                @endforelse
            </div>
        </div>

    </main>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
