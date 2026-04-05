@extends('layouts.main')

@section('title', 'Alumnos Inscritos — GYM')

@section('content')
    <h1>Alumnos inscritos en mis clases</h1>
    <a href="{{ route('dashboard') }}">← Volver al panel</a>

    @forelse($clases as $clase)
        <h2>{{ $clase->nombre }}</h2>

        @if($alumnosPorClase[$clase->id]->isEmpty())
            <p><em>Sin alumnos inscritos.</em></p>
        @else
            <table border="1" cellpadding="6">
                <thead>
                    <tr><th>Nombre</th><th>Email</th><th>Teléfono</th></tr>
                </thead>
                <tbody>
                    @foreach($alumnosPorClase[$clase->id] as $alumno)
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
@endsection
