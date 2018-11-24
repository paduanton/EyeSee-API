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

Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {

        Route::get('/', function (Request $request) {
            return $request->user();
        });
        Route::put('/', 'UsuarioController@update');
        Route::delete('/', 'UsuarioController@destroy');

        Route::get('blind/all', 'UsuarioController@get_blind');
        Route::get('noblind/all', 'UsuarioController@get_noblind');
    });

    Route::prefix('auth')->group(function () {
        Route::get('logout', 'UsuarioController@logout');
    });
});

Route::post('register', 'RegisterController@register');

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('reset', 'PasswordResetController@sendResetLinkEmail');
});