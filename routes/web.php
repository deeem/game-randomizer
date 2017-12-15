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

Route::get('/add', 'GuestController@create');
Route::post('/store', 'GuestController@store');
Route::get('/posted', 'GuestController@displayPostAdded');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index');
Route::get('/users/create', 'UserController@create');
Route::get('/users/{user}/edit', 'UserController@edit');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@destroy');

Route::get('/platforms', 'PlatformController@index');
Route::get('/platforms/create', 'PlatformController@create');
Route::get('/platforms/{platform}/edit', 'PlatformController@edit');
Route::post('/platforms', 'PlatformController@store');
Route::put('/platforms/{platform}', 'PlatformController@update');
Route::delete('/platforms/{platform}', 'PlatformController@destroy');

Route::get('/games', 'GameController@index');
Route::get('/game/create', 'GameController@create');
Route::post('/game/store', 'GameController@store');
Route::get('/game/{game}/edit', 'GameController@edit');
Route::post('/game/{game}/update', 'GameController@update');
Route::get('/game/{game}/destroy', 'GameController@destroy');
Route::get('/game/{game}/moderate', 'GameController@moderate');
Route::post('/game/{game}/approve', 'GameController@approve');
