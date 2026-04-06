<?php

use Ditshej\OpCards\Resources\CardResource;

function makeCard(array $overrides = []): CardResource
{
    $get = fn (string $key, mixed $default) => array_key_exists($key, $overrides) ? $overrides[$key] : $default;

    return new CardResource(
        id: $get('id', 'OP01-001'),
        pack_id: $get('pack_id', 'OP01'),
        card_set: $get('card_set', 'OP-01'),
        name: $get('name', 'Monkey D. Luffy'),
        rarity: $get('rarity', 'L'),
        category: $get('category', 'Character'),
        colors: $get('colors', ['Red']),
        cost: $get('cost', 5),
        power: $get('power', 6000),
        attributes: $get('attributes', ['Strike']),
        types: $get('types', ['Straw Hat Crew']),
        effect: $get('effect', 'Some effect text.'),
        trigger: $get('trigger', null),
        img_url: $get('img_url', 'https://example.com/card.jpg'),
        alt_art_variant: $get('alt_art_variant', null),
    );
}

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
        ->and($card->img_url)->toBe('https://example.com/card.jpg');
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
