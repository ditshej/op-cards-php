# op-cards-php

PHP SDK for the [One Piece TCG card API](https://github.com/ditshej/one-piece-cards-api) — framework-agnostic core with optional Laravel integration.

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
| `OPCARDS_TOKEN` | Bearer token for API authentication |
| `OPCARDS_BASE_URI` | Base URL of the API, e.g. `https://op-cards.ditshej.ch/api/` |

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
OPCARDS_BASE_URI=https://op-cards.ditshej.ch/api/
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
