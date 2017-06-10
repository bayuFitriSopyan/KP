<?php

use Illuminate\Http\Request;

Route::post('auth/register','AuthController@register');
Route::post('auth/login','AuthController@login');
Route::post('auth/logout','AuthController@logout');
Route::get('user','UserController@users');
Route::get('user/profile','UserController@profile');


