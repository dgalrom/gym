<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases disponibles — GYM</title>
</head>
<body>
    <h1>Clases disponibles</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    @forelse($clases as $clase)
        <h2>{{ $clase->nombre }}</h2>
        <p>{{ $clase->descripcion }}</p>
        <p>Duración: {{ $clase->duracion }} min &nbsp;|&nbsp; Capacidad: {{ $clase->capacidad }} personas</p>

        @if($clase->horarios->isEmpty())
            <p><em>Sin horarios disponibles.</em></p>
        @else
            <table border="1" cellpadding="6">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Plazas libres</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clase->horarios as $horario)
                        @php
                            $reservadas = $horario->reservas()->where('estado','activa')->count();
                            $libres     = $clase->capacidad - $reservadas;
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                            <td>{{ substr($horario->hora_inicio, 0, 5) }}</td>
                            <td>{{ substr($horario->hora_fin, 0, 5) }}</td>
                            <td>{{ $libres > 0 ? $libres : 'Completo' }}</td>
                            <td>
                                @if($libres > 0)
                                    <form method="POST" action="{{ route('reservas.store') }}">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $horario->id }}">
                                        <button type="submit">Reservar</button>
                                    </form>
                                @else
                                    <em>Sin plazas</em>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <hr>
    @empty
        <p>No hay clases disponibles.</p>
    @endforelse
</body>
</html>
