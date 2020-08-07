<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoLocation\Application\Interfaces\CoordinatesInterface;

class Coordinates implements CoordinatesInterface
{
    private float $lat;
    private float $long;

    public function __construct(float $lat, float $long)
    {
        $this->lat = $lat;
        $this->long = $long;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLong(): float
    {
        return $this->long;
    }
}