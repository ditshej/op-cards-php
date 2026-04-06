<?php

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\AuthenticationException;

test('AuthenticationException extends ApiException', function () {
    $exception = new AuthenticationException('Unauthorized');

    expect($exception)->toBeInstanceOf(ApiException::class);
});

test('AuthenticationException carries the given message', function () {
    $message = 'Invalid API key';
    $exception = new AuthenticationException($message);

    expect($exception->getMessage())->toBe($message);
});
