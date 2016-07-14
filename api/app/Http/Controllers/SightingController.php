<?php namespace App\Http\Controllers;

use App\Models\Sighting;
use Illuminate\Http\Request;
use Pokemon\SightingsRequest;

class SightingController extends Controller
{
    public function index(Request $request)
    {
        $longitude = $request->get('longitude');
        $latitude = $request->get('latitude');
        $distance = $request->get('distance');

        $sightingsRequest = new SightingsRequest($longitude, $latitude, $distance);

        $sightings = Sighting::whereRaw($sightingsRequest->getWithinSql())->orderByRaw("
            ST_Distance(location,GeomFromText('POINT($latitude $longitude)'))")->with('pokemon')->get();

        return response()->json($sightings);
    }

    public function store(Request $request)
    {
        $sighting = Sighting::create($request->all());

        return response()->json($sighting);
    }
}
