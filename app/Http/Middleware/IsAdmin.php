<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       // return $next($request);
        // Verificar si el usuario está autenticado y su idrol es 1
        if (Auth::check() && (Auth::user()->admin == 1 || Auth::user()->admin == 2)) {
            return $next($request); // Continuar con la petición
        }

        return redirect('/');
    }
}
