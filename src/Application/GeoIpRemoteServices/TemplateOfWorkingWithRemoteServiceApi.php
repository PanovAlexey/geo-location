<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Exceptions\ConnectException;
use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use GuzzleHttp;

abstract class TemplateOfWorkingWithRemoteServiceApi
{
    protected LanguageInterface $language;
    protected IpAddressInterface $ipAddress;

    abstract protected function getKey(): string;

    abstract protected function getUrl(): string;

    public function __construct(IpAddressInterface $ipAddress, LanguageInterface $language)
    {
        $this->ipAddress = $ipAddress;
        $this->language = $language;
    }

    public function getLocation(): LocationInterface
    {
        $request = $this->prepareRequest();
        $response = $this->request($request);

        return $this->getLocationByResponse($response);
    }

    public function getLanguageCode(): string
    {
        return $this->language->getCode();
    }

    protected function tryToRequest(GuzzleHttp\Psr7\Request $request): GuzzleHttp\Psr7\Response
    {
        $client = new GuzzleHttp\Client();

        return $client->send($request, ['timeout' => 2]);
    }

    protected function request(GuzzleHttp\Psr7\Request $request): GuzzleHttp\Psr7\Response
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

    protected function getContentFromJson(string $contentJson): object
    {
        $content = json_decode($contentJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new IncorrectResponseContent();
        }

        return $content;
    }

    protected function getIpAddress(): IpAddressInterface
    {
        return $this->ipAddress;
    }
}