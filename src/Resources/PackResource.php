<?php

namespace Ditshej\OpCards\Resources;

readonly class PackResource
{
    public function __construct(
        public string $id,
        public string $name,
        public string $label,
    ) {}
}
