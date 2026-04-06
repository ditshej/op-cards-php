<?php

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\NotFoundException;

test('NotFoundException extends ApiException', function () {
    $exception = new NotFoundException('Resource not found');

    expect($exception)->toBeInstanceOf(ApiException::class);
});

test('NotFoundException carries the given message', function () {
    $message = 'Card OP01-001 not found';
    $exception = new NotFoundException($message);

    expect($exception->getMessage())->toBe($message);
});

test('getStatusCode() is available on NotFoundException via ApiException inheritance', function () {
    $exception = new NotFoundException('Not Found', 404);

    expect($exception->getStatusCode())->toBe(404);
});
