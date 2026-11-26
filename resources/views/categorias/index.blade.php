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
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        h1 { margin-top: 0; color: #243b53; }

        .busqueda {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }

        button, .boton {
            display: inline-block;
            padding: 9px 13px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .nuevo { background: #15803d; }
        .limpiar, .volver { background: #64748b; }
        .editar { background: #d97706; }
        .eliminar { background: #dc2626; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th { background: #edf2f7; }

        .vacio {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        .paginacion { margin-top: 20px; }

        .mensaje {
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .exito {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .acciones {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .acciones form { margin: 0; }

        @media (max-width: 750px) {
            .contenedor { overflow-x: auto; }
            .busqueda { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <main class="contenedor">
        <h1>Gestión de categorías</h1>

        @if (session('success'))
            <div class="mensaje exito">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mensaje error">
                {{ session('error') }}
            </div>
        @endif


        @if (in_array('categorias.crear', $permisos ?? [], true))
            <a href="{{ route('categorias.create') }}" class="boton nuevo">
                + Nueva categoría
            </a>
        @endif

        <form method="GET" action="{{ route('categorias.index') }}" class="busqueda">
            <input
                type="text"
                name="buscar"
                placeholder="Buscar categoría..."
                value="{{ $buscar }}"
            >

            <button type="submit">Buscar</button>

            <a href="{{ route('categorias.index') }}" class="boton limpiar">
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
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->categoria_id }}</td>
                        <td>{{ $categoria->categoria_nombre }}</td>
                        <td>{{ $categoria->dias_max_prestamo }}</td>
                        <td>{{ $categoria->equipos_count }}</td>
                        <td>
                            <div class="acciones">
                                @if (in_array('categorias.editar', $permisos ?? [], true))
                                    <a
                                        href="{{ route('categorias.edit', $categoria->categoria_id) }}"
                                        class="boton editar"
                                    >
                                        Editar
                                    </a>
                                @endif

                                @if (in_array('categorias.eliminar', $permisos ?? [], true))
                                    <form
                                        method="POST"
                                        action="{{ route('categorias.destroy', $categoria->categoria_id) }}"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="eliminar">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="vacio">
                            No se encontraron categorías.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="paginacion">
            {{ $categorias->links() }}
        </div>

        <a href="{{ route('dashboard') }}" class="boton volver">
            Volver al dashboard
        </a>
    </main>
</body>
</html>
