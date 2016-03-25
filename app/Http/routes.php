<?php

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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'HomeController@index');

    Route::auth();

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', 'AdminController@index');
        Route::get('/create', 'AdminController@create');
        Route::post('/store', 'AdminController@store');

    });

});
