
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Gestión de usuarios - SIGEL</title>

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/bootstrap.min.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/custom.css') }}"
    >
</head>

<body class="bg-light">

<div class="container-fluid py-4 px-3 px-md-5">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>
            <h1 class="fw-bold">
                Gestión de usuarios
            </h1>

            <p class="text-muted">
                Consulta y administración de usuarios de SIGEL.
            </p>
        </div>

        <!-- Se habilitará cuando implementemos crear usuario -->
        <a href="{{ route('usuarios.create') }}"
            class="btn btn-success">
                + Nuevo usuario
        </a>
    </div>

    <!-- Búsqueda -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <form
                method="GET"
                action="{{ route('usuarios.index') }}"
                class="row g-3 align-items-end"
            >

                <div class="col-md-9">
                    <label for="buscar" class="form-label">
                        Buscar usuario
                    </label>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        class="form-control"
                        placeholder="Nombre, usuario o correo"
                        value="{{ $buscar }}"
                    >
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary flex-fill"
                        >
                            Buscar
                        </button>

                        <a
                            href="{{ route('usuarios.index') }}"
                            class="btn btn-outline-secondary flex-fill"
                        >
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Listado -->
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Usuarios registrados
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                 @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <table
                    class="table table-striped table-hover
                           align-middle"
                >
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>

                                <td>
                                    {{ $usuario->nombre }}
                                    {{ $usuario->apellido }}
                                </td>

                                <td>{{ $usuario->nom_usuario }}</td>

                                <td>{{ $usuario->email }}</td>

                                <td>{{ $usuario->rol_id }}</td>

                                <td>
                                    @if ($usuario->activo)
                                        <span class="badge bg-success">
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($puedeEditar)
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                        class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                    @endif

                                    @if ($puedeEliminar && (int) auth()->id() !== (int) $usuario->id)
                                        <form method="POST"
                                            action="{{ route('usuarios.destroy', $usuario) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('¿Seguro que deseas desactivar este usuario?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                            
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted py-4">
                                    No se encontraron usuarios.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                    
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $usuarios->links() }}
            </div>

            <!-- Volver al dashboard -->
            <div class="mt-3">
                <a href="{{ route('dashboard') }}"
                class="btn btn-outline-primary">
                    Volver al dashboard
                </a>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
