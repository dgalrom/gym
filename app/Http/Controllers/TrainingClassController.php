<?php

namespace App\Http\Controllers;

use App\Models\TrainingClass;
use App\Models\User;
use Illuminate\Http\Request;

class TrainingClassController extends Controller
{
    public function index()
    {
        $clases = TrainingClass::with('entrenador')->get();
        return view('clases.index', compact('clases'));
    }

    public function create()
    {
        $entrenadores = User::where('rol', 'entrenador')->get();
        return view('clases.create', compact('entrenadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'duracion'      => 'required|integer|min:1',
            'capacidad'     => 'required|integer|min:1',
            'entrenador_id' => 'required|exists:users,id',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        $datos = $request->only(['nombre', 'descripcion', 'duracion', 'capacidad', 'entrenador_id']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('clases', 'public');
        }

        TrainingClass::create($datos);

        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function edit(string $id)
    {
        $clase        = TrainingClass::findOrFail($id);
        $entrenadores = User::where('rol', 'entrenador')->get();
        return view('clases.edit', compact('clase', 'entrenadores'));
    }

    public function update(Request $request, string $id)
    {
        $clase = TrainingClass::findOrFail($id);

        $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'duracion'      => 'required|integer|min:1',
            'capacidad'     => 'required|integer|min:1',
            'entrenador_id' => 'required|exists:users,id',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        $datos = $request->only(['nombre', 'descripcion', 'duracion', 'capacidad', 'entrenador_id']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('clases', 'public');
        }

        $clase->update($datos);

        return redirect()->route('clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        TrainingClass::findOrFail($id)->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente.');
    }
}

