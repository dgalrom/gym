<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas — GYM</title>
</head>
<body>
    <h1>Mis reservas</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>
    &nbsp;|&nbsp;
    <a href="{{ route('reservas.index') }}">Ver clases disponibles</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Clase</th>
                <th>Fecha</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->horario->clase->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}</td>
                    <td>{{ substr($reserva->horario->hora_inicio, 0, 5) }}</td>
                    <td>{{ substr($reserva->horario->hora_fin, 0, 5) }}</td>
                    <td>{{ ucfirst($reserva->estado) }}</td>
                    <td>
                        @if($reserva->estado === 'activa')
                            <form method="POST" action="{{ route('reservas.cancelar', $reserva->id) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Cancelar esta reserva?')">Cancelar</button>
                            </form>
                        @else
                            <em>—</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No tienes reservas.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
