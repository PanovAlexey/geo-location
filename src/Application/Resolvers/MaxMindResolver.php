<?php

namespace CodeblogPro\GeoLocation\Application\Resolvers;

use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoLocation\Application\Models\Coordinates;
use CodeblogPro\GeoLocation\Application\Models\LocationDTO;
use GuzzleHttp;
use Illuminate\Support\Facades\Config;

class MaxMindResolver extends Resolver
{
    protected function prepareRequest(): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            $this->getUrl() . $this->getIpAddress()->getValue(),
            [
                'Authorization' => $this->getKey(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        );
    }

    protected function getLocationByResponse(GuzzleHttp\Psr7\Response $response): LocationInterface
    {
        $responseContentJson = $response->getBody()->getContents();
        $responseContent = $this->getContentFromJson($responseContentJson);
        $coordinates = null;

        if (isset($responseContent->location->latitude) && isset($responseContent->location->longitude)) {
            $coordinates = new Coordinates(
                (float)$responseContent->location->latitude,
                (float)$responseContent->location->longitude
            );
        }

        $languagePostfix = $this->getLanguageCode();
        $firstSubdivision = (empty($responseContent->subdivisions)) ? [] : current($responseContent->subdivisions);

        return new LocationDTO(
            $responseContent->country->names->$languagePostfix ?? '',
            $firstSubdivision->names->$languagePostfix ?? '',
            $responseContent->city->names->$languagePostfix ?? '',
            $responseContent->postal->code ?? '',
            $responseContent->country->iso_code ?? '',
            $this->getRegionIsoCodeByCountryIsoCodeAndRegionCode(
                $responseContent->country->iso_code ?? '',
                $firstSubdivision->iso_code ?? ''
            ),
            $coordinates
        );
    }

    protected function getKey(): string
    {
        return 'Basic ' . Config('geolocation.maxmind.key');
    }

    protected function getUrl(): string
    {
        return Config('geolocation.maxmind.url');
    }

    private function getRegionIsoCodeByCountryIsoCodeAndRegionCode(string $countryIsoCode = '', string $regionCode = ''): string
    {
        $regionIsoCode = $countryIsoCode;

        if (!empty($regionIsoCode)) {
            $regionIsoCode .= '-';
        }

        $regionIsoCode .= $regionCode;

        return $regionIsoCode;
    }
}