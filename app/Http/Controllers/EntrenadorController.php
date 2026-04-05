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

        $alumnosPorClase = [];
        foreach ($clases as $clase) {
            $alumnos = collect();
            foreach ($clase->horarios as $horario) {
                foreach ($horario->reservas as $reserva) {
                    if ($reserva->estado === 'activa' && $reserva->usuario) {
                        $alumnos->put($reserva->usuario->id, $reserva->usuario);
                    }
                }
            }
            $alumnosPorClase[$clase->id] = $alumnos;
        }

        return view('entrenador.alumnos', compact('clases', 'alumnosPorClase'));
    }

    // Calendario: todos los horarios de sus clases ordenados por fecha
    public function calendario()
    {
        $clases = TrainingClass::where('entrenador_id', session('id_usuario'))
                               ->with(['horarios' => fn($q) => $q->orderBy('fecha')->orderBy('hora_inicio')])
                               ->get();

        $horarios = collect();
        foreach ($clases as $clase) {
            foreach ($clase->horarios as $h) {
                $h->nombre_clase = $clase->nombre;
                $horarios->push($h);
            }
        }
        $horarios = $horarios->sortBy('fecha');

        return view('entrenador.calendario', compact('horarios'));
    }
}
