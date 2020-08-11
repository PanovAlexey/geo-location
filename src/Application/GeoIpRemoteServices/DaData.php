<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoLocation\Application\Models\Coordinates;
use CodeblogPro\GeoLocation\Application\Models\LocationDTO;
use GuzzleHttp;
use Illuminate\Support\Facades\Config;

class DaData extends TemplateOfWorkingWithRemoteServiceApi
{
    protected function prepareRequest(): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            $this->getUrl() . $this->getIpAddress()->getValue(),
            [
                'Authorization' => $this->getKey(),
                'Accept' => 'application/json'
            ]
        );
    }

    protected function getLocationByResponse(GuzzleHttp\Psr7\Response $response): LocationInterface
    {
        $responseContentJson = $response->getBody()->getContents();
        $responseContent = $this->getContentFromJson($responseContentJson);
        $coordinates = null;

        if (isset($responseContent->location->data->geo_lat) && isset($responseContent->location->data->geo_lon)) {
            $coordinates = new Coordinates(
                (float)$responseContent->location->data->geo_lat,
                (float)$responseContent->location->data->geo_lon
            );
        }

        return new LocationDTO(
            $responseContent->location->data->country ?? '',
            $responseContent->location->data->region_with_type ?? '',
            $responseContent->location->data->city ?? '',
            $responseContent->location->data->postal_code ?? '',
            $responseContent->location->data->country_iso_code ?? '',
            $responseContent->location->data->region_iso_code ?? '',
            $coordinates
        );
    }

    protected function getKey(): string
    {
        return 'Token ' . Config('geolocation.dadata.key');
    }

    protected function getUrl(): string
    {
        return Config('geolocation.dadata.url');
    }
}