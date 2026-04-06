<?php

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\AuthenticationException;
use Ditshej\OpCards\Exceptions\NotFoundException;
use Ditshej\OpCards\Exceptions\RateLimitException;
use Ditshej\OpCards\Filters\CardFilter;
use Ditshej\OpCards\OpCardsClient;
use Ditshej\OpCards\Resources\CardResource;
use Ditshej\OpCards\Resources\PackResource;
use GuzzleHttp\Psr7\Response;

test('OpCardsClient can be instantiated with a token and base URI', function () {
    $client = new OpCardsClient('my-token', 'https://api.example.com/');

    expect($client)->toBeInstanceOf(OpCardsClient::class);
});

test('omitting base URI throws ArgumentCountError', function () {
    expect(fn () => new OpCardsClient('my-token'))->toThrow(ArgumentCountError::class);
});

test('custom base URI is used for outbound requests', function () {
    $history = [];
    $client = makeClient('token', [new Response(200, [], json_encode(['data' => []]))], $history, 'https://custom.example.com/api/');

    $client->packs();

    expect((string) $history[0]['request']->getUri())->toStartWith('https://custom.example.com/api/packs');
});

test('base URI without trailing slash is handled correctly', function () {
    $history = [];
    $client = makeClient('token', [new Response(200, [], json_encode(['data' => []]))], $history, 'https://custom.example.com/api');

    $client->packs();

    expect((string) $history[0]['request']->getUri())->toStartWith('https://custom.example.com/api/packs');
});

test('custom ClientInterface is used when injected', function () {
    $history = [];
    $client = makeClient('my-token', [new Response(200, [], json_encode(['data' => []]))], $history);

    $client->packs();

    expect($history)->toHaveCount(1);
});

test('every request includes Authorization Bearer token header', function () {
    $history = [];
    $client = makeClient('secret-token', [new Response(200, [], json_encode(['data' => []]))], $history);

    $client->packs();

    $sentRequest = $history[0]['request'];
    expect($sentRequest->getHeaderLine('Authorization'))->toBe('Bearer secret-token');
});

test('200 JSON response is decoded and mapped to a resource', function () {
    $body = json_encode(['data' => ['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01']]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $pack = $client->pack('OP01');

    expect($pack)->toBeInstanceOf(PackResource::class)
        ->and($pack->name)->toBe('Romance Dawn');
});

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

it('cards() sends no query string when called without a filter', function () {
    $history = [];
    $body = json_encode(['data' => [], 'meta' => []]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->cards();

    expect((string) $history[0]['request']->getUri())->not->toContain('?');
});

it('cards() forwards CardFilter query parameters to the request', function () {
    $history = [];
    $body = json_encode(['data' => [], 'meta' => []]);
    $client = makeClient('token', [new Response(200, [], $body)], $history);

    $client->cards((new CardFilter)->pack('OP01'));

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

it('allCards() with a single page returns a flat CardResource[]', function () {
    $body = json_encode([
        'data' => [[
            'id' => 'OP01-001', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
            'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'category' => 'Character',
            'colors' => ['Red'], 'attributes' => ['Strike'], 'types' => ['Straw Hat Crew'],
        ]],
        'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 25, 'total' => 1],
    ]);
    $client = makeClient('token', [new Response(200, [], $body)]);

    $result = $client->allCards();

    expect($result)->toHaveCount(1)
        ->and($result[0])->toBeInstanceOf(CardResource::class)
        ->and($result[0]->id)->toBe('OP01-001');
});

it('allCards() with multiple pages merges all pages into one flat array', function () {
    $page1 = json_encode([
        'data' => [[
            'id' => 'OP01-001', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
            'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'category' => 'Character',
            'colors' => ['Red'], 'attributes' => ['Strike'], 'types' => ['Straw Hat Crew'],
        ]],
        'meta' => ['current_page' => 1, 'last_page' => 2, 'per_page' => 1, 'total' => 2],
    ]);
    $page2 = json_encode([
        'data' => [[
            'id' => 'OP01-002', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
            'name' => 'Roronoa Zoro', 'rarity' => 'R', 'category' => 'Character',
            'colors' => ['Green'], 'attributes' => ['Slash'], 'types' => ['Straw Hat Crew'],
        ]],
        'meta' => ['current_page' => 2, 'last_page' => 2, 'per_page' => 1, 'total' => 2],
    ]);
    $client = makeClient('token', [new Response(200, [], $page1), new Response(200, [], $page2)]);

    $result = $client->allCards();

    expect($result)->toHaveCount(2)
        ->and($result[0])->toBeInstanceOf(CardResource::class)
        ->and($result[0]->id)->toBe('OP01-001')
        ->and($result[1])->toBeInstanceOf(CardResource::class)
        ->and($result[1]->id)->toBe('OP01-002');
});

it('allCards() stops after the last page (current_page === last_page)', function () {
    $history = [];
    $page1 = json_encode([
        'data' => [[
            'id' => 'OP01-001', 'pack_id' => 'OP01', 'card_set' => 'OP-01',
            'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'category' => 'Character',
            'colors' => ['Red'], 'attributes' => ['Strike'], 'types' => ['Straw Hat Crew'],
        ]],
        'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 25, 'total' => 1],
    ]);
    $client = makeClient('token', [new Response(200, [], $page1)], $history);

    $client->allCards();

    expect($history)->toHaveCount(1);
});

it('allCards(null) uses a fresh CardFilter with page set per iteration', function () {
    $history = [];
    $page1 = json_encode([
        'data' => [],
        'meta' => ['current_page' => 1, 'last_page' => 2, 'per_page' => 25, 'total' => 0],
    ]);
    $page2 = json_encode([
        'data' => [],
        'meta' => ['current_page' => 2, 'last_page' => 2, 'per_page' => 25, 'total' => 0],
    ]);
    $client = makeClient('token', [new Response(200, [], $page1), new Response(200, [], $page2)], $history);

    $client->allCards(null);

    expect((string) $history[0]['request']->getUri())->toContain('page=1')
        ->and((string) $history[1]['request']->getUri())->toContain('page=2');
});

it('allCards($filter) forwards caller\'s filter constraints on every request', function () {
    $history = [];
    $page1 = json_encode([
        'data' => [],
        'meta' => ['current_page' => 1, 'last_page' => 2, 'per_page' => 25, 'total' => 0],
    ]);
    $page2 = json_encode([
        'data' => [],
        'meta' => ['current_page' => 2, 'last_page' => 2, 'per_page' => 25, 'total' => 0],
    ]);
    $client = makeClient('token', [new Response(200, [], $page1), new Response(200, [], $page2)], $history);

    $client->allCards((new CardFilter)->pack('OP01'));

    expect((string) $history[0]['request']->getUri())->toContain('pack_id=OP01')
        ->and((string) $history[1]['request']->getUri())->toContain('pack_id=OP01');
});

it('allCards() does not mutate the caller\'s filter', function () {
    $body = json_encode([
        'data' => [],
        'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 25, 'total' => 0],
    ]);
    $client = makeClient('token', [new Response(200, [], $body)]);
    $filter = (new CardFilter)->pack('OP01');

    $client->allCards($filter);

    expect($filter->toQuery())->toBe(['pack_id' => 'OP01']);
});
