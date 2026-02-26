<?php

namespace JakubOrava\AffilboxClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JakubOrava\AffilboxClient\AffilboxClient
 */
class AffilboxClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JakubOrava\AffilboxClient\AffilboxClient::class;
    }
}
