<?php

use Ditshej\OpCards\Resources\CardResource;

it('stores all required fields', function () {
    $card = makeCard();

    expect($card->id)->toBe('OP01-001')
        ->and($card->pack_id)->toBe('OP01')
        ->and($card->card_set)->toBe('OP-01')
        ->and($card->name)->toBe('Monkey D. Luffy')
        ->and($card->rarity)->toBe('L')
        ->and($card->category)->toBe('Character')
        ->and($card->colors)->toBe(['Red'])
        ->and($card->cost)->toBe(5)
        ->and($card->power)->toBe(6000)
        ->and($card->attributes)->toBe(['Strike'])
        ->and($card->types)->toBe(['Straw Hat Crew'])
        ->and($card->effect)->toBe('Some effect text.')
        ->and($card->trigger)->toBeNull()
        ->and($card->img_url)->toBe('https://example.com/card.jpg')
        ->and($card->alt_art_variant)->toBeNull();
});

it('accepts null for nullable fields', function () {
    $card = makeCard([
        'cost' => null,
        'power' => null,
        'effect' => null,
        'trigger' => null,
        'img_url' => null,
        'alt_art_variant' => null,
    ]);

    expect($card->cost)->toBeNull()
        ->and($card->power)->toBeNull()
        ->and($card->effect)->toBeNull()
        ->and($card->trigger)->toBeNull()
        ->and($card->img_url)->toBeNull()
        ->and($card->alt_art_variant)->toBeNull();
});

it('has readonly properties', function () {
    $card = makeCard();

    expect(fn () => $card->id = 'changed')->toThrow(Error::class);
});

it('can be hydrated from a complete array', function () {
    $data = [
        'id' => 'OP01-001',
        'pack_id' => 'OP01',
        'card_set' => 'OP-01',
        'name' => 'Monkey D. Luffy',
        'rarity' => 'L',
        'category' => 'Character',
        'colors' => ['Red'],
        'cost' => 5,
        'power' => 6000,
        'attributes' => ['Strike'],
        'types' => ['Straw Hat Crew'],
        'effect' => 'Some effect text.',
        'trigger' => null,
        'img_url' => 'https://example.com/card.jpg',
        'alt_art_variant' => null,
    ];

    $card = CardResource::fromArray($data);

    expect($card->id)->toBe('OP01-001')
        ->and($card->pack_id)->toBe('OP01')
        ->and($card->name)->toBe('Monkey D. Luffy')
        ->and($card->colors)->toBe(['Red'])
        ->and($card->cost)->toBe(5);
});

it('fromArray sets nullable fields to null when absent', function () {
    $data = [
        'id' => 'OP01-001',
        'pack_id' => 'OP01',
        'card_set' => 'OP-01',
        'name' => 'Monkey D. Luffy',
        'rarity' => 'L',
        'category' => 'Character',
        'colors' => ['Red'],
        'attributes' => ['Strike'],
        'types' => ['Straw Hat Crew'],
    ];

    $card = CardResource::fromArray($data);

    expect($card->cost)->toBeNull()
        ->and($card->power)->toBeNull()
        ->and($card->effect)->toBeNull()
        ->and($card->trigger)->toBeNull()
        ->and($card->img_url)->toBeNull()
        ->and($card->alt_art_variant)->toBeNull();
});
