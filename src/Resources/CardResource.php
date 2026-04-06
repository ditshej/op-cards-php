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
}
