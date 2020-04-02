<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Login and Register Route **/
Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

});

// Books Api Routes
Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'middleware' => 'auth.jwt'], function () {

    Route::get('logout', 'AuthController@logout');

    Route::get('books', 'BookController@index');
    Route::get('books/{id}', 'BookController@show');
    Route::post('books', 'BookController@store');
    Route::put('books/{id}', 'BookController@update');
    Route::delete('books/{id}', 'BookController@destroy');
});
