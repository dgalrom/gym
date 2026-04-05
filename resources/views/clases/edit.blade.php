<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Clase — GYM</title>
</head>
<body>
    <h1>Editar clase: {{ $clase->nombre }}</h1>
    <a href="{{ route('clases.index') }}">← Volver al listado</a>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clases.update', $clase->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Nombre:
            <input type="text" name="nombre" value="{{ old('nombre', $clase->nombre) }}" required>
        </label><br><br>

        <label>Descripción:<br>
            <textarea name="descripcion" rows="4" cols="40">{{ old('descripcion', $clase->descripcion) }}</textarea>
        </label><br><br>

        <label>Duración (minutos):
            <input type="number" name="duracion" value="{{ old('duracion', $clase->duracion) }}" min="1" required>
        </label><br><br>

        <label>Capacidad (personas):
            <input type="number" name="capacidad" value="{{ old('capacidad', $clase->capacidad) }}" min="1" required>
        </label><br><br>

        <label>Entrenador:
            <select name="entrenador_id" required>
                <option value="">-- Selecciona --</option>
                @foreach($entrenadores as $entrenador)
                    <option value="{{ $entrenador->id }}"
                        {{ old('entrenador_id', $clase->entrenador_id) == $entrenador->id ? 'selected' : '' }}>
                        {{ $entrenador->name }}
                    </option>
                @endforeach
            </select>
        </label><br><br>

        <label>Imagen actual:
            @if($clase->imagen)
                <img src="{{ asset('storage/' . $clase->imagen) }}" width="120"><br>
            @else
                <em>Sin imagen</em><br>
            @endif
        </label>

        <label>Nueva imagen (opcional):
            <input type="file" name="imagen" accept="image/*">
        </label><br><br>

        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
