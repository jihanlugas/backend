<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
    return \Illuminate\Support\Str::random(64);
});

$router->get('/generate', 'AuthController@generate');

$router->group([
    'prefix' => 'api'
], function () use ($router){
    $router->get('/generate', 'AuthController@generate');
    $router->post('login', 'AuthController@login');
    $router->post('authorized', 'AuthController@authorized');
    $router->post('me', 'AuthController@me');
    $router->post('logout', 'AuthController@logout');

    $router->group([
        'prefix' => 'page'
    ], function () use ($router){
        $router->get('/user', 'PageController@user'); // Bebug
        $router->post('/user', 'PageController@user');
    });

    $router->group([
        'prefix' => 'user'
    ], function () use ($router){
        $router->get('/', 'UserController@index');
        $router->get('/form', 'UserController@form');
        $router->post('/form', 'UserController@store');
        $router->put('/form', 'UserController@update');
        $router->delete('/form', 'UserController@destroy');
    });
});
