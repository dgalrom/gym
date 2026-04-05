<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEntrenador
{
    public function handle(Request $request, Closure $next)
    {
        if (session('rol') !== 'entrenador') {
            abort(403, 'Acceso restringido a entrenadores.');
        }
        return $next($request);
    }
}
