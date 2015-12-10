<?php

use attend\Http\Controllers\Auth\AuthController;

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::resource('/', 'homeController');
Route::resource('/home', 'homeController');
Route::post('/end', 'homeController@update');


// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');
// Registration routes...


Route::get('register', [
    'middleware' => 'auth',
    'uses' => 'Auth\AuthController@getRegister'
]);
Route::post('register',[
 'middleware' => 'auth',
 'uses' => 'Auth\AuthController@postRegister'
]);

Route::controllers([
    'password' => 'Auth\PasswordController',
]);
