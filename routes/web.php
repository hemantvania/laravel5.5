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

Route::get('home',function(){
    return view('pages.home');
});

Auth::routes();

//Route::get('/login','UsersController@login')->name('user-login');
//Route::get('/register','UsersController@register')->name('user-register');
//Route::post('register','UsersController@create')->name('user-create');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test','HomeController@test');

Route::get('register-details', 'HomeController@userDetails')->name('userDetails');

Route::post('register-details','HomeController@RegisterDetails');

//Route::name('password.email')->post('password/email', 'Auth\ForgotPasswordController@resetPassword');