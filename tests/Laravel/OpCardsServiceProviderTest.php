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

it('reads OPCARDS_BASE_URI from the environment', function () {
    putenv('OPCARDS_BASE_URI=https://my-instance.example.com/api/');

    $container = new Container;
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $client = $container->make(OpCardsClient::class);

    $reflection = new ReflectionProperty($client, 'baseUri');

    expect($reflection->getValue($client))->toBe('https://my-instance.example.com/api/');

    putenv('OPCARDS_BASE_URI');
});

it('falls back to the default base URI when OPCARDS_BASE_URI is not set', function () {
    putenv('OPCARDS_BASE_URI');

    $container = new Container;
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $client = $container->make(OpCardsClient::class);

    $reflection = new ReflectionProperty($client, 'baseUri');

    expect($reflection->getValue($client))->toBe('https://op-cards.ditshej.ch/api/');
});

it('returns the same instance on repeated resolution (singleton)', function () {
    $container = new Container;
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $first = $container->make(OpCardsClient::class);
    $second = $container->make(OpCardsClient::class);

    expect($first)->toBe($second);
});
