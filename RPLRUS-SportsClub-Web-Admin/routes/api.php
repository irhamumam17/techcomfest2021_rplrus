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

Route::post('/login','UserController@login');
Route::post('/register','UserController@register');
Route::get('/profile/{id}','UserController@profile');
Route::get('/fields/{category}','FieldController@fields');
Route::get('/fieldAll','FieldController@fieldAll');
Route::get('/unavailable/{id}/{date}','BookingController@unavailableTime');
Route::post('/booking','BookingController@store');
Route::get('/bookings/{id}','BookingController@bookings');
Route::post('/match','MatchController@store');
Route::get('/matchs/{id}','MatchController@index');
Route::get('/mymatch/{id}','MatchController@myMatch');
Route::post('/acc/{id}','MatchController@update');
