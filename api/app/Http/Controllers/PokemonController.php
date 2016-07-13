<?php namespace App\Http\Controllers;


use App\Models\Pokemon;

class PokemonController extends Controller
{
    public function index()
    {
        return response()->json(Pokemon::all());
    }
}
