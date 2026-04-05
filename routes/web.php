<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingClassController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntrenadorController;

// ─────────────────────────────────────────────────────────────
// RUTAS PÚBLICAS — accesibles sin iniciar sesión
// ─────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);

// ─────────────────────────────────────────────────────────────
// RUTAS AUTENTICADAS — requieren sesión activa
// ─────────────────────────────────────────────────────────────
Route::middleware(function ($request, $next) {
    if (!session('id_usuario')) {
        return redirect()->route('login');
    }
    return $next($request);
})->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Reservas (clientes)
    Route::get('/reservas',                   [ReservationController::class, 'index'])->name('reservas.index');
    Route::post('/reservas',                  [ReservationController::class, 'store'])->name('reservas.store');
    Route::get('/mis-reservas',               [ReservationController::class, 'misReservas'])->name('reservas.mis');
    Route::post('/reservas/{id}/cancelar',    [ReservationController::class, 'cancelar'])->name('reservas.cancelar');

    // ─────────────────────────────────────────────────────────
    // RUTAS DE ADMINISTRACIÓN — requieren sesión + rol admin
    // ─────────────────────────────────────────────────────────
    Route::middleware(function ($request, $next) {
        if (session('rol') !== 'admin') {
            abort(403, 'Acceso restringido a administradores.');
        }
        return $next($request);
    })->group(function () {

        // Usuarios
        Route::get('/usuarios',           [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}',      [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}',   [UserController::class, 'destroy'])->name('usuarios.destroy');

        // Estadísticas
        Route::get('/estadisticas', [DashboardController::class, 'estadisticas'])->name('estadisticas');

        // Clases y horarios
        Route::resource('clases', TrainingClassController::class)->except(['show']);
        Route::resource('clases.horarios', ScheduleController::class)->except(['show']);
    });

    // ─────────────────────────────────────────────────────────
    // RUTAS DE ENTRENADOR — requieren sesión + rol entrenador
    // ─────────────────────────────────────────────────────────
    Route::middleware(function ($request, $next) {
        if (session('rol') !== 'entrenador') {
            abort(403, 'Acceso restringido a entrenadores.');
        }
        return $next($request);
    })->group(function () {

        Route::get('/entrenador/mis-clases',  [EntrenadorController::class, 'misClases'])->name('entrenador.clases');
        Route::get('/entrenador/alumnos',     [EntrenadorController::class, 'alumnos'])->name('entrenador.alumnos');
        Route::get('/entrenador/calendario',  [EntrenadorController::class, 'calendario'])->name('entrenador.calendario');
    Route::get('/set-view-mode/{mode}', function($mode) {
        return back()->withCookie(cookie('view_mode', $mode, 60 * 24 * 30));
    })->name('set-view-mode');
});

