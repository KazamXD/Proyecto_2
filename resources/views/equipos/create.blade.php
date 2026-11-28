<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar equipo - SIGEL</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="mb-4">
        <h1 class="fw-bold">Registrar equipo</h1>
        <p class="text-muted">
            Complete los datos para registrar un nuevo equipo en SIGEL.
        </p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-semibold">Información del equipo</h5>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Hay errores en el formulario:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('equipos.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mb-3">
                    <label for="codigo" class="form-label fw-semibold">
                        Código del equipo
                    </label>

                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        class="form-control"
                        maxlength="30"
                        value="{{ old('codigo') }}"
                        placeholder="Ejemplo: LAP006"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="id_categoria" class="form-label fw-semibold">
                        Categoría
                    </label>

                    <select
                        id="id_categoria"
                        name="id_categoria"
                        class="form-select"
                        required
                    >
                        <option value="">Seleccione una categoría</option>

                        @foreach ($categorias as $categoria)
                            <option
                                value="{{ $categoria->categoria_id }}"
                                @selected(old('id_categoria') == $categoria->categoria_id)
                            >
                                {{ $categoria->categoria_nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nombre_estado" class="form-label fw-semibold">
                        Estado del equipo
                    </label>

                    <select
                        id="nombre_estado"
                        name="nombre_estado"
                        class="form-select"
                        required
                    >
                        @foreach (['Disponible', 'Prestado', 'Mantenimiento'] as $estado)
                            <option
                                value="{{ $estado }}"
                                @selected(old('nombre_estado', 'Disponible') == $estado)
                            >
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label fw-semibold">
                        Fotografía del equipo (opcional)
                    </label>

                    <input
                        type="file"
                        id="imagen"
                        name="imagen"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <div class="form-text">
                        Formatos permitidos: JPG, JPEG, PNG y WEBP.
                        Tamaño máximo: 2 MB.
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Registrar equipo
                    </button>

                    <a href="{{ route('equipos.index') }}"
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
