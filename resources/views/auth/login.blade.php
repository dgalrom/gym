<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión — GYM</title>
    <style>
        body { background: #f4f6f9; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 350px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; border: none; background: #ec4899; color: white; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .error { color: #ef4444; font-size: 0.9rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Iniciar sesión</h1>

        @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif

        @if($errors->any())
            <div class="error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $rememberedEmail) }}" placeholder="tu@email.com" required>

            <label>Contraseña:</label>
            <input type="password" name="password" placeholder="••••••••" required>

            <div style="margin: 10px 0;">
                <input type="checkbox" name="remember" id="remember" {{ $rememberedEmail ? 'checked' : '' }}>
                <label for="remember">Recordar email</label>
            </div>

            <button type="submit">Entrar</button>
        </form>

        <p style="margin-top: 20px; font-size: 0.9rem; text-align: center;">
            ¿No tienes cuenta? <a href="{{ route('register') }}" style="color: #8b5cf6;">Regístrate</a>
        </p>
    </div>
</body>
</html>
