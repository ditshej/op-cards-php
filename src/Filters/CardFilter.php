<?php

namespace Ditshej\OpCards\Filters;

class CardFilter
{
    private array $params = [];

    public function color(string $value): static
    {
        $this->params['color'] = $value;

        return $this;
    }

    public function category(string $value): static
    {
        $this->params['category'] = $value;

        return $this;
    }

    public function cost(int ...$values): static
    {
        if (count($values) === 0) {
            return $this;
        }

        $this->params['cost'] = count($values) === 1 ? $values[0] : $values;

        return $this;
    }

    public function costBetween(int $min, int $max): static
    {
        $this->params['cost_min'] = $min;
        $this->params['cost_max'] = $max;

        return $this;
    }

    public function powerBetween(int $min, int $max): static
    {
        $this->params['power_min'] = $min;
        $this->params['power_max'] = $max;

        return $this;
    }

    public function pack(string $id): static
    {
        $this->params['pack_id'] = $id;

        return $this;
    }

    public function search(string $query): static
    {
        $this->params['q'] = $query;

        return $this;
    }

    public function rarity(string $value): static
    {
        $this->params['rarity'] = $value;

        return $this;
    }

    public function attribute(string $value): static
    {
        $this->params['attribute'] = $value;

        return $this;
    }

    public function type(string $value): static
    {
        $this->params['type'] = $value;

        return $this;
    }

    public function keyword(string $value): static
    {
        $this->params['keyword'] = $value;

        return $this;
    }

    public function cardSet(string $value): static
    {
        $this->params['card_set'] = $value;

        return $this;
    }

    public function altArt(bool $value): static
    {
        $this->params['alt_art'] = (int) $value;

        return $this;
    }

    public function perPage(int $value): static
    {
        $this->params['per_page'] = $value;

        return $this;
    }

    public function page(int $value): static
    {
        $this->params['page'] = $value;

        return $this;
    }

    public function toQuery(): array
    {
        return $this->params;
    }
}
