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

// Route::apiResource('user', 'API\UserApiController');
Route::get('/users', 'API\UserApiController@index')->name('userapi.all');
Route::post('/user', 'API\UserApiController@store')->name('userapi.store');
Route::post('/user/{id}/edit', 'API\UserApiController@update')->name('userapi.edit');
Route::post('/user/{id}/delete', 'API\UserApiController@destroy')->name('userapi.destroy');

Route::get('/groups', 'API\GroupApiController@index')->name('groupapi.all');
Route::post('/group', 'API\GroupApiController@store')->name('groupapi.store');
Route::post('/group/{id}/edit', 'API\GroupApiController@update')->name('groupapi.edit');
Route::post('/group/{id}/delete', 'API\GroupApiController@destroy')->name('groupapi.destroy');


