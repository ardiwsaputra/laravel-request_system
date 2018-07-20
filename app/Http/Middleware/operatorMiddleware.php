<?php

namespace App\Http\Middleware;

use Closure;

class operatorMiddleware
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
        if (auth()->check() && $request->user()->role == 'operator' || $request->user()->role == 'admin') {
            return $next($request);
        } else {
            return response(view('error.403'), 403);
        }
    }
}
