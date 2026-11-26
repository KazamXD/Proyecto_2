<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar categoría | SIGEL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .contenedor {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        h1 { color: #243b53; }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button, .volver {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 16px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }

        .volver { background: #64748b; }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 5px;
        }

        .errores {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <main class="contenedor">
        <h1>Editar categoría</h1>

        @if ($errors->any())
            <div class="errores">
                <strong>Revisa los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categorias.update', $categoria->categoria_id) }}">
            @csrf
            @method('PUT')

            <label for="categoria_nombre">Nombre de la categoría</label>
            <input
                type="text"
                id="categoria_nombre"
                name="categoria_nombre"
                maxlength="50"
                value="{{ old('categoria_nombre', $categoria->categoria_nombre) }}"
                required
            >

            @error('categoria_nombre')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="dias_max_prestamo">Días máximos de préstamo</label>
            <input
                type="number"
                id="dias_max_prestamo"
                name="dias_max_prestamo"
                min="1"
                value="{{ old('dias_max_prestamo', $categoria->dias_max_prestamo) }}"
                required
            >

            @error('dias_max_prestamo')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Actualizar categoría</button>

            <a href="{{ route('categorias.index') }}" class="volver">
                Volver
            </a>
        </form>
    </main>
</body>
</html>
