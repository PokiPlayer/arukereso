<?php

use Illuminate\Support\Facades\Route;

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
/**
 * @var Illuminate\Routing\Router $router
 */

Route::namespace('App\Http\Controllers')->prefix('/doc')->group(function() use ($router) {
    $router->get('/', 'OpenApiDocController')->name('open-api-doc');
});

Route::namespace('App\Http\Controllers\Auth')->prefix('/auth')->group(function () use ($router) {
    $router->post('/', 'AuthController')->name('athentication');
});

Route::middleware('auth:sanctum')
    ->prefix('/logout')->namespace('App\Http\Controllers\Auth')->group(function () use ($router) {
        $router->post('/', 'LogoutController')->name('logout');
    });

Route::namespace('App\Http\Controllers')->prefix('/user')->group(function () use ($router) {
    $router->get('/list', 'UserListController')->name('user-list');
});

Route::middleware('auth:sanctum')
    ->prefix('/me')->namespace('App\Http\Controllers\Me')->group(function () use ($router) {
        $router->get('/', 'MeController')->name('me-show');
    });

Route::middleware('auth:sanctum')
    ->prefix('/order')->namespace('App\Http\Controllers\Order')->group(function () use ($router) {
        $router->post('/store', 'OrderStoreController')->name('order-store');
        $router->post('/modify/{id}', 'OrderModifyController')->where('id', '[0-9]+')->middleware('owned.order')->name(
            'order-modify'
        );
        $router->post('/list', 'OrderListController')->name('order-list');
    });

