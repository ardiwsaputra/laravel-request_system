<?php

namespace App\Http\Middleware;

use Closure;

class adminMiddleware
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
        if (auth()->check() && $request->user()->role == 'admin'){
            return $next($request);
        }
        return response(view('error.403'), 403);
    }

}
