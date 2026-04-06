<?php

use Ditshej\OpCards\Exceptions\ApiException;

test('ApiException extends RuntimeException', function () {
    $exception = new ApiException('Something went wrong');

    expect($exception)->toBeInstanceOf(RuntimeException::class);
});

test('ApiException carries the given message', function () {
    $message = 'API error occurred';
    $exception = new ApiException($message);

    expect($exception->getMessage())->toBe($message);
});

test('ApiException accepts a previous throwable', function () {
    $previous = new Exception('Original error');
    $exception = new ApiException('Wrapped error', 0, $previous);

    expect($exception->getPrevious())->toBe($previous);
});
