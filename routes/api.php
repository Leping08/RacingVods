<?php

use \App\Http\Controllers\RacesController;
use \App\Http\Controllers\TracksController;
use \App\Http\Controllers\SeriesController;
use \App\Http\Controllers\SeasonsController;
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
Route::group(['middleware' => ['web', 'auth']], function () {


//Races
/* @see RacesController::index() */
Route::get('/races', 'RacesController@index');

/* @see RacesController::latest() */
Route::get('/races/latest', 'RacesController@latest');

/* @see RacesController::show() */
Route::get('/race/{id}', 'RacesController@show');

/* @see RacesController::store() */
Route::post('/race', 'RacesController@store');


// Tracks
/* @see TracksController::index() */
Route::get('/tracks', 'TracksController@index');

/* @see TracksController::show() */
Route::get('/track/{id}', 'TracksController@show');

/* @see TracksController::races() */
Route::get('/track/{id}/races', 'TracksController@races');

/* @see TracksController::store() */
Route::post('/track', 'TracksController@store');


// Series
/* @see SeriesController::index() */
Route::get('/series', 'SeriesController@index');

/* @see SeriesController::show() */
Route::get('/series/{id}', 'SeriesController@show');


// Seasons
/* @see SeasonsController::index() */
Route::get('/seasons', 'SeasonsController@index');

/* @see SeasonsController::races() */
Route::get('/series/{seriesID}/season/{seasonID}', 'SeasonsController@races');

});