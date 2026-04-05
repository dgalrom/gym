@extends('layouts.main')

@section('title', 'Clases disponibles — GYM')

@section('content')
    <h1>Clases disponibles</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

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
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                            <td>{{ substr($horario->hora_inicio, 0, 5) }}</td>
                            <td>{{ substr($horario->hora_fin, 0, 5) }}</td>
                            <td>{{ $horario->plazas_libres > 0 ? $horario->plazas_libres : 'Completo' }}</td>
                            <td>
                                @if($horario->plazas_libres > 0)
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
@endsection
