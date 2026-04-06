<?php

namespace Ditshej\OpCards\Laravel\Facades;

use Ditshej\OpCards\OpCardsClient;
use Illuminate\Support\Facades\Facade;

class OpCards extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return OpCardsClient::class;
    }
}
