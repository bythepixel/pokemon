<?php namespace App\Http\Controllers;

use App\Repositories\PokemonRepository;

class PokemonController extends Controller
{
    public function index(PokemonRepository $pokemonRepository)
    {
        return response()->json($pokemonRepository->all());
    }
}