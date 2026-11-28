<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de proveedores | SIGEL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .contenedor {
            max-width: 1200px;
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
        <h1>Gestión de proveedores</h1>

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

        @if (in_array('proveedores.crear', $permisos ?? [], true))
            <a href="{{ route('proveedores.create') }}" class="boton nuevo">
                + Nuevo proveedor
            </a>
        @endif

        <form method="GET" action="{{ route('proveedores.index') }}" class="busqueda">
            <input
                type="text"
                name="buscar"
                placeholder="Buscar por nombre, contacto, teléfono o correo..."
                value="{{ $buscar }}"
            >

            <button type="submit">Buscar</button>

            <a href="{{ route('proveedores.index') }}" class="boton limpiar">
                Limpiar
            </a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id_proveedor }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->nombre_contacto ?? 'No registrado' }}</td>
                        <td>{{ $proveedor->telefono ?? 'No registrado' }}</td>
                        <td>{{ $proveedor->email ?? 'No registrado' }}</td>
                        <td>
                            <div class="acciones">
                                @if (in_array('proveedores.editar', $permisos ?? [], true))
                                    <a
                                        href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}"
                                        class="boton editar"
                                    >
                                        Editar
                                    </a>
                                @endif

                                @if (in_array('proveedores.eliminar', $permisos ?? [], true))
                                    <form
                                        method="POST"
                                        action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?');"
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
                        <td colspan="6" class="vacio">
                            No se encontraron proveedores.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="paginacion">
            {{ $proveedores->links() }}
        </div>

        <a href="{{ route('dashboard') }}" class="boton volver">
            Volver al dashboard
        </a>
    </main>
</body>
</html>
