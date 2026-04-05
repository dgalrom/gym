<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario — GYM</title>
</head>
<body>
    <h1>Editar usuario: {{ $usuario->name }}</h1>
    <a href="{{ route('usuarios.index') }}">← Volver al listado</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
        @csrf
        @method('PUT')

        <label>Nombre:
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required>
        </label><br><br>

        <label>Email:
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required>
        </label><br><br>

        <label>Teléfono:
            <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}">
        </label><br><br>

        <label>Rol:
            <select name="rol" required>
                @foreach(['admin', 'cliente', 'entrenador'] as $rol)
                    <option value="{{ $rol }}"
                        {{ old('rol', $usuario->rol) === $rol ? 'selected' : '' }}>
                        {{ ucfirst($rol) }}
                    </option>
                @endforeach
            </select>
        </label><br><br>

        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
