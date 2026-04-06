<?php

namespace Ditshej\OpCards\Laravel;

use Ditshej\OpCards\OpCardsClient;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class OpCardsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/opcards.php',
            'opcards',
        );

        $this->publishes([
            __DIR__.'/../../config/opcards.php' => config_path('opcards.php'),
        ], 'opcards-config');
    }

    public function register(): void
    {
        $this->app->singleton(OpCardsClient::class, function () {
            $token = (string) ($this->app['config']->get('opcards.token') ?? '');

            if ($token === '') {
                throw new InvalidArgumentException('opcards.token config value must not be blank.');
            }

            return new OpCardsClient(
                $token,
                (string) ($this->app['config']->get('opcards.base_uri') ?? ''),
            );
        });
    }
}
