<?php

use Ditshej\OpCards\Laravel\OpCardsServiceProvider;
use Ditshej\OpCards\OpCardsClient;
use Illuminate\Container\Container;

it('binds OpCardsClient as a singleton', function () {
    $container = new Container;
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $client = $container->make(OpCardsClient::class);

    expect($client)->toBeInstanceOf(OpCardsClient::class);
});

it('returns the same instance on repeated resolution (singleton)', function () {
    $container = new Container;
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $first = $container->make(OpCardsClient::class);
    $second = $container->make(OpCardsClient::class);

    expect($first)->toBe($second);
});
