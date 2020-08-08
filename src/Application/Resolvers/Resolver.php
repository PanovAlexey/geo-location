<?php

namespace CodeblogPro\GeoLocation\Application\Resolvers;

use CodeblogPro\GeoLocation\Application\Exceptions\ConnectException;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use GuzzleHttp;

abstract class Resolver
{
    protected string $resultLanguage;
    protected string $ip;

    abstract protected function getKey(): string;

    abstract protected function getUrl(): string;

    public function __construct(string $ip, string $resultLanguage)
    {
        $this->setIp($ip);
        $this->setResultLanguage($resultLanguage);
    }

    public function getLocation(): LocationInterface
    {
        $request = $this->prepareRequest();
        $response = $this->request($request);

        return $this->getLocationByResponse($response);
    }

    public function getResultLanguage(): string
    {
        return $this->resultLanguage;
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

    protected function isIpValid(string $ip): bool
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        return true;
    }

    protected function getIp(): string
    {
        return $this->ip;
    }

    private function setIp(string $ip): void
    {
        if (!$this->isIpValid($ip)) {
            throw new IncorrectIpException();
        }

        $this->ip = $ip;
    }

    private function setResultLanguage(string $resultLanguage): void
    {
        $this->resultLanguage = $resultLanguage;
    }
}