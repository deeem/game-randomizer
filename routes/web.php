<?php

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/list', 'HomeController@list')->name('list');
Route::get('/random/{platform}', 'HomeController@randomizer')->name('randomizer');

/*
 * User routes
 */

Route::get('/users', 'UserController@index')
    ->name('users.index')
    ->middleware('can:list-users');

Route::get('/users/create', 'UserController@create')
    ->name('users.create')
    ->middleware('can:create-user');

Route::get('/users/{user}/edit', 'UserController@edit')
    ->name('users.edit')
    ->middleware('can:edit-user');

Route::post('/users', 'UserController@store')
    ->name('users.store')
    ->middleware('can:create-user');

Route::put('/users/{user}', 'UserController@update')
    ->name('users.update')
    ->middleware('can:edit-user');

Route::delete('/users/{user}', 'UserController@destroy')
    ->name('users.destroy')
    ->middleware('can:delete-user');

/*
 * Platform routes
 */

Route::get('/platforms', 'PlatformController@index')
    ->name('platforms.index')
    ->middleware('can:list-platforms');

Route::post('/platforms', 'PlatformController@store')
    ->name('platforms.store')
    ->middleware('can:create-platform');

Route::get('/platforms/create', 'PlatformController@create')
    ->name('platforms.create')
    ->middleware('can:create-platform');

Route::get('/platforms/{platform}/edit', 'PlatformController@edit')
    ->name('platforms.edit')
    ->middleware('can:edit-platform');

Route::put('/platforms/{platform}', 'PlatformController@update')
    ->name('platforms.update')
    ->middleware('can:edit-platform');

Route::delete('/platforms/{platform}', 'PlatformController@destroy')
    ->name('platforms.destroy')
    ->middleware('can:delete-platform');

/*
 * Game route
 */

Route::get('/games/suggest', 'GameController@create')
    ->name('games.suggest');

Route::get('/games/suggested', 'GameController@suggested')
    ->name('games.suggested')
    ->middleware('can:suggested-games');

Route::get('/games/{game}/edit', 'GameController@edit')
    ->name('games.edit')
    ->middleware('can:edit-game');

Route::get('/games/{game}/approve', 'GameController@approve')
    ->name('games.approve')
    ->middleware('can:approve-game');

Route::delete('/games/{game}/refuse', 'GameController@refuse')
    ->name('games.refuse')
    ->middleware('can:approve-game');

Route::get('/games/{game}/show', 'GameController@show')
    ->name('games.show');

Route::get('/games/{platform}', 'GameController@index')
    ->name('games.index');

Route::post('/games', 'GameController@store')
    ->name('games.store');

Route::put('/games/{game}', 'GameController@update')
    ->name('games.update')
    ->middleware('can:edit-game');

Route::delete('/games/{game}', 'GameController@destroy')
    ->name('games.destroy')
    ->middleware('can:delete-game');

/*
 * Invite routes
 */

Route::get('/invites', 'InviteController@index')
    ->name('invites.index')
    ->middleware('can:list-invites');

Route::get('/invites/create', 'InviteController@create')
    ->name('invites.create')
    ->middleware('can:create-invite');

Route::get('/invites/{token}/accept', 'InviteController@accept')
    ->name('invites.accept');

Route::post('/invites', 'InviteController@process')
    ->name('invites.process')
    ->middleware('can:create-invite');

Route::delete('/invites/{invite}', 'InviteController@destroy')
    ->name('invites.destroy')
    ->middleware('can:destroy-invite');

/*
 * Rule routes
 */

Route::get('/rules', 'RuleController@index')
    ->name('rules.index');

Route::post('/rules', 'RuleController@store')
    ->name('rules.store')
    ->middleware('can:create-rule');

Route::get('/rules/create', 'RuleController@create')
    ->name('rules.create')
    ->middleware('can:create-rule');

Route::get('/rules/{rule}/edit', 'RuleController@edit')
    ->name('rules.edit')
    ->middleware('can:edit-rule');

Route::put('/rules/{rule}', 'RuleController@update')
    ->name('rules.update')
    ->middleware('can:edit-rule');

Route::delete('/rules/{rule}', 'RuleController@destroy')
    ->name('rules.destroy')
    ->middleware('can:delete-rule');
