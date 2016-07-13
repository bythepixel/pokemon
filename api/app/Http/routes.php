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

$app->get('pokemon', 'PokemonController@index');

$app->get('sightings', 'SightingController@index');
$app->post('sightings', 'SightingController@store');