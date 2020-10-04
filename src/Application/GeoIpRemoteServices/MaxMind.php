<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoCoordinates\Coordinates;
use CodeblogPro\GeoLocationAddress\Country;
use CodeblogPro\GeoLocationAddress\LocationInterface;
use CodeblogPro\GeoLocationAddress\Location;
use CodeblogPro\GeoLocationAddress\Region;
use GuzzleHttp;

class MaxMind extends TemplateOfWorkingWithRemoteServiceApi
{
    protected function prepareRequest(IpAddressInterface $ipAddress): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            $this->options->getUrl() . $ipAddress->getValue(),
            [
                'Authorization' => $this->options->getKey(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
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

        if (isset($responseContent->location->latitude) && isset($responseContent->location->longitude)) {
            $coordinates = new Coordinates(
                (float)$responseContent->location->latitude,
                (float)$responseContent->location->longitude
            );
        }

        $languagePostfix = $language->getCode();
        $firstSubdivision = (empty($responseContent->subdivisions)) ? [] : current($responseContent->subdivisions);

        return new Location(
            $coordinates,
            new Country(
                $responseContent->country->names->$languagePostfix ?? '',
                $responseContent->country->iso_code ?? ''
            ),
            new Region(
                $firstSubdivision->names->$languagePostfix ?? '',
                $this->getRegionIsoCodeByCountryIsoCodeAndRegionCode(
                    $responseContent->country->iso_code ?? '',
                    $firstSubdivision->iso_code ?? ''
                )
            ),
            $responseContent->city->names->$languagePostfix ?? '',
            '',
            $responseContent->postal->code ?? ''
        );
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
