<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\TrainingClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GymSeeder extends Seeder
{
    public function run(): void
    {
        // ─── ADMINISTRADORES ───────────────────────────────────────────
        $admin = User::create([
            'name'      => 'Admin Principal',
            'email'     => 'admin@gym.com',
            'password'  => Hash::make('password'),
            'telefono'  => '600111222',
            'rol'       => 'admin',
        ]);

        User::create([
            'name'      => 'Supervisor Gym',
            'email'     => 'supervisor@gym.com',
            'password'  => Hash::make('password'),
            'telefono'  => '600111333',
            'rol'       => 'admin',
        ]);

        // ─── ENTRENADORES ──────────────────────────────────────────────
        $entrenadores = [
            ['name' => 'Carlos Pérez',   'email' => 'carlos@gym.com',   'telefono' => '611100001'],
            ['name' => 'Laura Gómez',    'email' => 'laura@gym.com',    'telefono' => '611100002'],
            ['name' => 'Miguel Torres',  'email' => 'miguel@gym.com',   'telefono' => '611100003'],
            ['name' => 'Sofía Ramírez', 'email' => 'sofia@gym.com',    'telefono' => '611100004'],
        ];

        $trainers = [];
        foreach ($entrenadores as $data) {
            $trainers[] = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'telefono' => $data['telefono'],
                'rol'      => 'entrenador',
            ]);
        }

        // ─── CLIENTES ──────────────────────────────────────────────────
        $clientes_data = [
            ['name' => 'Ana Martínez',   'email' => 'ana@gym.com',     'telefono' => '622200001'],
            ['name' => 'Pedro Sánchez',  'email' => 'pedro@gym.com',   'telefono' => '622200002'],
            ['name' => 'Lucía Fernández','email' => 'lucia@gym.com',   'telefono' => '622200003'],
            ['name' => 'Javier López',   'email' => 'javier@gym.com',  'telefono' => '622200004'],
            ['name' => 'Elena Ruiz',     'email' => 'elena@gym.com',   'telefono' => '622200005'],
            ['name' => 'Marcos Gil',     'email' => 'marcos@gym.com',  'telefono' => '622200006'],
            ['name' => 'Carmen Vega',    'email' => 'carmen@gym.com',  'telefono' => '622200007'],
            ['name' => 'Tomás Moreno',   'email' => 'tomas@gym.com',   'telefono' => '622200008'],
        ];

        $clientes = [];
        foreach ($clientes_data as $data) {
            $clientes[] = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'telefono' => $data['telefono'],
                'rol'      => 'cliente',
            ]);
        }

        // ─── CLASES ────────────────────────────────────────────────────
        $clases_data = [
            [
                'nombre'       => 'Yoga Relajante',
                'descripcion'  => 'Clase de yoga enfocada en la relajación y la flexibilidad.',
                'duracion'     => 60,
                'capacidad'    => 15,
                'entrenador'   => $trainers[0],
            ],
            [
                'nombre'       => 'Spinning Intenso',
                'descripcion'  => 'Sesión de ciclismo indoor de alta intensidad para quemar calorías.',
                'duracion'     => 45,
                'capacidad'    => 20,
                'entrenador'   => $trainers[1],
            ],
            [
                'nombre'       => 'Pilates Core',
                'descripcion'  => 'Ejercicios de Pilates centrados en el fortalecimiento del core.',
                'duracion'     => 50,
                'capacidad'    => 12,
                'entrenador'   => $trainers[0],
            ],
            [
                'nombre'       => 'CrossFit',
                'descripcion'  => 'Entrenamiento funcional de alta intensidad con variedad de movimientos.',
                'duracion'     => 60,
                'capacidad'    => 16,
                'entrenador'   => $trainers[2],
            ],
            [
                'nombre'       => 'Zumba',
                'descripcion'  => 'Baile cardio divertido al ritmo de música latina.',
                'duracion'     => 55,
                'capacidad'    => 25,
                'entrenador'   => $trainers[3],
            ],
            [
                'nombre'       => 'Boxeo',
                'descripcion'  => 'Entrenamiento de boxeo para mejorar resistencia y coordinación.',
                'duracion'     => 60,
                'capacidad'    => 10,
                'entrenador'   => $trainers[2],
            ],
        ];

        $clases = [];
        foreach ($clases_data as $data) {
            $clases[] = TrainingClass::create([
                'nombre'       => $data['nombre'],
                'descripcion'  => $data['descripcion'],
                'duracion'     => $data['duracion'],
                'capacidad'    => $data['capacidad'],
                'entrenador_id'=> $data['entrenador']->id,
            ]);
        }

        // ─── HORARIOS ──────────────────────────────────────────────────
        // Horarios para la semana próxima (lunes a sábado)
        $horarios = [];

        // Yoga — lunes y miércoles mañana
        $horarios[] = Schedule::create(['class_id' => $clases[0]->id, 'fecha' => '2026-04-07', 'hora_inicio' => '09:00', 'hora_fin' => '10:00']);
        $horarios[] = Schedule::create(['class_id' => $clases[0]->id, 'fecha' => '2026-04-09', 'hora_inicio' => '09:00', 'hora_fin' => '10:00']);

        // Spinning — martes y jueves mediodía
        $horarios[] = Schedule::create(['class_id' => $clases[1]->id, 'fecha' => '2026-04-08', 'hora_inicio' => '12:00', 'hora_fin' => '12:45']);
        $horarios[] = Schedule::create(['class_id' => $clases[1]->id, 'fecha' => '2026-04-10', 'hora_inicio' => '12:00', 'hora_fin' => '12:45']);

        // Pilates — lunes tarde
        $horarios[] = Schedule::create(['class_id' => $clases[2]->id, 'fecha' => '2026-04-07', 'hora_inicio' => '18:00', 'hora_fin' => '18:50']);

        // CrossFit — miércoles y viernes mañana
        $horarios[] = Schedule::create(['class_id' => $clases[3]->id, 'fecha' => '2026-04-09', 'hora_inicio' => '07:00', 'hora_fin' => '08:00']);
        $horarios[] = Schedule::create(['class_id' => $clases[3]->id, 'fecha' => '2026-04-11', 'hora_inicio' => '07:00', 'hora_fin' => '08:00']);

        // Zumba — jueves tarde y sábado
        $horarios[] = Schedule::create(['class_id' => $clases[4]->id, 'fecha' => '2026-04-10', 'hora_inicio' => '19:00', 'hora_fin' => '19:55']);
        $horarios[] = Schedule::create(['class_id' => $clases[4]->id, 'fecha' => '2026-04-12', 'hora_inicio' => '10:00', 'hora_fin' => '10:55']);

        // Boxeo — martes noche
        $horarios[] = Schedule::create(['class_id' => $clases[5]->id, 'fecha' => '2026-04-08', 'hora_inicio' => '20:00', 'hora_fin' => '21:00']);

        // ─── RESERVAS ──────────────────────────────────────────────────
        // Algunos clientes reservan horarios distintos
        $reservas = [
            ['user' => $clientes[0], 'horario' => $horarios[0], 'estado' => 'activa'],
            ['user' => $clientes[0], 'horario' => $horarios[2], 'estado' => 'activa'],
            ['user' => $clientes[1], 'horario' => $horarios[1], 'estado' => 'activa'],
            ['user' => $clientes[1], 'horario' => $horarios[5], 'estado' => 'cancelada'],
            ['user' => $clientes[2], 'horario' => $horarios[4], 'estado' => 'activa'],
            ['user' => $clientes[3], 'horario' => $horarios[3], 'estado' => 'activa'],
            ['user' => $clientes[3], 'horario' => $horarios[7], 'estado' => 'activa'],
            ['user' => $clientes[4], 'horario' => $horarios[9], 'estado' => 'activa'],
            ['user' => $clientes[5], 'horario' => $horarios[0], 'estado' => 'activa'],
            ['user' => $clientes[6], 'horario' => $horarios[6], 'estado' => 'activa'],
            ['user' => $clientes[7], 'horario' => $horarios[8], 'estado' => 'cancelada'],
        ];

        foreach ($reservas as $r) {
            Reservation::create([
                'user_id'     => $r['user']->id,
                'schedule_id' => $r['horario']->id,
                'estado'      => $r['estado'],
            ]);
        }
    }
}
