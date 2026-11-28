<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar equipo - SIGEL</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="mb-4">
        <h1 class="fw-bold">Editar equipo</h1>
        <p class="text-muted">
            Modifique la información del equipo seleccionado.
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
                action="{{ route('equipos.update', $equipo->id_equipo) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

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
                        value="{{ old('codigo', $equipo->codigo) }}"
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
                                @selected(old('id_categoria', $equipo->id_categoria) == $categoria->categoria_id)
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
                                @selected(old('nombre_estado', $equipo->nombre_estado) == $estado)
                            >
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Fotografía actual
                    </label>

                    @if ($equipo->ruta_imagen)
                        <div class="mb-2">
                            <img
                                src="{{ str_starts_with($equipo->ruta_imagen, 'equipos/') ? asset('storage/' . $equipo->ruta_imagen) : asset($equipo->ruta_imagen) }}"
                                alt="Imagen del equipo {{ $equipo->codigo }}"
                                class="img-thumbnail"
                                style="width: 150px; height: 120px; object-fit: cover;"
                            >
                        </div>
                    @else
                        <p class="text-muted">Este equipo no tiene fotografía.</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label fw-semibold">
                        Cambiar fotografía (opcional)
                    </label>

                    <input
                        type="file"
                        id="imagen"
                        name="imagen"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <div class="form-text">
                        Si no selecciona otra fotografía, se conservará la actual.
                        Formatos permitidos: JPG, JPEG, PNG y WEBP.
                        Tamaño máximo: 2 MB.
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
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
