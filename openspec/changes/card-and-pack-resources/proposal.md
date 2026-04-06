## Why

API responses from the op-cards API need to be returned as typed PHP objects rather than raw arrays. Typed readonly DTOs give callers autocomplete, static analysis, and predictable shapes — without any framework dependency.

## What Changes

- Introduce `CardResource` as a typed readonly DTO for card API responses
- Introduce `PackResource` as a typed readonly DTO for pack API responses

## Capabilities

### New Capabilities

- `card-resource`: Typed readonly DTO representing a card from the API, with all documented fields
- `pack-resource`: Typed readonly DTO representing a pack from the API, with id, name, and label

### Modified Capabilities

<!-- none -->

## Impact

- **New files**: `src/Resources/CardResource.php`, `src/Resources/PackResource.php`
- **New tests**: `tests/Resources/CardResourceTest.php`, `tests/Resources/PackResourceTest.php`
- **No changes** to `OpCardsClient` or exceptions

## Non-goals

- No hydration logic on the client — that comes with the endpoint changes (list-packs, list-cards)
- No validation or transformation of field values
- No API calls
