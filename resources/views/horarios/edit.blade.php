<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar horario — {{ $clase->nombre }}</title>
</head>
<body>
    <h1>Editar horario de: {{ $clase->nombre }}</h1>
    <a href="{{ route('clases.horarios.index', $clase->id) }}">← Volver a horarios</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clases.horarios.update', [$clase->id, $horario->id]) }}">
        @csrf
        @method('PUT')

        <label>Fecha:
            <input type="date" name="fecha"
                   value="{{ old('fecha', \Carbon\Carbon::parse($horario->fecha)->format('Y-m-d')) }}"
                   required>
        </label><br><br>

        <label>Hora inicio:
            <input type="time" name="hora_inicio"
                   value="{{ old('hora_inicio', substr($horario->hora_inicio, 0, 5)) }}"
                   required>
        </label><br><br>

        <label>Hora fin:
            <input type="time" name="hora_fin"
                   value="{{ old('hora_fin', substr($horario->hora_fin, 0, 5)) }}"
                   required>
        </label><br><br>

        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
