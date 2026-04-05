@extends('layouts.main')

@section('title', 'Mi Calendario — GYM')

@section('content')
    <h1>Mi calendario de clases</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Clase</th>
            </tr>
        </thead>
        <tbody>
            @forelse($horarios as $h)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }}</td>
                    <td>{{ substr($h->hora_inicio, 0, 5) }}</td>
                    <td>{{ substr($h->hora_fin, 0, 5) }}</td>
                    <td>{{ $h->nombre_clase }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No tienes horarios programados.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
