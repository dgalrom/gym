<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Clase — GYM</title>
</head>
<body>
    <h1>Nueva clase</h1>
    <a href="{{ route('clases.index') }}">← Volver al listado</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clases.store') }}" enctype="multipart/form-data">
        @csrf

        <label>Nombre:
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </label><br><br>

        <label>Descripción:<br>
            <textarea name="descripcion" rows="4" cols="40">{{ old('descripcion') }}</textarea>
        </label><br><br>

        <label>Duración (minutos):
            <input type="number" name="duracion" value="{{ old('duracion') }}" min="1" required>
        </label><br><br>

        <label>Capacidad (personas):
            <input type="number" name="capacidad" value="{{ old('capacidad') }}" min="1" required>
        </label><br><br>

        <label>Entrenador:
            <select name="entrenador_id" required>
                <option value="">-- Selecciona --</option>
                @foreach($entrenadores as $entrenador)
                    <option value="{{ $entrenador->id }}"
                        {{ old('entrenador_id') == $entrenador->id ? 'selected' : '' }}>
                        {{ $entrenador->name }}
                    </option>
                @endforeach
            </select>
        </label><br><br>

        <label>Imagen:
            <input type="file" name="imagen" accept="image/*">
        </label><br><br>

        <button type="submit">Crear clase</button>
    </form>
</body>
</html>
