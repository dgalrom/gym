@extends('layouts.main')

@section('title', 'Horarios — ' . $clase->nombre)

@section('content')
    <h1>Horarios de: {{ $clase->nombre }}</h1>
    <a href="{{ route('clases.horarios.create', $clase->id) }}">+ Añadir horario</a>
    &nbsp;|&nbsp;
    <a href="{{ route('clases.index') }}">← Volver a clases</a>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora inicio</th>
                <th>Hora fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($horarios as $horario)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                    <td>{{ substr($horario->hora_inicio, 0, 5) }}</td>
                    <td>{{ substr($horario->hora_fin, 0, 5) }}</td>
                    <td>
                        <a href="{{ route('clases.horarios.edit', [$clase->id, $horario->id]) }}">Editar</a>
                        &nbsp;
                        <form method="POST"
                              action="{{ route('clases.horarios.destroy', [$clase->id, $horario->id]) }}"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este horario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay horarios para esta clase.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
