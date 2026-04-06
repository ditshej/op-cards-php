<?php

use Ditshej\OpCards\Filters\CardFilter;

it('empty filter produces empty query array', function () {
    expect((new CardFilter)->toQuery())->toBe([]);
});

dataset('single-value methods', [
    'color' => [fn (CardFilter $f) => $f->color('Red'),      ['color' => 'Red']],
    'category' => [fn (CardFilter $f) => $f->category('Character'), ['category' => 'Character']],
    'cost' => [fn (CardFilter $f) => $f->cost(5),           ['cost' => 5]],
    'pack' => [fn (CardFilter $f) => $f->pack('OP01'),      ['pack_id' => 'OP01']],
    'search' => [fn (CardFilter $f) => $f->search('Luffy'),   ['q' => 'Luffy']],
    'rarity' => [fn (CardFilter $f) => $f->rarity('L'),       ['rarity' => 'L']],
    'attribute' => [fn (CardFilter $f) => $f->attribute('Strike'), ['attribute' => 'Strike']],
    'type' => [fn (CardFilter $f) => $f->type('Straw Hat Crew'), ['type' => 'Straw Hat Crew']],
    'keyword' => [fn (CardFilter $f) => $f->keyword('Slash'),  ['keyword' => 'Slash']],
    'cardSet' => [fn (CardFilter $f) => $f->cardSet('OP-01'),  ['card_set' => 'OP-01']],
    'perPage' => [fn (CardFilter $f) => $f->perPage(50),       ['per_page' => 50]],
    'page' => [fn (CardFilter $f) => $f->page(2),          ['page' => 2]],
]);

it('single method sets the correct query key', function (Closure $apply, array $expected) {
    $filter = new CardFilter;
    $apply($filter);

    expect($filter->toQuery())->toBe($expected);
})->with('single-value methods');

it('costBetween sets cost_min and cost_max', function () {
    $query = (new CardFilter)->costBetween(3, 7)->toQuery();

    expect($query)->toBe(['cost_min' => 3, 'cost_max' => 7]);
});

it('powerBetween sets power_min and power_max', function () {
    $query = (new CardFilter)->powerBetween(4000, 8000)->toQuery();

    expect($query)->toBe(['power_min' => 4000, 'power_max' => 8000]);
});

it('altArt(true) sets alt_art to 1', function () {
    expect((new CardFilter)->altArt(true)->toQuery())->toBe(['alt_art' => 1]);
});

it('altArt(false) sets alt_art to 0', function () {
    expect((new CardFilter)->altArt(false)->toQuery())->toBe(['alt_art' => 0]);
});

it('multiple methods chain and produce all set keys', function () {
    $query = (new CardFilter)
        ->color('Red')
        ->rarity('L')
        ->pack('OP01')
        ->toQuery();

    expect($query)->toBe(['color' => 'Red', 'rarity' => 'L', 'pack_id' => 'OP01']);
});

it('page() sets the page key', function () {
    expect((new CardFilter)->page(2)->toQuery())->toBe(['page' => 2]);
});

it('page() is chainable with other filter methods', function () {
    $query = (new CardFilter)
        ->color('Red')
        ->page(3)
        ->toQuery();

    expect($query)->toBe(['color' => 'Red', 'page' => 3]);
});

it('cost() with multiple values emits array', function () {
    expect((new CardFilter)->cost(3, 5, 7)->toQuery())->toBe(['cost' => [3, 5, 7]]);
});

it('cost() with no arguments does not include cost in toQuery', function () {
    expect((new CardFilter)->cost()->toQuery())->not->toHaveKey('cost');
});
