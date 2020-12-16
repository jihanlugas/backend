<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Cookie;

class Controller extends BaseController
{
    public function responseWithToken($payload){
        $newToken = auth()->refresh();
       return response()
           ->json([
               'success' => true,
               'message' => 'Request Success',
               'payload' => $payload,
           ], 200, [
               'Accept' => 'application/json',
               'Content-Type' => 'aplication/json',
               'Access-Control-Allow-Credentials' => true,
//               'Access-Control-Expose-Headers' => 'Set-Cookie',
//               'Set-Cookie' => 'Authorization=' . 'Bearer ' . $newToken,
           ])
           ->withCookie(Cookie::create('Authorization', 'Bearer ' . $newToken, time() * (60 * env('JWT_TTL', 5))))
           ;
    }

    public function responseWithoutToken($payload = []){
//        $newToken = auth()->refresh();
        return response()
            ->json([
                'success' => true,
                'message' => 'Request Success',
                'payload' => $payload,
            ], 200, [
                'Accept' => 'application/json',
                'Content-Type' => 'aplication/json',
                'Access-Control-Allow-Credentials' => true,
//               'Access-Control-Expose-Headers' => 'Set-Cookie',
//               'Set-Cookie' => 'Authorization=' . 'Bearer ' . $newToken,
            ])
//            ->withCookie(Cookie::create('Authorization', 'Bearer ' . $newToken, time() * (60 * 60)))
            ;
    }
}
