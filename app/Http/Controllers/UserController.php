<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Library\Jwt;

use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt');
        $this->middleware('auth:api');
    }



    public function form(){
        $id = request('id');
        $user = User::find($id);
        $payload = [];
        if($user) {
            $payload['form'] = [
                'userId' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'roleId' => $user->role_id,
            ];
        }else{
            $payload['form'] = [
                'userId' => 0,
                'name' => "",
                'email' => "",
                'gender' => "",
                'roleId' => 0,
            ];
        }

        return $this->responseWithoutToken($payload);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->role_id = $request->roleId;
            $user->password = Hash::make('123456');
            $user->save();

            DB::commit();
            return $this->responseWithoutToken();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function update(Request $request){
        die('update');
    }

}
