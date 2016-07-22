<?php namespace App\Http\Controllers;

use App\Models\Sighting;
use App\Repositories\PokemonRepository;
use App\Repositories\SightingsRepository;
use Illuminate\Http\Request;
use Pokemon\SightingsRequest;

class SightingController extends Controller
{
    public function index(
        Request $request,
        SightingsRepository $sightingsRepository,
        PokemonRepository $pokemonRepository
    )
    {
        $longitude = $request->get('longitude');
        $latitude = $request->get('latitude');
        $distance = $request->get('distance');
        $pokemonId = $request->get('pokemon_id');

        $pokemon = $pokemonId ? $pokemonRepository->find($pokemonId) : null;

        $sightingsRequest = new SightingsRequest($longitude, $latitude, $distance, $pokemon);

        $sightings = $sightingsRepository->findBySightingsRequest($sightingsRequest);

        return response()->json($sightings);
    }

    public function store(Request $request)
    {
        $sighting = Sighting::create($request->all());

        return response()->json($sighting);
    }
}