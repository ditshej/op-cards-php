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

// --- 1.5 401 → AuthenticationException ---

test('401 response throws AuthenticationException', function () {
    $client = makeClient('bad-token', [new Response(401)]);

    expect(fn () => $client->request('GET', '/cards'))->toThrow(AuthenticationException::class);
});

// --- 1.6 404 → NotFoundException ---

test('404 response throws NotFoundException', function () {
    $client = makeClient('token', [new Response(404)]);

    expect(fn () => $client->request('GET', '/cards/missing'))->toThrow(NotFoundException::class);
});

// --- 1.7 429 → RateLimitException ---

test('429 response throws RateLimitException', function () {
    $client = makeClient('token', [new Response(429)]);

    expect(fn () => $client->request('GET', '/cards'))->toThrow(RateLimitException::class);
});

// --- 1.8 500 → ApiException ---

test('500 response throws ApiException', function () {
    $client = makeClient('token', [new Response(500)]);

    expect(fn () => $client->request('GET', '/cards'))->toThrow(ApiException::class);
});

// --- 1.9 422 → ApiException ---

test('422 response throws ApiException', function () {
    $client = makeClient('token', [new Response(422)]);

    expect(fn () => $client->request('GET', '/cards'))->toThrow(ApiException::class);
});
