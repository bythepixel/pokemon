<?php namespace App\Http\Controllers;


use App\Models\Sighting;
use Illuminate\Http\Request;

class SightingController extends Controller
{
    public function index()
    {
        return response()->json(Sighting::all());
    }

    public function store(Request $request)
    {
        $sighting = Sighting::create($request->all());

        return response()->json($sighting);
    }
}
