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

## Change 8: `exception-getstatuscode`

Add `getStatusCode(): int` convenience method to `ApiException`.
Allows callers to use a semantic method instead of `getCode()`.

- `src/Exceptions/ApiException.php`

## Change 9: `pagination-filter`

Add `page(int $value)` method to `CardFilter` to allow requesting specific pages.

- `src/Filters/CardFilter.php`

## Change 10: `laravel-config-integration`

Replace `getenv()` with Laravel's `config()` system in the ServiceProvider.
Publish `config/opcards.php` so users can override via Laravel's config pipeline
(supports `config:cache`, per-environment overrides, `Config::set()` in tests).
Guards for missing token and base URI are included.

- `src/Laravel/OpCardsServiceProvider.php`
- `config/opcards.php` (new)

## Change 11: `card-filter-multivalue`

Support multi-value filtering for `cost` and `power` in `CardFilter`.
Uses variadic syntax: `->cost(3, 5, 7)` sends `cost[]=3&cost[]=5&cost[]=7`.
Single-value call `->cost(5)` keeps the existing `cost=5` behaviour.
Depends on Change 9 (`pagination-filter`).

- `src/Filters/CardFilter.php`

## Change 12: `auto-pagination`

Add `allCards(?CardFilter $filter = null): array` to `OpCardsClient`.
Fetches all pages automatically and returns a flat `CardResource[]`.
Depends on Change 9 (`pagination-filter`).

- `src/OpCardsClient.php`

## Change 13: `add-readme`

Write `README.md` covering installation, required configuration
(`OPCARDS_TOKEN`, `OPCARDS_BASE_URI`), standalone usage, Laravel integration,
available methods, `CardFilter` usage, and the target API version.
Depends on Changes 8–12 (documents the final state of the SDK).

- `README.md` (new)
