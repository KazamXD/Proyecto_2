<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de equipos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f9;
            color: #333;
        }

        h1 {
            color: #243b55;
        }

        .busqueda {
            margin: 20px 0;
        }

        input {
            padding: 9px;
            width: 280px;
        }

        button, .limpiar {
            padding: 9px 14px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #243b55;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .paginacion {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Gestión de equipos</h1>

    <p>Listado de equipos registrados en el sistema.</p>

    <form method="GET" action="{{ route('equipos.index') }}" class="busqueda">
        <input
            type="text"
            name="buscar"
            placeholder="Buscar por código, estado o categoría"
            value="{{ $buscar }}"
        >

        <button type="submit">Buscar</button>

        <a href="{{ route('equipos.index') }}" class="limpiar">
            Limpiar
        </a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Imagen</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->codigo }}</td>

                    <td>
                        {{ $equipo->categoria?->categoria_nombre ?? 'Sin categoría' }}
                    </td>

                    <td>{{ $equipo->nombre_estado }}</td>

                    <td>
                        @if ($equipo->ruta_imagen)
                            <img
                                src="{{ asset($equipo->ruta_imagen) }}"
                                alt="Imagen del equipo {{ $equipo->codigo }}"
                                width="70"
                            >
                        @else
                            Sin imagen
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No se encontraron equipos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paginacion">
        {{ $equipos->links() }}
    </div>

</body>
</html>
