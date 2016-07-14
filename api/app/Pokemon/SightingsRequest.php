<?php namespace Pokemon;

class SightingsRequest
{
    private $longitude;

    private $latitude;

    private $boxDistance;

    public function __construct($longitude, $latitude, $boxDistance)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->boxDistance = $boxDistance;
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