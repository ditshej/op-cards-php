<?php

use Ditshej\OpCards\Laravel\OpCardsServiceProvider;
use Ditshej\OpCards\OpCardsClient;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Container\Container;

function makeContainer(array $config = []): Container
{
    $container = new Container;
    $configRepo = new ConfigRepository([
        'opcards' => array_merge([
            'token' => 'test-token',
            'base_uri' => 'https://api.example.com/',
        ], $config['opcards'] ?? []),
    ]);
    $container->instance('config', $configRepo);

    return $container;
}

it('binds OpCardsClient as a singleton', function () {
    $container = makeContainer();
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $client = $container->make(OpCardsClient::class);

    expect($client)->toBeInstanceOf(OpCardsClient::class);
});

it('reads opcards.base_uri from Laravel config', function () {
    $container = makeContainer(['opcards' => ['token' => 'test-token', 'base_uri' => 'https://my-instance.example.com/api/']]);
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $client = $container->make(OpCardsClient::class);
    $reflection = new ReflectionProperty($client, 'baseUri');

    expect($reflection->getValue($client))->toBe('https://my-instance.example.com/api/');
});

it('returns the same instance on repeated resolution (singleton)', function () {
    $container = makeContainer();
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    $first = $container->make(OpCardsClient::class);
    $second = $container->make(OpCardsClient::class);

    expect($first)->toBe($second);
});

it('throws InvalidArgumentException when opcards.token is blank or null', function (mixed $token) {
    $container = makeContainer(['opcards' => ['token' => $token, 'base_uri' => 'https://api.example.com/']]);
    $provider = new OpCardsServiceProvider($container);
    $provider->register();

    expect(fn () => $container->make(OpCardsClient::class))
        ->toThrow(InvalidArgumentException::class);
})->with([
    'empty string' => [''],
    'null' => [null],
]);
