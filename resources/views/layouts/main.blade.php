<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio GYM - @yield('title', 'Inicio')</title>
    <!-- Estilos base para una estética rica según directrices -->
    <style>
        :root {
            --bg-color: #f4f6f9;
            --text-color: #1a1a1a;
            --brand-primary: #ec4899; /* Rosa vibrante */
            --brand-secondary: #8b5cf6; /* Violeta */
        }
        /* Cookie-based preference check (simplified example) */
        body.dark-mode {
            --bg-color: #111827; 
            --text-color: #f9fafb;
        }
        body { background: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; transition: all 0.3s; margin: 0; padding: 20px; }
        nav { background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; }
        nav.dark-mode-nav { background: #1f2937; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: var(--brand-secondary); font-weight: 600; }
        .nav-links a:hover { color: var(--brand-primary); }
        .btn { padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; background: var(--brand-primary); color: white; transition: transform 0.2s; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 2rem; border-left: 5px solid; }
        .alert-success { background: #dcfce7; color: #166534; border-color: #22c55e; }
        .alert-danger { background: #fee2e2; color: #991b1b; border-color: #ef4444; }
    </style>
    @yield('styles')
</head>
<body class="{{ request()->cookie('view_mode') == 'dark' ? 'dark-mode' : '' }}">

    <nav class="{{ request()->cookie('view_mode') == 'dark' ? 'dark-mode-nav' : '' }}">
        <div class="nav-brand">
            <strong>🏋️ GYM SYSTEM</strong>
        </div>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            
            @if(session('rol') === 'admin')
                <a href="{{ route('usuarios.index') }}">Usuarios</a>
                <a href="{{ route('clases.index') }}">Clases</a>
            @elseif(session('rol') === 'entrenador')
                <a href="{{ route('entrenador.clases') }}">Mis Clases</a>
            @else
                <a href="{{ route('reservas.index') }}">Reservar</a>
                <a href="{{ route('reservas.mis') }}">Mis Reservas</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button class="btn" style="background: #374151;">Salir</button>
            </form>

            <!-- Selector de Preferencia de Vista (Cookie) -->
            <a href="{{ route('set-view-mode', request()->cookie('view_mode') == 'dark' ? 'light' : 'dark') }}" 
               style="font-size: 1.2rem; cursor: pointer;">
               {{ request()->cookie('view_mode') == 'dark' ? '☀️' : '🌙' }}
            </a>
        </div>
    </nav>

    <main>
        <!-- Mensajes Flash -->
        @if(session('success'))
            <div class="alert alert-success">✨ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
