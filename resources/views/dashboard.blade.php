@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h1 style="margin-top: 0;">👋 Bienvenido, {{ session('nombre') }}</h1>
        <p style="color: #6b7280;">Rol: <strong style="color: var(--brand-secondary);">{{ strtoupper(session('rol')) }}</strong></p>

        <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 1.5rem 0;">

        @if(session('rol') === 'admin')
            <h3>📋 Panel de Administración</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('usuarios.index') }}" class="btn" style="text-align: center; text-decoration: none;">Gestión de Usuarios</a>
                <a href="{{ route('clases.index') }}" class="btn" style="text-align: center; text-decoration: none;">Gestión de Clases</a>
                <a href="{{ route('estadisticas') }}" class="btn" style="text-align: center; text-decoration: none; background: var(--brand-secondary);">Estadísticas</a>
            </div>
        @elseif(session('rol') === 'entrenador')
            <h3>🏋️ Panel de Entrenador</h3>
            <ul>
                <li><a href="{{ route('entrenador.clases') }}">Clases que imparto</a></li>
                <li><a href="{{ route('entrenador.alumnos') }}">Mis Alumnos</a></li>
            </ul>
        @else
            <h3>👤 Panel de Cliente</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('reservas.index') }}" class="btn" style="text-align: center; text-decoration: none;">Reservar Clases</a>
                <a href="{{ route('reservas.mis') }}" class="btn" style="text-align: center; text-decoration: none; background: #374151;">Ver mis Reservas</a>
            </div>
        @endif
    </div>
@endsection
