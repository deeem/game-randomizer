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

Route::resource('users', 'UserController');
Route::resource('platforms', 'PlatformController');

Route::get('/games', 'GameController@index');
Route::get('/games/create', 'GameController@create');
Route::get('/games/{game}/edit', 'GameController@edit');
Route::post('/games', 'GameController@store');
Route::put('/games/{game}', 'GameController@update');
Route::delete('/games/{game}', 'GameController@destroy');

Route::get('/games/{platform}', 'GameController@index');

Route::get('/game/{game}/moderate', 'GameController@moderate');
Route::post('/game/{game}/approve', 'GameController@approve');
