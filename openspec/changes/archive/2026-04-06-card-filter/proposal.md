## Why

`OpCardsClient::cards()` accepts a raw `?array $query` but callers have no type-safe way to construct it. `CardFilter` provides a fluent builder that enforces correct parameter names and converts to a query array — eliminating guesswork and documentation lookups.

## What Changes

- Introduce `src/Filters/CardFilter.php` — fluent builder for `GET /cards` query parameters
- Update `OpCardsClient::cards()` to accept `?CardFilter $filter = null` instead of `?array $query`

## Capabilities

### New Capabilities

- `card-filter`: Fluent builder for constructing typed card search parameters, convertible to a query array

### Modified Capabilities

- `list-cards`: `OpCardsClient::cards()` signature changes from `?array $query` to `?CardFilter $filter` — **BREAKING** for any caller passing a raw array

## Impact

- **New file**: `src/Filters/CardFilter.php`
- **New tests**: `tests/Filters/CardFilterTest.php`
- **Modified**: `src/OpCardsClient.php` — update `cards()` signature
- **Modified**: `tests/OpCardsClientTest.php` — update cards query-forwarding test

## Non-goals

- No validation of filter values (e.g. valid color names)
- No combining filters with AND/OR logic
- No server-side pagination integration (page/cursor)
