<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

use Ditshej\OpCards\OpCardsClient;
use Ditshej\OpCards\Resources\CardResource;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

function makeClient(
    string $token,
    array $responses,
    array &$history = [],
    string $baseUri = 'https://op-cards.ditshej.ch/api/',
): OpCardsClient {
    $mock = new MockHandler($responses);
    $stack = HandlerStack::create($mock);
    $stack->push(Middleware::history($history));

    $guzzle = new Client(['handler' => $stack]);

    return new OpCardsClient($token, $baseUri, $guzzle);
}

function makeCard(array $overrides = []): CardResource
{
    $defaults = [
        'id' => 'OP01-001',
        'pack_id' => 'OP01',
        'card_set' => 'OP-01',
        'name' => 'Monkey D. Luffy',
        'rarity' => 'L',
        'category' => 'Character',
        'colors' => ['Red'],
        'cost' => 5,
        'power' => 6000,
        'attributes' => ['Strike'],
        'types' => ['Straw Hat Crew'],
        'effect' => 'Some effect text.',
        'trigger' => null,
        'img_url' => 'https://example.com/card.jpg',
        'alt_art_variant' => null,
    ];

    $data = array_merge($defaults, $overrides);

    return new CardResource(
        id: $data['id'],
        pack_id: $data['pack_id'],
        card_set: $data['card_set'],
        name: $data['name'],
        rarity: $data['rarity'],
        category: $data['category'],
        colors: $data['colors'],
        cost: $data['cost'],
        power: $data['power'],
        attributes: $data['attributes'],
        types: $data['types'],
        effect: $data['effect'],
        trigger: $data['trigger'],
        img_url: $data['img_url'],
        alt_art_variant: $data['alt_art_variant'],
    );
}
