<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoCoordinates\CoordinatesInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;

class LocationDTO implements LocationInterface
{
    private string $country;
    private string $region;
    private string $city;
    private string $postal;
    private string $countryIso;
    private string $regionIso;
    private ?CoordinatesInterface $coordinates;

    public function __construct(
        string $country,
        string $region,
        string $city,
        string $postal,
        string $countryIso,
        string $regionIso,
        ?CoordinatesInterface $coordinates
    ) {
        $this->country = trim($country);
        $this->region = trim($region);
        $this->city = trim($city);
        $this->postal = trim($postal);
        $this->countryIso = trim($countryIso);
        $this->regionIso = trim($regionIso);
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

    public function getCoordinates(): ?CoordinatesInterface
    {
        return $this->coordinates ?? null;
    }

    public function toArray(): array
    {
        return [
            'city' => $this->getCity(),
            'region' => $this->getRegion(),
            'country' => $this->getCountry(),
            'country_iso' => $this->getCountryIso(),
            'region_iso' => $this->getRegionIso(),
            'postal' => $this->getPostal(),
            'coordinates' => [
                'lat' => (empty($this->getCoordinates())) ? null : $this->getCoordinates()->getLatitude(),
                'long' => (empty($this->getCoordinates())) ? null : $this->getCoordinates()->getLongitude(),
            ]
        ];
    }
}