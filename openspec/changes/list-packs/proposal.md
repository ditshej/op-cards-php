## Why

The client needs endpoint methods for fetching packs. Without them the SDK cannot retrieve any data. `list-packs` is the first set of endpoint methods — it also introduces the hydration pattern (`fromArray()`) that `list-cards` will reuse.

## What Changes

- Add `OpCardsClient::packs()` → returns `PackResource[]`
- Add `OpCardsClient::pack(string $id)` → returns `PackResource`
- Add `PackResource::fromArray(array $data)` static factory for hydration

## Capabilities

### New Capabilities

- `list-packs`: Endpoint methods on `OpCardsClient` that fetch one or all packs and return typed `PackResource` instances

### Modified Capabilities

- `pack-resource`: Add `fromArray(array $data): self` static factory for constructing a `PackResource` from a raw API array

## Impact

- **Modified**: `src/Resources/PackResource.php` — add `fromArray()`
- **Modified**: `src/OpCardsClient.php` — add `packs()` and `pack()` methods
- **Modified**: `tests/Resources/PackResourceTest.php` — add `fromArray` tests
- **Modified**: `tests/OpCardsClientTest.php` — add endpoint tests

## Non-goals

- No pagination support — packs is a small, complete list
- No caching or lazy loading
- No card endpoints — those come in `list-cards`
