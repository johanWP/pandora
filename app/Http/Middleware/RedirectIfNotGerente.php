<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RedirectIfNotGerente
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check())
        {
            session()->flash('flash_message_danger', 'El sistema sólo es accesible para usuarios registrados.');
            return redirect('/login');
        } else {
            if (Auth::user()->securityLevel < 40)
            {
                session()->flash('flash_message_danger', 'Usted no tiene permisos para acceder a este página.');
                return redirect('/escritorio');
            }
        }
        return $next($request);
    }
}
