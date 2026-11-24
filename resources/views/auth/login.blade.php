
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - SIGEL</title>
</head>
<body>

    <h1>Iniciar sesión en SIGEL</h1>

    @if ($errors->any())
        <p style="color: red;">
            {{ $errors->first() }}
        </p>
    @endif

    <form action="{{ route('login.procesar') }}" method="POST">

        @csrf

        <label for="nom_usuario">Usuario:</label>
        <input
            type="text"
            id="nom_usuario"
            name="nom_usuario"
            value="{{ old('nom_usuario') }}"
            required
        >

        <br><br>

        <label for="password">Contraseña:</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">
            Iniciar sesión
        </button>

    </form>

</body>
</html>
