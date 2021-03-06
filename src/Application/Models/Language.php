<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectLanguageCodeException;

class Language implements LanguageInterface
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $this->validate($code);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    private function validate(string $code): string
    {
        $code = mb_strtoupper(trim($code));
        $validatedCode = '';

        try {
            $validatedCode = constant('\CodeblogPro\GeoLocation\Application\Enums\AvailableLanguages::' . $code);
        } catch (\Exception $exception) {
            throw new IncorrectLanguageCodeException();
        }

        return $validatedCode;
    }
}
