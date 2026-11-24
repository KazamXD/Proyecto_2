<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de categorías | SIGEL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .contenedor {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        h1 {
            margin-top: 0;
            color: #243b53;
        }

        .busqueda {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }

        button, .limpiar {
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }

        .limpiar {
            background: #64748b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #edf2f7;
        }

        .vacio {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        .paginacion {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <main class="contenedor">
        <h1>Gestión de categorías</h1>

        <form method="GET" action="{{ route('categorias.index') }}" class="busqueda">
            <input
                type="text"
                name="buscar"
                placeholder="Buscar categoría..."
                value="{{ $buscar }}"
            >

            <button type="submit">Buscar</button>

            <a href="{{ route('categorias.index') }}" class="limpiar">
                Limpiar
            </a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de categoría</th>
                    <th>Días máximos de préstamo</th>
                    <th>Cantidad de equipos</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->categoria_id }}</td>
                        <td>{{ $categoria->categoria_nombre }}</td>
                        <td>{{ $categoria->dias_max_prestamo }}</td>
                        <td>{{ $categoria->equipos_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="vacio">
                            No se encontraron categorías.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="paginacion">
            {{ $categorias->links() }}
        </div>
    </main>
</body>
</html>
