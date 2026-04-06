<?php

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\AuthenticationException;
use Ditshej\OpCards\Exceptions\NotFoundException;
use Ditshej\OpCards\Exceptions\RateLimitException;
use Ditshej\OpCards\OpCardsClient;
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
    $client = makeClient('my-token', [new Response(200, [], '[]')], $history);

    $client->request('GET', '/test');

    expect($history)->toHaveCount(1);
});

// --- 1.3 Authorization header ---

test('every request includes Authorization Bearer token header', function () {
    $history = [];
    $client = makeClient('secret-token', [new Response(200, [], '[]')], $history);

    $client->request('GET', '/test');

    $sentRequest = $history[0]['request'];
    expect($sentRequest->getHeaderLine('Authorization'))->toBe('Bearer secret-token');
});

// --- 1.4 JSON response decoded to array ---

test('200 JSON response is returned as PHP array', function () {
    $payload = ['id' => 1, 'name' => 'Monkey D. Luffy'];
    $history = [];
    $client = makeClient('token', [new Response(200, [], json_encode($payload))], $history);

    $result = $client->request('GET', '/cards/1');

    expect($result)->toBe($payload);
});

// --- 1.5–1.9 HTTP error status codes → typed exceptions ---

dataset('exception mapping', [
    'HTTP 401 → AuthenticationException' => [401, AuthenticationException::class],
    'HTTP 404 → NotFoundException' => [404, NotFoundException::class],
    'HTTP 429 → RateLimitException' => [429, RateLimitException::class],
    'HTTP 500 → ApiException' => [500, ApiException::class],
    'HTTP 422 → ApiException' => [422, ApiException::class],
]);

it('maps HTTP error status codes to typed exceptions', function (int $status, string $exception) {
    $client = makeClient('token', [new Response($status)]);

    expect(fn () => $client->request('GET', '/cards'))->toThrow($exception);
})->with('exception mapping');
