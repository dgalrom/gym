<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\TrainingClass;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function estadisticas()
    {
        // Totales
        $totalUsuarios = User::count();
        $totalClases   = TrainingClass::count();

        // Clases con más reservas activas (top 5)
        $clasesMasReservadas = TrainingClass::withCount(['horarios as reservas_count' => function ($q) {
                $q->join('reservations', 'schedules.id', '=', 'reservations.schedule_id')
                  ->where('reservations.estado', 'activa');
            }])
            ->orderByDesc('reservas_count')
            ->limit(5)
            ->get();

        // Clientes con más reservas activas (top 5)
        $clientesMasReservas = User::withCount(['reservaciones as reservas_count' => function ($q) {
                $q->where('estado', 'activa');
            }])
            ->where('rol', 'cliente')
            ->orderByDesc('reservas_count')
            ->limit(5)
            ->get();

        // Reservas activas agrupadas por día (últimos 30 días)
        $reservasPorDia = Reservation::select(
                DB::raw('DATE(created_at) as dia'),
                DB::raw('COUNT(*) as total')
            )
            ->where('estado', 'activa')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return view('estadisticas', compact(
            'totalUsuarios',
            'totalClases',
            'clasesMasReservadas',
            'clientesMasReservas',
            'reservasPorDia'
        ));
    }
}

