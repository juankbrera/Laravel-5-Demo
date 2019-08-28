<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('signup', 'AuthController@signup');

    $router->group(['middleware' => 'auth:api'], function ($router) {
        $router->get('logout', 'AuthController@logout');
        $router->get('user', 'AuthController@user');
    });
});
