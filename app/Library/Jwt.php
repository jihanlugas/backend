<?php

namespace App\Library;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;

class Jwt {

    protected $currId = 0;

    public static function test()
    {
        return 'rest';
    }

    /**
     * @param  string  $userId
     * @return string
     */

    public function getTokenById(){
        dd($this->currId);
        $user = User::findOrFail($this->currId);

        $headers = [
            'typ' => 'jwt',
            'crt' => strtotime(date("Y-m-d H:i:s")),
            'exp' => strtotime(date("Y-m-d H:i:s", strtotime("+1 hours"))),
        ];
        $payload = [
            'userId' => $user->id,
            'name' => $user->name,
            'roleId' => $user->roleId,
        ];
        $secret = env('JWT_SECRET', '');
        $token =  Jwt::encodeToken($headers, $payload, $secret);


        return $token;
    }


    /**
     * @param  string|array  $payload
     * @param  string|array  $payload
     * @param  string|array  $payload
     * @return string
     */

    public function encodeToken($headers, $payload, $secret){
        return base64_encode(serialize($headers)) . '.' . base64_encode(serialize($payload)) . ',' . base64_encode(serialize($secret));
    }

    /**
     * @param  string $token
     * @return string|array
     */

    public function decodeToken($token){

    }

    public function refresh(){

    }

    public function setUser($userId){
        $this->currId = $userId;
    }

    public function unsetUser(){
        $this->currId = 0;
    }


}

