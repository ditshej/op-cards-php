# Roadmap

Planned changes in implementation order.

## Change 1: `exception-hierarchy`

Define the exception types the client throws.

- `src/Exceptions/ApiException.php` — base exception
- `src/Exceptions/AuthenticationException.php` — 401
- `src/Exceptions/NotFoundException.php` — 404
- `src/Exceptions/RateLimitException.php` — 429

## Change 2: `http-client-core`

Core HTTP client with Bearer-token auth, Guzzle, JSON response handling,
and exception mapping from HTTP status codes.

- `src/OpCardsClient.php`

## Change 3: `card-and-pack-resources`

Typed readonly DTOs for API responses.

- `src/Resources/CardResource.php`
  Fields: id, pack_id, card_set, name, rarity, category, colors[], cost,
  power, counter, attributes[], types[], effect, trigger, img_url, alt_art_variant
- `src/Resources/PackResource.php`
  Fields: id, name, label

## Change 4: `list-packs`

Implement pack endpoints on the client, returning typed resources.

- `OpCardsClient::packs()` → `PackResource[]`
- `OpCardsClient::pack(string $id)` → `PackResource`

## Change 5: `list-cards`

Implement card endpoints on the client with pagination support.

- `OpCardsClient::cards(?CardFilter $filter)` → paginated result with `CardResource[]`
- `OpCardsClient::card(string $id)` → `CardResource`

## Change 6: `card-filter`

Fluent filter builder for the `GET /cards` endpoint.

- `src/Filters/CardFilter.php`
  Methods: `color()`, `category()`, `cost()`, `costBetween()`, `powerBetween()`,
  `pack()`, `search()`, `rarity()`, `attribute()`, `type()`, `keyword()`,
  `cardSet()`, `altArt()`, `perPage()`

## Change 7: `laravel-integration`

Optional Laravel integration via ServiceProvider and Facade.

- `src/Laravel/OpCardsServiceProvider.php`
- `src/Laravel/Facades/OpCards.php`
