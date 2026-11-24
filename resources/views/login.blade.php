<form action="{{ route('login.procesar') }}" method="POST">

    @csrf

    <label>Usuario</label>
    <input
        type="text"
        name="nom_usuario"
        value="{{ old('nom_usuario') }}"
        required
    >

    <label>Contraseña</label>
    <input
        type="password"
        name="password"
        required
    >

    <button type="submit">
        Iniciar sesión
    </button>

</form>