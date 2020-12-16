<?php

namespace App\Http\Middleware;

use Closure;

class JwtMiddleware
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
        $token = $request->cookie('Authorization');
        $request->headers->set('Authorization', $token);
        return $next($request);
    }
}
