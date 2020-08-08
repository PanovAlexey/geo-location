<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

/**
 * Interface LocationInterface
 * @package CodeblogPro\GeoLocation\Application\Interfaces
 */
interface LocationInterface
{
    public function getCountry(): string;

    public function getRegion(): string;

    public function getCity(): string;

    public function getCoordinates(): ?CoordinatesInterface;
}