<?php namespace App\Repositories;

use App\Models\Sighting;
use Pokemon\SightingsRequest;

class SightingsRepository extends BaseRepository
{
    public function __construct()
    {
        $this->repository = new Sighting();
    }

    public function findBySightingsRequest(SightingsRequest $sightingsRequest)
    {
        $latitude = $sightingsRequest->getLatitude();
        $longitude = $sightingsRequest->getLongitude();

        $query = Sighting::whereRaw($sightingsRequest->getWithinSql())
            ->orderByRaw("ST_Distance(location,GeomFromText('POINT($latitude $longitude)'))")
            ->with('pokemon');

        if($sightingsRequest->getPokemon() !== null) {
            $query->where('pokemon_id', $sightingsRequest->getPokemon()->id);
        }

        return $query->get();
    }
}