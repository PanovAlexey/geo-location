<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

interface LocationInterface
{
    public function getCountry(): string;

    public function getRegion(): string;

    public function getCity(): string;

    public function getPostal(): string;

    public function getCountryIso(): string;

    public function getRegionIso(): string;

    public function getCoordinates(): ?CoordinatesInterface;

    public function toArray(): array;
}