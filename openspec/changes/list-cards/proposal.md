## Why

The SDK needs card endpoint methods to be useful. `list-cards` adds `cards()` and `card()` to the client, following the same pattern established by `list-packs`. It also adds `CardResource::fromArray()` for hydration and introduces pagination metadata for the collection endpoint.

## What Changes

- Add `OpCardsClient::cards(?CardFilter $filter = null)` → paginated result containing `CardResource[]` plus pagination metadata
- Add `OpCardsClient::card(string $id)` → `CardResource`
- Add `CardResource::fromArray(array $data): self` static factory

## Capabilities

### New Capabilities

- `list-cards`: Endpoint methods on `OpCardsClient` that fetch one card by ID or a paginated list of cards, returning typed `CardResource` instances

### Modified Capabilities

- `card-resource`: Add `fromArray(array $data): self` static factory for constructing a `CardResource` from a raw API array

## Impact

- **Modified**: `src/Resources/CardResource.php` — add `fromArray()`
- **Modified**: `src/OpCardsClient.php` — add `cards()` and `card()` methods
- **Modified**: `tests/Resources/CardResourceTest.php` — add `fromArray` test
- **Modified**: `tests/OpCardsClientTest.php` — add endpoint tests

## Non-goals

- `CardFilter` parameter is accepted but not yet implemented — it comes in `card-filter`. For now, `cards()` ignores any filter argument.
- No response envelope validation beyond accessing `data`
- No cursor-based pagination
