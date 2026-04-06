## Why

The `GET /cards` API now supports array-style filtering for `cost` (`?cost[]=3&cost[]=5&cost[]=7`), but `CardFilter::cost()` accepts only a single integer. Callers who want to filter by a set of discrete cost values must make separate requests or resort to `costBetween()`, which does not express the same intent.

## What Changes

- Change `cost(int $value): static` to `cost(int ...$values): static` in `CardFilter`
- Single-value call `->cost(5)` continues to emit `cost=5` (no breaking change for existing callers)
- Multi-value call `->cost(3, 5, 7)` emits `cost[]=3&cost[]=5&cost[]=7`

## Capabilities

### New Capabilities

<!-- None — this extends an existing capability rather than introducing a new contract -->

### Modified Capabilities

- `card-filter`: `cost()` gains variadic arity; multi-value calls produce an array-style query parameter instead of a scalar

## Non-goals

- Making other filter methods (`color`, `rarity`, `attribute`, etc.) variadic — only `cost` is exposed as multi-select by the API at this time
- Validating that at least one value is supplied — the API is responsible for validation
- Changing `costBetween()` — range filtering and discrete-value filtering remain separate concerns

## Impact

- `src/Filters/CardFilter.php` — signature change on `cost()` and updated parameter-building logic
- `tests/Filters/CardFilterTest.php` — new scenarios for single-value unchanged behaviour and multi-value array output
- `openspec/specs/card-filter/spec.md` — delta scenarios for variadic `cost()`
- No changes to `OpCardsClient`, response shape, or any other class
- Depends on `pagination-filter` landing first (both touch `CardFilter`), but the two changes are otherwise independent
