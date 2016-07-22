<?php namespace Pokemon;

use App\Models\Pokemon;

class SightingsRequest
{
    private $longitude;

    private $latitude;

    private $boxDistance;

    public function __construct($longitude, $latitude, $boxDistance, Pokemon $pokemon = null)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->boxDistance = $boxDistance;
        $this->pokemon = $pokemon;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return Pokemon
     */
    public function getPokemon()
    {
        return $this->pokemon;
    }

    /**
     * @param Pokemon $pokemon
     */
    public function setPokemon($pokemon)
    {
        $this->pokemon = $pokemon;
    }

    public function getWithinSql()
    {
        return sprintf(
            "ST_Within(location, envelope( linestring( point(%s, %s), point(%s, %s))))",
            $this->getLongitudeBound1(),
            $this->getLatitudeBound1(),
            $this->getLongitudeBound2(),
            $this->getLatitudeBound2()
        );
    }

    private function getLongitudeBound1()
    {
        return $this->longitude - $this->boxDistance / abs(cos(deg2rad($this->latitude)) * 69);
    }

    private function getLongitudeBound2()
    {
        return $this->longitude + $this->boxDistance / abs(cos(deg2rad($this->latitude)) * 69);
    }

    private function getLatitudeBound1()
    {
        return $this->latitude - ($this->boxDistance / 69);
    }

    private function getLatitudeBound2()
    {
        return $this->latitude + ($this->boxDistance / 69);
    }
}