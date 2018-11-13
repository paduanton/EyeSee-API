<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('api')->group(function () {
    Route::resources([
        'task' => 'NoticiaController'
    ]);
    Route::prefix('user')->group(function () {
        Route::get('get', 'UsuarioController@index');
        Route::put('update', 'UsuarioController@update');
        Route::delete('delete', 'UsuarioController@destroy');
        Route::get('logout', 'Auth\LoginController@userLogout')->name('user.logout');
    });
});