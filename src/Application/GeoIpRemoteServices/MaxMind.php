<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoCoordinates\Coordinates;
use CodeblogPro\GeoLocation\Application\Models\LocationDTO;
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