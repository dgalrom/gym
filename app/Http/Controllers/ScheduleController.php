<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TrainingClass;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Listado de horarios de una clase
    public function index(string $classId)
    {
        $clase    = TrainingClass::findOrFail($classId);
        $horarios = $clase->horarios()->orderBy('fecha')->orderBy('hora_inicio')->get();
        return view('horarios.index', compact('clase', 'horarios'));
    }

    // Formulario para nuevo horario
    public function create(string $classId)
    {
        $clase = TrainingClass::findOrFail($classId);
        return view('horarios.create', compact('clase'));
    }

    // Guardar nuevo horario
    public function store(Request $request, string $classId)
    {
        $clase = TrainingClass::findOrFail($classId);

        $request->validate([
            'fecha'       => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $clase->horarios()->create($request->only(['fecha', 'hora_inicio', 'hora_fin']));

        return redirect()->route('clases.horarios.index', $classId)
                         ->with('success', 'Horario añadido correctamente.');
    }

    // Formulario de edición
    public function edit(string $classId, string $id)
    {
        $clase   = TrainingClass::findOrFail($classId);
        $horario = Schedule::findOrFail($id);
        return view('horarios.edit', compact('clase', 'horario'));
    }

    // Guardar cambios
    public function update(Request $request, string $classId, string $id)
    {
        $horario = Schedule::findOrFail($id);

        $request->validate([
            'fecha'       => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario->update($request->only(['fecha', 'hora_inicio', 'hora_fin']));

        return redirect()->route('clases.horarios.index', $classId)
                         ->with('success', 'Horario actualizado correctamente.');
    }

    // Eliminar horario
    public function destroy(string $classId, string $id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('clases.horarios.index', $classId)
                         ->with('success', 'Horario eliminado correctamente.');
    }
}

