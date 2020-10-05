<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoCoordinates\Coordinates;
use CodeblogPro\GeoLocationAddress\Country;
use CodeblogPro\GeoLocationAddress\Location;
use CodeblogPro\GeoLocationAddress\LocationInterface;
use CodeblogPro\GeoLocationAddress\Region;
use GuzzleHttp;

class SypexGeo extends TemplateOfWorkingWithRemoteServiceApi
{
    protected function prepareRequest(IpAddressInterface $ipAddress): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            $this->options->getUrl() . $ipAddress->getValue(),
            [
                'Accept' => 'application/json'
            ]
        );
    }

    protected function getLocationByResponse(
        GuzzleHttp\Psr7\Response $response,
        LanguageInterface $language
    ): LocationInterface {
        $responseContentJson = $response->getBody()->getContents();
        $responseContent = $this->getContentFromJson($responseContentJson);
        $coordinates = null;

        if ((isset($responseContent->city->lat) || isset($responseContent->region->lat) || isset($responseContent->country->lat))
            && (isset($responseContent->city->lon) || isset($responseContent->region->lon) || isset($responseContent->country->lon))
        ) {
            $coordinates = new Coordinates(
                (float)($responseContent->city->lat ?? $responseContent->region->lat ?? $responseContent->country->lat),
                (float)($responseContent->city->lon ?? $responseContent->region->lon ?? $responseContent->country->lon),
            );
        }

        $languagePostfix = 'name_' . $language->getCode();

        return new Location(
            $coordinates,
            new Country($responseContent->country->$languagePostfix ?? '', $responseContent->country->iso ?? ''),
            new Region($responseContent->region->$languagePostfix ?? '', $responseContent->region->iso ?? ''),
            $responseContent->city->$languagePostfix ?? '',
            '',
            $responseContent->city->post ?? '',
        );
    }
}
