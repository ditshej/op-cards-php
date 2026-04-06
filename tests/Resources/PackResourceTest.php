<?php

use Ditshej\OpCards\Resources\PackResource;

it('stores id, name and label', function () {
    $pack = new PackResource('OP01', 'Romance Dawn', 'OP-01');

    expect($pack->id)->toBe('OP01')
        ->and($pack->name)->toBe('Romance Dawn')
        ->and($pack->label)->toBe('OP-01');
});

it('has readonly properties', function () {
    $pack = new PackResource('OP01', 'Romance Dawn', 'OP-01');

    expect(fn () => $pack->id = 'OP02')->toThrow(Error::class);
});

it('can be hydrated from a raw array', function () {
    $pack = PackResource::fromArray(['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01']);

    expect($pack->id)->toBe('OP01')
        ->and($pack->name)->toBe('Romance Dawn')
        ->and($pack->label)->toBe('OP-01');
});
