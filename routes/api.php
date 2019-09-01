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

// API v1 group
$router->group(['prefix' => 'v1'], function ($router) {

// Auth Routes
    $router->group(['prefix' => 'auth'], function ($router) {
        $router->group(['middleware' => 'guest'], function ($router) {
            $router->post('login', 'AuthController@login')->name('login');
            $router->post('signup', 'AuthController@signup')->name('signup');
        });

        $router->group(['middleware' => 'auth:api'], function ($router) {
            $router->get('logout', 'AuthController@logout')->name('logout');
            $router->get('user', 'AuthController@user')->name('user');
        });
    });

    // Product routes
    $router->group(['prefix' => 'products'], function ($router) {
        $router->get('/', 'ProductsController@index')->name('products');
        $router->get('/show/{product_id}', 'ProductsController@show')->name('products.show');

        $router->group(['middleware' => 'auth:api'], function ($router) {
            $router->post('store', 'ProductsController@store')->name('product.store');
            $router->put('update/{product_id}', 'ProductsController@update')->name('product.update');
            $router->delete('destroy/{product_id}', 'ProductsController@destroy')->name('product.destroy');

            // Like routes
            $router->post('{product_id}/likes/store', 'LikesController@store')->name('like.store');
            $router->delete('{product_id}/likes/destroy', 'LikesController@destroy')->name('like.destroy');
        });
    });

    // Order routes
    $router->group(['prefix' => 'orders'], function ($router) {
        $router->group(['middleware' => 'auth:api'], function ($router) {
            $router->post('store', 'OrdersController@store')->name('order.store');
        });
    });
});
