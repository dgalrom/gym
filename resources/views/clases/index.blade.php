@extends('layouts.main')

@section('title', 'Gestión de Clases')

@section('content')
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0;">Gestionar Clases</h1>
            <a href="{{ route('clases.create') }}" class="btn" style="text-decoration: none;">+ Nueva Clase</a>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9fafb; border-radius: 8px;">
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb;">Nombre</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb;">Duración</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb;">Capacidad</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb;">Entrenador</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e5e7eb;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clases as $clase)
                    <tr>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $clase->nombre }}</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $clase->duracion }} min</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $clase->capacidad }} personas</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">{{ $clase->entrenador->name ?? '—' }}</td>
                        <td style="padding: 1rem; border-bottom: 1px solid #f3f4f6;">
                            <a href="{{ route('clases.horarios.index', $clase->id) }}" style="color: var(--brand-secondary); margin-right: 10px;">Ver Horarios</a>
                            <a href="{{ route('clases.edit', $clase->id) }}" style="color: #6b7280; margin-right: 10px;">Editar</a>
                            <form method="POST" action="{{ route('clases.destroy', $clase->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar esta clase?')" 
                                        style="border: none; background: transparent; color: #ef4444; cursor: pointer;">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">No hay clases registradas aún.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
