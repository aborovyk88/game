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
Auth::routes();

//home
Route::get('/', 'HomeController@index');

//games
Route::get('/game', 'GameController@index');
Route::get('/game/list', 'GameController@listItems');
Route::post('/game/store', 'GameController@store');

//users info
Route::get('/users', 'UserController@index');
Route::post('/users/get', 'UserController@get');
Route::get('/users/get/{id}', 'UserController@getData');

//users crad
Route::post('/users/delete', 'UserController@delete');
Route::post('/users/create', 'UserController@create');
Route::post('/users/update', 'UserController@update');