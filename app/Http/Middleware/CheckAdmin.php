<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (session('rol') !== 'admin') {
            abort(403, 'Acceso restringido a administradores.');
        }
        return $next($request);
    }
}
