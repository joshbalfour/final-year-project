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

Route::get('crossings', 'CrossingsController@index');
Route::get('crossings/{crossing_id}', 'CrossingsController@get');
Route::get('crossings/{crossing_id}/times', 'CrossingsController@getTimes');
Route::get('crossings/{crossing_id}/image', 'CrossingsController@serveImage');

Route::get('debug', 'DebugController@index');
Route::get('debug/active_trains', 'DebugController@trainLocations');
