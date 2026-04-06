<?php

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\AuthenticationException;
use Ditshej\OpCards\Exceptions\NotFoundException;
use Ditshej\OpCards\Exceptions\RateLimitException;
use Ditshej\OpCards\OpCardsClient;
use Ditshej\OpCards\Resources\CardResource;
use Ditshej\OpCards\Resources\PackResource;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

function makeClient(string $token, array $responses, array &$history = []): OpCardsClient
{
    $mock = new MockHandler($responses);
    $stack = HandlerStack::create($mock);
    $stack->push(Middleware::history($history));

    $guzzle = new Client(['handler' => $stack]);

    return new OpCardsClient($token, $guzzle);
}

// --- 1.1 instantiation ---

test('OpCardsClient can be instantiated with a token', function () {
    $client = new OpCardsClient('my-token');

    expect($client)->toBeInstanceOf(OpCardsClient::class);
});

// --- 1.2 custom ClientInterface injection ---

test('custom ClientInterface is used when injected', function () {
    $history = [];
    $client = makeClient('my-token', [new Response(200, [], json_encode(['data' => []]))], $history);

    $client->packs();

    expect($history)->toHaveCount(1);
});

// --- 1.3 Authorization header ---

test('every request includes Authorization Bearer token header', function () {
    $history = [];
    $client = makeClient('secret-token', [new Response(200, [], json_encode(['data' => []]))], $history);

    $client->packs();

    $sentRequest = $history[0]['request'];
    expect($sentRequest->getHeaderLine('Authorization'))->toBe('Bearer secret-token');
});

// --- 1.4 JSON response decoded ---

test('200 JSON response is decoded and mapped to a resource', function () {
    $body = json_encode(['data' => ['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01']]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $pack = $client->pack('OP01');

    expect($pack)->toBeInstanceOf(PackResource::class)
        ->and($pack->name)->toBe('Romance Dawn');
});

// --- HTTP error status codes → typed exceptions ---

dataset('exception mapping', [
    'HTTP 401 → AuthenticationException' => [401, AuthenticationException::class],
    'HTTP 404 → NotFoundException' => [404, NotFoundException::class],
    'HTTP 429 → RateLimitException' => [429, RateLimitException::class],
    'HTTP 500 → ApiException' => [500, ApiException::class],
    'HTTP 422 → ApiException' => [422, ApiException::class],
]);

it('maps HTTP error status codes to typed exceptions', function (int $status, string $exception) {
    $client = makeClient('token', [new Response($status)]);

    expect(fn () => $client->packs())->toThrow($exception);
})->with('exception mapping');

// --- packs endpoints ---

it('packs() sends GET to the packs endpoint', function () {
    $history = [];
    $body = json_encode(['data' => [
        ['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01'],
    ]]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->packs();

    expect((string) $history[0]['request']->getUri())->toContain('packs');
});

it('packs() returns an array of PackResource', function () {
    $body = json_encode(['data' => [
        ['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01'],
        ['id' => 'OP02', 'name' => 'Paramount War', 'label' => 'OP-02'],
    ]]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $packs = $client->packs();

    expect($packs)->toHaveCount(2)
        ->and($packs[0])->toBeInstanceOf(PackResource::class)
        ->and($packs[0]->id)->toBe('OP01')
        ->and($packs[1]->id)->toBe('OP02');
});

it('packs() returns empty array when data is empty', function () {
    $client = makeClient('token', [new Response(200, [], json_encode(['data' => []]))]);

    expect($client->packs())->toBe([]);
});

it('pack() sends GET to packs/{id}', function () {
    $history = [];
    $body = json_encode(['data' => ['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01']]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->pack('OP01');

    expect((string) $history[0]['request']->getUri())->toContain('packs/OP01');
});

it('pack() returns a single PackResource', function () {
    $body = json_encode(['data' => ['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01']]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $pack = $client->pack('OP01');

    expect($pack)->toBeInstanceOf(PackResource::class)
        ->and($pack->id)->toBe('OP01');
});

it('pack() propagates NotFoundException on 404', function () {
    $client = makeClient('token', [new Response(404)]);

    expect(fn () => $client->pack('UNKNOWN'))->toThrow(NotFoundException::class);
});

// --- cards endpoints ---

it('cards() sends GET to the cards endpoint', function () {
    $history = [];
    $body = json_encode(['data' => [], 'meta' => []]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->cards();

    expect((string) $history[0]['request']->getUri())->toContain('cards');
});

it('card() sends GET to cards/{id}', function () {
    $history = [];
    $body = json_encode(['data' => [
        'id' => 'OP01-001', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
        'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'category' => 'Character',
        'colors' => ['Red'], 'attributes' => ['Strike'], 'types' => ['Straw Hat Crew'],
    ]]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->card('OP01-001');

    expect((string) $history[0]['request']->getUri())->toContain('cards/OP01-001');
});

it('cards() returns data as CardResource[] and meta', function () {
    $meta = ['current_page' => 1, 'last_page' => 2, 'per_page' => 25, 'total' => 50];
    $body = json_encode([
        'data' => [[
            'id' => 'OP01-001', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
            'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'category' => 'Character',
            'colors' => ['Red'], 'attributes' => ['Strike'], 'types' => ['Straw Hat Crew'],
        ]],
        'meta' => $meta,
    ]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $result = $client->cards();

    expect($result['data'])->toHaveCount(1)
        ->and($result['data'][0])->toBeInstanceOf(CardResource::class)
        ->and($result['data'][0]->id)->toBe('OP01-001')
        ->and($result['meta'])->toBe($meta);
});

it('cards() returns empty data array when API returns none', function () {
    $body = json_encode(['data' => [], 'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 25, 'total' => 0]]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    expect($client->cards()['data'])->toBe([]);
});

it('cards() forwards query parameters to the request', function () {
    $history = [];
    $body = json_encode(['data' => [], 'meta' => []]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->cards(['pack_id' => 'OP01']);

    expect((string) $history[0]['request']->getUri())->toContain('pack_id=OP01');
});

it('card() returns a single CardResource', function () {
    $body = json_encode(['data' => [
        'id' => 'OP01-001', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
        'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'category' => 'Character',
        'colors' => ['Red'], 'attributes' => ['Strike'], 'types' => ['Straw Hat Crew'],
    ]]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $card = $client->card('OP01-001');

    expect($card)->toBeInstanceOf(CardResource::class)
        ->and($card->id)->toBe('OP01-001');
});

it('card() propagates NotFoundException on 404', function () {
    $client = makeClient('token', [new Response(404)]);

    expect(fn () => $client->card('UNKNOWN'))->toThrow(NotFoundException::class);
});
