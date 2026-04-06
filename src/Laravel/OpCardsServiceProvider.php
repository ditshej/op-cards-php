<?php

namespace Ditshej\OpCards\Laravel;

use Ditshej\OpCards\OpCardsClient;
use Illuminate\Support\ServiceProvider;

class OpCardsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OpCardsClient::class, function () {
            $baseUri = getenv('OPCARDS_BASE_URI');

            if ($baseUri === false || $baseUri === '') {
                throw new \InvalidArgumentException('OPCARDS_BASE_URI environment variable is not set.');
            }

            return new OpCardsClient(
                (string) (getenv('OPCARDS_TOKEN') ?: ''),
                $baseUri,
            );
        });
    }
}
