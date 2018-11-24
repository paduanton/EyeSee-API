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


Route::post('auth/login', 'API\AuthController@login');
Route::post('auth/signup', 'API\AuthController@signup');

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
], function () {
    Route::post('auth/password/reset', 'PasswordResetController@sendResetLinkEmail');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth/in',
], function () {

    Route::prefix('user')->group(function () {
        Route::get('logout', 'API\AuthController@logout');
        Route::get('/', function (Request $request) {
            return $request->user();
        });
        Route::put('/', 'API\UsuarioController@update');
        Route::delete('/', 'API\UsuarioController@destroy');
    });

//        all other authorized routes

});

Route::get('user/blind/all', 'API\UsuarioController@get_blind');
Route::get('user/noblind/all', 'API\UsuarioController@get_noblind');