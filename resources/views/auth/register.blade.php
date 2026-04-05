@extends('layouts.main')

@section('title', 'Registro — GYM')

@section('content')
    <h1>Crear cuenta</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Nombre:
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label><br>

        <label>Email:
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label><br>

        <label>Teléfono:
            <input type="text" name="telefono" value="{{ old('telefono') }}">
        </label><br>

        <label>Contraseña:
            <input type="password" name="password" required>
        </label><br>

        <label>Confirmar contraseña:
            <input type="password" name="password_confirmation" required>
        </label><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
@endsection
