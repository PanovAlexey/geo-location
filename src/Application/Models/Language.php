<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoLocation\Application\Enums\AvailableLanguages;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectLanguageCodeException;

class Language implements LanguageInterface
{
    private string $code;

    public function __constructor(string $code)
    {
        $this->code = $this->validate($code);
    }

    public function getCode(): string
    {
        return 'ru';
    }

    private function validate(string $code): string
    {
        $code = mb_strtoupper(trim($code));

        if (!isset(AvailableLanguages::$code)) {
            throw new IncorrectLanguageCodeException($code);
        }

        return AvailableLanguages::$code;
    }
}