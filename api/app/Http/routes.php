<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['middleware' => 'jwt.api.auth', 'namespace' => 'App\Http\Controllers'], function() use ($app) {
	$app->get('api', 'ApiController@index');
	$app->get('pokemon', ['uses' => 'PokemonController@index']);
	$app->get('sightings', ['uses' => 'SightingController@index']);
	$app->post('sightings', ['uses' => 'SightingController@store']);
});

$app->get('login', 'AuthenticationController@login');