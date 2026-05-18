<?php

namespace Ditshej\OpCards\Resources;

readonly class PackResource
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $label,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            label: $data['label'],
        );
    }
}
