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

$app->get('pokemon', ['middleware' => 'cors', 'uses' => 'PokemonController@index']);
$app->get('sightings', ['middleware' => 'cors', 'uses' => 'SightingController@index']);
$app->post('sightings', ['middleware' => 'cors', 'uses' => 'SightingController@store']);

$app->get('sightings', 'SightingController@index');
$app->post('sightings', 'SightingController@store');