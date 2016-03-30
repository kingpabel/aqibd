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

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', 'AdminController@index');
        Route::put('/{airData}', 'AdminController@update');
        Route::get('/{airData}/edit', 'AdminController@edit');
        Route::get('/create', 'AdminController@create');
        Route::post('/store', 'AdminController@store');

    });

    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/urban-regeneration', 'HomeController@urbanRegeneration');
    Route::get('/environmental-health', 'HomeController@environmentalHealth');
    Route::get('/digital-dhaka', 'HomeController@digitalDhaka');
//    Route::get('/{name}', 'HomeController@getByAddress');
//    Route::get('/{name}/search', 'HomeController@search');
});
