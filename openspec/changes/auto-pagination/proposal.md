## Why

Callers who need the complete card catalogue must currently drive pagination themselves — calling `cards()`, inspecting `meta`, incrementing the page, and looping until exhausted. This is repetitive boilerplate that every consumer has to re-implement. A first-class `allCards()` method removes that burden and provides a single, well-tested path to a flat `CardResource[]`.

## What Changes

- Add `allCards(?CardFilter $filter = null): array` to `OpCardsClient`
- The method calls `cards()` in a loop, starting at page 1, merging each page's `data` into an accumulator, and stopping when `meta['current_page'] >= meta['last_page']`
- Any `CardFilter` passed by the caller is used for all requests; the method overrides only the `page` parameter on each iteration
- If no filter is supplied, a fresh `CardFilter` is created internally
- Returns a flat `CardResource[]`; the caller never sees pagination metadata

## Capabilities

### New Capabilities

- `all-cards`: Automatic multi-page card fetching that returns a single flat `CardResource[]` array

### Modified Capabilities

<!-- None — `list-cards` requirements are unchanged; `allCards()` is purely additive and delegates to the existing `cards()` method -->

## Non-goals

- Auto-pagination for packs or any other resource
- Streaming or generator-based iteration — full array only
- Configurable page size within this method — callers control that via `CardFilter::perPage()`
- Cancellation or partial results on error — any API error propagates as-is

## Impact

- `src/OpCardsClient.php` — `allCards()` method added
- `tests/OpCardsClientTest.php` — new test scenarios for the method
- Depends on `pagination-filter` change (`CardFilter::page()` must exist)
- No breaking changes; fully additive
