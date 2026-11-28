<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de equipos - SIGEL</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="bg-light">

<div class="container-fluid py-4 px-3 px-md-5">

    <div class="mb-4">
        <h1 class="fw-bold">Gestión de equipos</h1>
        <p class="text-muted">
            Consulta y administración de los equipos registrados en SIGEL.
        </p>
    </div>

    {{-- Mensajes del sistema --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Registrar equipo --}}
    @if (in_array('equipos.crear', $permisos))
        <div class="mb-3">
            <a href="{{ route('equipos.create') }}" class="btn btn-primary">
                Registrar equipo
            </a>
        </div>
    @endif

    {{-- Búsqueda --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('equipos.index') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-9">
                    <label for="buscar" class="form-label fw-semibold">
                        Buscar equipo
                    </label>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        class="form-control"
                        placeholder="Código, categoría o estado"
                        value="{{ $buscar ?? '' }}"
                    >
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            Buscar
                        </button>

                        <a href="{{ route('equipos.index') }}"
                           class="btn btn-outline-secondary flex-fill">
                            Limpiar
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- Tabla de equipos --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-semibold">Equipos registrados</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-striped table-hover align-middle mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Imagen</th>
                            @if (in_array('equipos.editar', $permisos) ||
                                 in_array('equipos.eliminar', $permisos))
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($equipos as $equipo)

                            <tr>
                                <td class="fw-semibold">
                                    {{ $equipo->codigo }}
                                </td>

                                <td>
                                    {{ $equipo->categoria?->categoria_nombre ?? 'Sin categoría' }}
                                </td>

                                <td>
                                    @php
                                        $claseEstado = match ($equipo->nombre_estado) {
                                            'Disponible' => 'bg-success',
                                            'Prestado' => 'bg-warning text-dark',
                                            'Mantenimiento' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp

                                    <span class="badge {{ $claseEstado }}">
                                        {{ $equipo->nombre_estado }}
                                    </span>
                                </td>

                                <td>
                                    @if ($equipo->ruta_imagen)
                                        <img
                                            src="{{ str_starts_with($equipo->ruta_imagen, 'equipos/') ? asset('storage/' . $equipo->ruta_imagen) : asset($equipo->ruta_imagen) }}"
                                            alt="Imagen del equipo {{ $equipo->codigo }}"
                                            class="img-thumbnail"
                                            style="width: 90px; height: 70px; object-fit: cover;"
                                        >
                                    @else
                                        <span class="text-muted">Sin imagen</span>
                                    @endif
                                </td>

                                @if (in_array('equipos.editar', $permisos) ||
                                     in_array('equipos.eliminar', $permisos))

                                    <td>
                                        <div class="d-flex gap-2">

                                            @if (in_array('equipos.editar', $permisos))
                                                <a
                                                    href="{{ route('equipos.edit', $equipo->id_equipo) }}"
                                                    class="btn btn-sm btn-warning"
                                                >
                                                    Editar
                                                </a>
                                            @endif

                                            @if (in_array('equipos.eliminar', $permisos))
                                                <form
                                                    action="{{ route('equipos.destroy', $equipo->id_equipo) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Está seguro de eliminar este equipo?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>

                                @endif

                            </tr>

                        @empty

                            <tr>
                                <td colspan="{{ (in_array('equipos.editar', $permisos) || in_array('equipos.eliminar', $permisos)) ? 5 : 4 }}"
                                    class="text-center text-muted py-4">
                                    No se encontraron equipos.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            @if ($equipos->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $equipos->links() }}
                </div>
            @endif

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
