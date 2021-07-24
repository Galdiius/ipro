<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class proyekOnly
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
        if(session('level') == 'pengepul'){
            return redirect()->back();
        }else if(session('level') == 'mitra'){
            return redirect()->back();
        }
        return $next($request);
    }
}
