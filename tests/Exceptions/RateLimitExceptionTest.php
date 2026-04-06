<?php

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\RateLimitException;

test('RateLimitException extends ApiException', function () {
    $exception = new RateLimitException('Too many requests');

    expect($exception)->toBeInstanceOf(ApiException::class);
});

test('RateLimitException carries the given message', function () {
    $message = 'Rate limit exceeded, retry after 60 seconds';
    $exception = new RateLimitException($message);

    expect($exception->getMessage())->toBe($message);
});

test('getStatusCode() is available on RateLimitException via ApiException inheritance', function () {
    $exception = new RateLimitException('Too Many Requests', 429);

    expect($exception->getStatusCode())->toBe(429);
});
