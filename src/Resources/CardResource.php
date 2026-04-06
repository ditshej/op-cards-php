<?php

namespace Ditshej\OpCards\Resources;

readonly class CardResource
{
    public function __construct(
        public string $id,
        public string $pack_id,
        public string $card_set,
        public string $name,
        public string $rarity,
        public string $category,
        public array $colors,
        public ?int $cost,
        public ?int $power,
        public array $attributes,
        public array $types,
        public ?string $effect,
        public ?string $trigger,
        public ?string $img_url,
        public ?string $alt_art_variant,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            pack_id: $data['pack_id'],
            card_set: $data['card_set'],
            name: $data['name'],
            rarity: $data['rarity'],
            category: $data['category'],
            colors: $data['colors'],
            cost: $data['cost'] ?? null,
            power: $data['power'] ?? null,
            attributes: $data['attributes'],
            types: $data['types'],
            effect: $data['effect'] ?? null,
            trigger: $data['trigger'] ?? null,
            img_url: $data['img_url'] ?? null,
            alt_art_variant: $data['alt_art_variant'] ?? null,
        );
    }
}
