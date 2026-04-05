<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Clases — GYM</title>
</head>
<body>
    <h1>Mis clases</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    @forelse($clases as $clase)
        <h2>{{ $clase->nombre }}</h2>
        <p>{{ $clase->descripcion }}</p>
        <p>Duración: {{ $clase->duracion }} min &nbsp;|&nbsp; Capacidad: {{ $clase->capacidad }} personas</p>

        @if($clase->horarios->isEmpty())
            <p><em>Sin horarios asignados.</em></p>
        @else
            <table border="1" cellpadding="6">
                <thead>
                    <tr><th>Fecha</th><th>Inicio</th><th>Fin</th></tr>
                </thead>
                <tbody>
                    @foreach($clase->horarios as $h)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }}</td>
                            <td>{{ substr($h->hora_inicio, 0, 5) }}</td>
                            <td>{{ substr($h->hora_fin, 0, 5) }}</td>
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
