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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::match(array('GET', 'POST'), 'login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/home', function () {
        return view('home');
    })->name('home');


    Route::group(['middleware' => ['Administrador']], function () {
        Route::get('/rol','RolesController@index');
        Route::get('/rol/select-rol','RolesController@selectRol');
        Route::get('/rol/listado', 'RolesController@listado');
        Route::post('/rol/registrar','RolesController@store');
        Route::put('/rol/actualizar','RolesController@update');
        Route::put('/rol/activar','RolesController@activar');
        Route::put('/rol/desactivar','RolesController@desactivar');

        Route::get('/user','UserController@index');
        Route::get('/user/listado', 'UserController@listUser');
        Route::post('/user/registrar','UserController@store');
        Route::put('/user/actualizar','UserController@update');
        Route::put('/user/activar','UserController@activar');
        Route::put('/user/desactivar','UserController@desactivar');

        Route::post('/categorias', 'CategoriasController@index');

    });


});

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
