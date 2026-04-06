<?php

use Ditshej\OpCards\Laravel\Facades\OpCards;
use Ditshej\OpCards\OpCardsClient;

it('facade accessor returns OpCardsClient class string', function () {
    $accessor = (new class extends OpCards
    {
        public static function getAccessor(): string
        {
            return self::getFacadeAccessor();
        }
    })::getAccessor();

    expect($accessor)->toBe(OpCardsClient::class);
});
