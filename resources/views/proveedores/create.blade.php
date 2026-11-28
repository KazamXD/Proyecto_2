<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar proveedor | SIGEL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .contenedor {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        h1 { color: #243b53; }

        label {
            display: block;
            margin: 15px 0 7px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: #15803d;
            color: white;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
            font-size: 14px;
        }

        .volver { background: #64748b; }

        .errores {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <main class="contenedor">
        <h1>Registrar proveedor</h1>

        @if ($errors->any())
            <div class="errores">
                <strong>Por favor, revisa los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('proveedores.store') }}" method="POST">
            @csrf

            <label for="nombre">Nombre del proveedor *</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="150"
                value="{{ old('nombre') }}"
                required
            >

            <label for="nombre_contacto">Nombre del contacto</label>
            <input
                type="text"
                id="nombre_contacto"
                name="nombre_contacto"
                maxlength="100"
                value="{{ old('nombre_contacto') }}"
            >

            <label for="telefono">Teléfono</label>
            <input
                type="text"
                id="telefono"
                name="telefono"
                maxlength="30"
                value="{{ old('telefono') }}"
            >

            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="150"
                value="{{ old('email') }}"
            >

            <label for="direccion">Dirección</label>
            <textarea id="direccion" name="direccion">{{ old('direccion') }}</textarea>

            <label for="informacion_general">Información general</label>
            <textarea id="informacion_general" name="informacion_general">{{ old('informacion_general') }}</textarea>

            <button type="submit" class="boton">Guardar proveedor</button>

            <a href="{{ route('proveedores.index') }}" class="boton volver">
                Cancelar
            </a>
        </form>
    </main>
</body>
</html>
