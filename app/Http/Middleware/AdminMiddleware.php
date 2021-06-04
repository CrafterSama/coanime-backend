<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*if ($request->user()->roles[0]->id == 3 )
        {
            \Alert::warning('Esta Sección es solo Para Usuarios con ciertos Privilegios','Area Restringida');
            return back();
        }*/
        return $next($request);
    }
}
