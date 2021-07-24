<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class pengepulMitraOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session('level') == 'proyek'){
            abort(404);
        }
        return $next($request);
    }
}
