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
        $query->where('role_id', '!=', 1);
        $users = $query->paginate(5, '*', 'page', $page);

        $payload = [];

        $payload['page'] = $users->currentPage();
        $payload['dataPerPage'] = $users->perPage();
        $payload['totalData'] = $users->total();
        $payload['totalPage'] = ceil($payload['totalData'] / $payload['dataPerPage']);
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
