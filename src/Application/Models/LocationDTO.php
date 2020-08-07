<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoLocation\Application\Interfaces\CoordinatesInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;

class LocationDTO implements LocationInterface
{
    private string $country;
    private string $region;
    private string $city;
    private CoordinatesInterface $coordinates;

    public function __construct(string $country, string $region, string $city, CoordinatesInterface $coordinates)
    {
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->coordinates = $coordinates;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCoordinates(): CoordinatesInterface
    {
        return $this->coordinates;
    }
}