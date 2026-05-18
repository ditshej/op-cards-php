# op-cards-php

![CI](https://github.com/ditshej/op-cards-php/actions/workflows/ci.yml/badge.svg)

PHP client library for [one-piece-cards-api](https://github.com/ditshej/one-piece-cards-api) — a self-hostable HTTP API serving One Piece TCG card data. Use this package to talk to **your own** instance of that API from any PHP application. Framework-agnostic core with optional Laravel integration.

---

## How it works

This SDK does not call any shared or public service. You bring your own backend:

1. Install and host [one-piece-cards-api](https://github.com/ditshej/one-piece-cards-api) on a server you control. It exposes the HTTP endpoints (`/packs`, `/cards`, …) and issues bearer tokens.
2. Install this package in your PHP project and point it at your instance's base URL and token.

> **Note:** `op-cards.ditshej.ch` is the maintainer's private instance and is not a public API. Replace it with your own host in the examples below.

---

## Installation

```bash
composer require ditshej/op-cards-php
```

Requires PHP 8.4+ and `guzzlehttp/guzzle`.

---

## Configuration

The client requires two values:

| Variable | Description |
|---|---|
| `OPCARDS_TOKEN` | Bearer token issued by your API instance |
| `OPCARDS_BASE_URI` | Base URL of your API instance, e.g. `https://op-cards.ditshej.ch/api/` *(maintainer's instance — replace with yours)* |

---

## Standalone usage

```php
use Ditshej\OpCards\OpCardsClient;

$client = new OpCardsClient(
    token: $_ENV['OPCARDS_TOKEN'],
    baseUri: $_ENV['OPCARDS_BASE_URI'],
);
```

---

## Laravel integration

The package supports auto-discovery. Once installed, the `OpCardsServiceProvider` is registered automatically.

Add the credentials to your `.env`:

```env
OPCARDS_TOKEN=your-token
OPCARDS_BASE_URI=https://op-cards.ditshej.ch/api/  # maintainer's instance — replace with yours
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag=opcards-config
```

This creates `config/opcards.php` where you can override the values.

Use the Facade anywhere in your Laravel app:

```php
use Ditshej\OpCards\Laravel\Facades\OpCards;

$packs = OpCards::packs();
```

Or inject `OpCardsClient` directly:

```php
use Ditshej\OpCards\OpCardsClient;

class CardController extends Controller
{
    public function __construct(private OpCardsClient $client) {}
}
```

---

## Available methods

| Method | Returns | Description |
|---|---|---|
| `packs()` | `PackResource[]` | All available card packs |
| `pack(string $id)` | `PackResource` | Single pack by ID |
| `cards(?CardFilter $filter)` | `array{data: CardResource[], meta: array}` | Paginated card list, optionally filtered |
| `card(string $id)` | `CardResource` | Single card by ID |
| `allCards(?CardFilter $filter)` | `CardResource[]` | All cards across all pages, flat array |

---

## Filtering cards

`CardFilter` is a fluent builder for the `cards()` and `allCards()` endpoints:

```php
use Ditshej\OpCards\Filters\CardFilter;

// Paginated — single page
$result = $client->cards(
    (new CardFilter)
        ->color('Red')
        ->cost(3, 5, 7)      // multi-value: cost=3 OR cost=5 OR cost=7
        ->rarity('L')
        ->perPage(50)
        ->page(2)
);

$cards = $result['data']; // CardResource[]
$meta  = $result['meta']; // current_page, last_page, per_page, total

// Fetch all pages automatically
$allCards = $client->allCards(
    (new CardFilter)->color('Red')->pack('OP01')
);
```

### All filter methods

| Method | Description |
|---|---|
| `color(string $value)` | Card color (e.g. `'Red'`, `'Blue'`) |
| `category(string $value)` | Card category (e.g. `'Character'`, `'Event'`) |
| `cost(int ...$values)` | Exact cost — single value or multiple |
| `costBetween(int $min, int $max)` | Cost range (inclusive) |
| `powerBetween(int $min, int $max)` | Power range (inclusive) |
| `rarity(string $value)` | Rarity (e.g. `'L'`, `'R'`, `'C'`) |
| `attribute(string $value)` | Attribute (e.g. `'Strike'`, `'Slash'`) |
| `type(string $value)` | Card type / crew name |
| `keyword(string $value)` | Keyword ability |
| `pack(string $id)` | Filter by pack ID |
| `cardSet(string $value)` | Filter by card set (e.g. `'OP-01'`) |
| `search(string $query)` | Full-text search |
| `altArt(bool $value)` | Include/exclude alternate art variants |
| `perPage(int $value)` | Results per page |
| `page(int $value)` | Page number |

---

## Error handling

All API errors throw exceptions that extend `Ditshej\OpCards\Exceptions\ApiException`:

| Exception | HTTP status |
|---|---|
| `AuthenticationException` | 401 |
| `NotFoundException` | 404 |
| `RateLimitException` | 429 |
| `ApiException` | all other errors |

All exceptions expose `getStatusCode(): int` in addition to the standard `getMessage()` and `getCode()`.
