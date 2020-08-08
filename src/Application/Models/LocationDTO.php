<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoLocation\Application\Interfaces\CoordinatesInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;

class LocationDTO implements LocationInterface
{
    private string $country;
    private string $region;
    private string $city;
    private string $postal;
    private string $countryIso;
    private string $regionIso;
    private CoordinatesInterface $coordinates;

    public function __construct(
        string $country,
        string $region,
        string $city,
        string $postal,
        string $countryIso,
        string $regionIso,
        CoordinatesInterface $coordinates
    ) {
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->postal = $postal;
        $this->countryIso = $countryIso;
        $this->regionIso = $regionIso;
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

    public function getPostal(): string
    {
        return $this->postal;
    }

    public function getCountryIso(): string
    {
        return $this->countryIso;
    }

    public function getRegionIso(): string
    {
        return $this->regionIso;
    }

    public function getCoordinates(): CoordinatesInterface
    {
        return $this->coordinates;
    }
}