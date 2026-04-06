<?php

namespace Ditshej\OpCards\Laravel;

use Ditshej\OpCards\OpCardsClient;
use Illuminate\Support\ServiceProvider;

class OpCardsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OpCardsClient::class, fn () => new OpCardsClient(
            (string) (getenv('OPCARDS_TOKEN') ?: ''),
            (string) (getenv('OPCARDS_BASE_URI') ?: 'https://op-cards.ditshej.ch/api/'),
        ));
    }
}
