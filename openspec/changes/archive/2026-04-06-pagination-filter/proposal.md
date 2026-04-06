## Why

`CardFilter` exposes `perPage()` to control result set size but provides no way to request a specific page number. Without a `page()` method, callers cannot navigate beyond the first page of results — manual pagination is impossible. This is also the prerequisite for the planned `auto-pagination` change, which requires the SDK to be able to advance pages programmatically.

## What Changes

- Add `page(int $value): static` method to `CardFilter` that maps to the `page` query parameter
- No changes to `OpCardsClient`, response shape, or any other class

## Capabilities

### New Capabilities

<!-- None — this extends an existing capability rather than introducing a new contract -->

### Modified Capabilities

- `card-filter`: Add `page` as a supported filter parameter with the same fluent setter pattern used by all existing methods

## Non-goals

- Auto-pagination or any iteration abstraction — that is a separate change
- Adding `page()` to any other filter class (none currently exist)
- Validating page numbers (e.g. rejecting values < 1) — the API is responsible for validation

## Impact

- `src/Filters/CardFilter.php` — one method added
- `tests/Filters/CardFilterTest.php` — new scenario covering `page()` sets `page` key
- `openspec/specs/card-filter/spec.md` — delta scenario added for the new method
- No breaking changes; fully additive
