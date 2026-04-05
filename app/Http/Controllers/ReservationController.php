<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\TrainingClass;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Clases disponibles con sus horarios (vista del cliente)
    public function index()
    {
        $clases = TrainingClass::with(['horarios' => function ($q) {
            $q->orderBy('fecha')->orderBy('hora_inicio');
        }])->get();

        return view('reservas.index', compact('clases'));
    }

    // Registrar reserva
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $horario = Schedule::with('clase')->findOrFail($request->schedule_id);

        // Control de capacidad: reservas activas en ese horario
        $reservasActivas = Reservation::where('schedule_id', $horario->id)
                                      ->where('estado', 'activa')
                                      ->count();

        if ($reservasActivas >= $horario->clase->capacidad) {
            return back()->with('error', 'No hay plazas disponibles para este horario.');
        }

        // Evitar reserva duplicada del mismo usuario en el mismo horario
        $yaReservado = Reservation::where('schedule_id', $horario->id)
                                  ->where('user_id', session('id_usuario'))
                                  ->where('estado', 'activa')
                                  ->exists();

        if ($yaReservado) {
            return back()->with('error', 'Ya tienes una reserva activa en este horario.');
        }

        Reservation::create([
            'user_id'     => session('id_usuario'),
            'schedule_id' => $horario->id,
            'estado'      => 'activa',
        ]);

        return back()->with('success', 'Reserva realizada correctamente.');
    }

    // Mis reservas
    public function misReservas()
    {
        $reservas = Reservation::with(['horario.clase'])
                               ->where('user_id', session('id_usuario'))
                               ->orderBy('created_at', 'desc')
                               ->get();

        return view('reservas.mis_reservas', compact('reservas'));
    }

    // Cancelar reserva (cambia estado a cancelada)
    public function cancelar(string $id)
    {
        $reserva = Reservation::where('id', $id)
                              ->where('user_id', session('id_usuario'))
                              ->firstOrFail();

        $reserva->update(['estado' => 'cancelada']);

        return back()->with('success', 'Reserva cancelada correctamente.');
    }
}

