<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\TrainingClass;

class EntrenadorController extends Controller
{
    // Clases que imparte el entrenador autenticado
    public function misClases()
    {
        $clases = TrainingClass::where('entrenador_id', session('id_usuario'))
                               ->with('horarios')
                               ->get();

        return view('entrenador.mis_clases', compact('clases'));
    }

    // Alumnos inscritos en cualquiera de sus clases
    public function alumnos()
    {
        $clases = TrainingClass::where('entrenador_id', session('id_usuario'))
                               ->with(['horarios.reservas.usuario'])
                               ->get();

        return view('entrenador.alumnos', compact('clases'));
    }

    // Calendario: todos los horarios de sus clases ordenados por fecha
    public function calendario()
    {
        $clases = TrainingClass::where('entrenador_id', session('id_usuario'))
                               ->with(['horarios' => fn($q) => $q->orderBy('fecha')->orderBy('hora_inicio')])
                               ->get();

        return view('entrenador.calendario', compact('clases'));
    }
}
