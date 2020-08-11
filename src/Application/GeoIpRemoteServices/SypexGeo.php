<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoLocation\Application\Models\Coordinates;
use CodeblogPro\GeoLocation\Application\Models\LocationDTO;
use GuzzleHttp;
use Illuminate\Support\Facades\Config;

class SypexGeo extends TemplateOfWorkingWithRemoteServiceApi
{
    protected function prepareRequest(): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            $this->getUrl() . $this->getIpAddress()->getValue(),
            [
                'Accept' => 'application/json'
            ]
        );
    }

    protected function getLocationByResponse(GuzzleHttp\Psr7\Response $response): LocationInterface
    {
        $responseContentJson = $response->getBody()->getContents();
        $responseContent = $this->getContentFromJson($responseContentJson);
        $coordinates = null;

        if (
            (isset($responseContent->city->lat) || isset($responseContent->region->lat) || isset($responseContent->country->lat))
            && (isset($responseContent->city->lon) || isset($responseContent->region->lon) || isset($responseContent->country->lon))
        ) {
            $coordinates = new Coordinates(
                (float)($responseContent->city->lat ?? $responseContent->region->lat ?? $responseContent->country->lat),
                (float)($responseContent->city->lon ?? $responseContent->region->lon ?? $responseContent->country->lon),
            );
        }

        $languagePostfix = 'name_' . $this->getLanguageCode();

        return new LocationDTO(
            $responseContent->country->$languagePostfix ?? '',
            $responseContent->region->$languagePostfix ?? '',
            $responseContent->city->$languagePostfix ?? '',
            $responseContent->city->post ?? '',
            $responseContent->country->iso ?? '',
            $responseContent->region->iso ?? '',
            $coordinates
        );
    }

    protected function getKey(): string
    {
        return 'Token ' . Config('geolocation.sypex.key');
    }

    protected function getUrl(): string
    {
        return Config('geolocation.sypex.url');
    }
}