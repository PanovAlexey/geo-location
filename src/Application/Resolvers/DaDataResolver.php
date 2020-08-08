<?php

namespace CodeblogPro\GeoLocation\Application\Resolvers;

use CodeblogPro\GeoLocation\Application\Models\Coordinates;
use CodeblogPro\GeoLocation\Application\Models\LocationDTO;
use GuzzleHttp;
use CodeblogPro\GeoLocation\Application\Exceptions\ConnectException;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;

class DaDataResolver extends Resolver
{
    private string $resultLanguage;
    private string $ip;

    public function __construct(string $resultLanguage, string $ip)
    {
        $this->resultLanguage = $resultLanguage;
        $this->setIp($ip);
    }

    public function getLocation()
    {
        $request = $this->prepareRequest();
        $response = $this->request($request);

        return $this->getLocationByResponse($response);
    }

    private function tryToRequest(GuzzleHttp\Psr7\Request $request): GuzzleHttp\Psr7\Response
    {
        $client = new GuzzleHttp\Client();

        return $client->send($request, ['timeout' => 2]);
    }

    private function request(GuzzleHttp\Psr7\Request $request): GuzzleHttp\Psr7\Response
    {
        try {
            $response = $this->tryToRequest($request);

            if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
                throw new ConnectException('Response statud code = ' . $response->getStatusCode());
            }

            return $response;
        } catch (\Throwable $exception) {
            throw new ConnectException($exception->getMessage());
        }
    }

    private function prepareRequest(): GuzzleHttp\Psr7\Request
    {
        return new GuzzleHttp\Psr7\Request(
            'GET',
            $this->getUrl() . $this->getIp(),
            [
                'Authorization' => $this->getKey(),
                'Accept' => 'application/json'
            ]
        );
    }

    private function getLocationByResponse(GuzzleHttp\Psr7\Response $response)
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

        $location = new LocationDTO(
            $responseContent->location->data->country ?? '',
            $responseContent->location->data->region_with_type ?? '',
            $responseContent->location->data->city ?? '',
            $responseContent->location->data->postal_code ?? '',
            $responseContent->location->data->country_iso_code ?? '',
            $responseContent->location->data->region_iso_code ?? '',
            $coordinates
        );

        return $location;
    }

    private function getContentFromJson(string $contentJson): object
    {
        $content = json_decode($contentJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new IncorrectResponseContent();
        }

        return $content;
    }

    private function setIp(string $ip)
    {
        if (!$this->isIpValid($ip)) {
            throw new IncorrectIpException();
        }

        $this->ip = $ip;
    }

    private function isIpValid(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        return true;
    }

    private function getIp(): string
    {
        return $this->ip;
    }

    private function getKey()
    {
        return 'Token ' . \Illuminate\Support\Facades\Config('geolocation.dadata.key');
    }

    private function getUrl()
    {
        return \Illuminate\Support\Facades\Config('geolocation.dadata.url');
    }
}