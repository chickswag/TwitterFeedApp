<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
Route::resource('/', 'UserController');
Route::get('/user/{post}','UserController@show')->name('user.show');
Route::get('/foo', function () {
    $exitCode = Artisan::call('add:feed');

    //
});

