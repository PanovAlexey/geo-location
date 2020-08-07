<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

/**
 * Interface CoordinatesInterface
 * @package CodeblogPro\GeoLocation\Application\Interfaces
 */
interface CoordinatesInterface
{
    public function getLat(): float;

    public function getLong(): float;
}