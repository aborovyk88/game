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
Route::post('/game/store', 'GameController@store');

//users index
Route::get('/users', 'UserController@index');

//users crud
Route::post('/users/get', 'UserController@get');
Route::get('/users/get/{user}', 'UserController@getData');
Route::post('/users/delete/{user}', 'UserController@delete');
Route::post('/users/create', 'UserController@create');
Route::post('/users/update/{user}', 'UserController@update');
Route::resource('user', 'UserController', ['only' => ['getData', 'delete', 'create', 'update']]);