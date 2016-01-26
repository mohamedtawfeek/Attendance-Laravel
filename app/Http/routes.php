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
Route::post('/break', 'homeController@BreakTime');
Route::get('/extra', 'extraController@index');
Route::post('/extra', 'extraController@store');
Route::post('/extraEnd', 'extraController@update');
Route::get('/admin', 'adminController@index');
Route::get('/single', 'SingleController@index');
Route::post('/showSingle', 'SingleController@show');
Route::get('/showSingle', 'SingleController@index');
Route::post('/showArchive', 'homeController@Archive');
Route::get('/control', 'adminController@usersShow');
Route::post('/control', 'adminController@userChange');
Route::post('/userDelete', 'adminController@destroyUser');
Route::post('/hoursDelete', 'adminController@destroyHours');
Route::post('/hoursChange', 'adminController@hoursChange');

Route::post('/change', 'adminController@update');
Route::post('/changeExtra', 'adminController@ExtraUpdate');
Route::post('/delete', 'adminController@destroy');
Route::post('/deleteExtra', 'adminController@destroyExtra');

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
