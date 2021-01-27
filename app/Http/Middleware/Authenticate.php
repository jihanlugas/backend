<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
//use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Cookie;
use Tymon\JWTAuth\Providers\JWT\Namshi;
class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if ($this->auth->guard($guard)->guest()) {
            return response()
                ->json([
                'error' => true,
                'message' => 'Unauthorized',
                'payload' => [
                    'forceLogout' => true,
                ]], 401, [
                    'Accept' => 'application/json',
                    'Content-Type' => 'aplication/json',
                    'Access-Control-Allow-Credentials' => true,
    //                'Access-Control-Expose-Headers' => 'Set-Cookie',
                ])
                ->withCookie(Cookie::create('Authorization', ''))
                ;
        }
        return $next($request);
    }
}
