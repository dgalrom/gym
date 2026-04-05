@extends('layouts.main')

@section('title', 'Nuevo horario — ' . $clase->nombre)

@section('content')
    <h1>Añadir horario a: {{ $clase->nombre }}</h1>
    <a href="{{ route('clases.horarios.index', $clase->id) }}">← Volver a horarios</a>

    <form method="POST" action="{{ route('clases.horarios.store', $clase->id) }}">
        @csrf

        <label>Fecha:
            <input type="date" name="fecha" value="{{ old('fecha') }}" required>
        </label><br><br>

        <label>Hora inicio:
            <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
        </label><br><br>

        <label>Hora fin:
            <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required>
        </label><br><br>

        <button type="submit">Guardar horario</button>
    </form>
@endsection
