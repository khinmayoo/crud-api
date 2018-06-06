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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'tasks'], function() {
    Route::get('','TaskController@index');

    // get specific task
    Route::get('{id}','TaskController@show');

    // delete a task
    Route::delete('{id}','TaskController@destroy');

    // update existing task
    Route::put('','TaskController@store');

    // create new task
    Route::post('','TaskController@store');
});