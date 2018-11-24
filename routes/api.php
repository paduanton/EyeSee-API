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
        Route::put('/', 'API\UsuarioController@update');
        Route::delete('/', 'API\UsuarioController@destroy');

        Route::get('blind/all', 'API\UsuarioController@get_blind');
        Route::get('noblind/all', 'API\UsuarioController@get_noblind');
    });

    Route::prefix('auth')->group(function () {
        Route::get('logout', 'API\UsuarioController@logout');
    });
});

Route::post('register', 'API\AuthController@signup');
Route::post('login', 'API\AuthController@login');
Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('reset', 'PasswordResetController@sendResetLinkEmail');
});