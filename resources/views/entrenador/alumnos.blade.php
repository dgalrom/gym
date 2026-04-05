<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos Inscritos — GYM</title>
</head>
<body>
    <h1>Alumnos inscritos en mis clases</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    @forelse($clases as $clase)
        <h2>{{ $clase->nombre }}</h2>

        @php
            // Recopilar alumnos únicos con reservas activas en cualquier horario de esta clase
            $alumnos = collect();
            foreach ($clase->horarios as $horario) {
                foreach ($horario->reservas as $reserva) {
                    if ($reserva->estado === 'activa' && $reserva->usuario) {
                        $alumnos->put($reserva->usuario->id, $reserva->usuario);
                    }
                }
            }
        @endphp

        @if($alumnos->isEmpty())
            <p><em>Sin alumnos inscritos.</em></p>
        @else
            <table border="1" cellpadding="6">
                <thead>
                    <tr><th>Nombre</th><th>Email</th><th>Teléfono</th></tr>
                </thead>
                <tbody>
                    @foreach($alumnos as $alumno)
                        <tr>
                            <td>{{ $alumno->name }}</td>
                            <td>{{ $alumno->email }}</td>
                            <td>{{ $alumno->telefono ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <hr>
    @empty
        <p>No tienes clases asignadas.</p>
    @endforelse
</body>
</html>
