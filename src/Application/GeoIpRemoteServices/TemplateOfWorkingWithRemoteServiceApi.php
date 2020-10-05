<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Exceptions\ConnectException;
use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\RemoteServicesOptions;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectResponseContent;
use CodeblogPro\GeoLocationAddress\LocationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp;

abstract class TemplateOfWorkingWithRemoteServiceApi
{
    protected RemoteServicesOptions $options;

    abstract protected function getLocationByResponse(
        ResponseInterface $response,
        LanguageInterface $language
    ): LocationInterface;

    abstract protected function prepareRequest(IpAddressInterface $ipAddress): RequestInterface;

    public function __construct(RemoteServicesOptions $options)
    {
        $this->options = $options;
    }

    public function getLocation(IpAddressInterface $ipAddress, LanguageInterface $language): LocationInterface
    {
        $request = $this->prepareRequest($ipAddress);
        $response = $this->request($request);

        return $this->getLocationByResponse($response, $language);
    }

    protected function tryToRequest(RequestInterface $request): ResponseInterface
    {
        $client = new GuzzleHttp\Client();

        return $client->send($request, ['timeout' => 2]);
    }

    protected function request(RequestInterface $request): ResponseInterface
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
}
