<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios — GYM</title>
</head>
<body>
    <h1>Usuarios</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->telefono ?? '—' }}</td>
                    <td>{{ ucfirst($usuario->rol) }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}">Editar</a>
                        &nbsp;
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay usuarios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
