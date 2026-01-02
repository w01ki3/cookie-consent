<?php

namespace w01ki3\CookieConsent\Facades;

use Illuminate\Support\Facades\Facade;

class CookieConsent extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'CookieConsent';
    }
}