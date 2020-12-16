<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Library\Jwt;

use Symfony\Component\HttpFoundation\Cookie;
//use Illuminate\Support\Facades\Cookie;


class PageController extends Controller
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

    public function user()
    {
        $page = request('page');        // number
        $sort = request('sort');        // Array
        $filters = request('filters');    // Array

        $query = User::query();

//        $query->orderBy('first_name','asc');

//        if(!is_null($filters['role_id'])) {
//            $query->where('role_id','=',$filters['role_id']);
//        }

//        if(!is_null($filters['state_id'])) {
//            $query->whereHas('profile',function($q) use ($filters){
//                return $q->where('state_id','=',$filters['state_id']);
//            });
//        }
//
//        if(!is_null($filters['city_id'])) {
//            $query->whereHas('profile',function($q) use ($filters){
//                return $q->where('city_id','=',$filters['city_id']);
//            });
//        }

        $users = $query->paginate(5, '*', 'page', $page);
        $payload = [];

        $payload['page'] = $users->currentPage();
        $payload['dataPerPage'] = $users->perPage();
        $payload['totalData'] = $users->total();
        foreach ($users as $key => $user){
            $payload['list'][] = [
                'userId' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'roleId' => $user->role_id,
            ];
        }
        return $this->responseWithoutToken($payload);
    }
}
