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

Route::get('/password', 'DecryptController@Prueba');
Route::get('/Formulario', function () {
	return view('password');
});

Route::post('/BuscarPass', 'DecryptController@DecryptPass');

Route::post('/SHA256Encrypt', 'DecryptController@SHA256Encrypt');
