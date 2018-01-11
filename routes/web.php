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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index')->middleware('can:list-users');
Route::get('/users/create', 'UserController@create')->middleware('can:create-user');
Route::get('/users/{user}/edit', 'UserController@edit')->middleware('can:edit-user');
Route::post('/users', 'UserController@store')->middleware('can:create-user');
Route::put('/users/{user}', 'UserController@update')->middleware('can:edit-user');
Route::delete('/users/{user}', 'UserController@destroy')->middleware('can:delete-user');

Route::resource('platforms', 'PlatformController');

Route::get('/games/create', 'GameController@create');
Route::get('/games/suggested', 'GameController@suggested')->middleware('can:suggested-games');
Route::get('/games/{game}/edit', 'GameController@edit')->middleware('can:edit-game');
Route::get('/games/{game}/approve', 'GameController@approve')->middleware('can:approve-game');
Route::get('/games/{platform}', 'GameController@index')->middleware('can:approved-games');
Route::post('/games', 'GameController@store');
Route::put('/games/{game}', 'GameController@update')->middleware('can:edit-game');
Route::delete('/games/{game}', 'GameController@destroy')->middleware('can:delete-game');

Route::get('/invites', 'InviteController@index')->middleware('can:list-invites');
Route::get('/invites/create', 'InviteController@create')->middleware('can:create-invite');
Route::get('/invites/{token}/accept', 'InviteController@accept');
Route::post('/invites', 'InviteController@process')->middleware('can:create-invite');
Route::delete('/invites/{invite}', 'InviteController@destroy')->middleware('can:destroy-invite');
