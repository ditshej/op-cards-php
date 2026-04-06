## Context

`CardFilter::cost(int $value)` currently stores a scalar under the `cost` key, which Guzzle serialises as `?cost=5`. The API now also accepts `?cost[]=3&cost[]=5&cost[]=7`, which requires a PHP array value. Guzzle serialises `['cost' => [3, 5, 7]]` as `cost[]=3&cost[]=5&cost[]=7` automatically, so no custom encoding layer is needed.

The change is additive at the call site: `->cost(5)` remains valid syntax under a variadic signature.

## Goals / Non-Goals

**Goals:**

- Accept one or more `int` values via a variadic parameter
- Emit a scalar query value for a single argument and an array query value for multiple arguments
- Keep `toQuery()` returning a plain array with no extra encoding logic — Guzzle handles the rest

**Non-Goals:**

- Extending variadic behaviour to other filter methods
- Adding a custom HTTP query encoder
- Deduplicating repeated cost values — callers are responsible for their input

## Decisions

**Variadic signature over `array` parameter**

`cost(int ...$values)` enforces that every element is an `int` at the call site and preserves a fluent, readable API (`->cost(3, 5, 7)` vs `->cost([3, 5, 7])`). An `array` parameter would require a docblock for type information and permit non-integer elements without a cast.

**Scalar vs array in `toQuery()` based on count**

When exactly one value is passed, `toQuery()` stores the scalar integer under `cost`; when two or more are passed, it stores the array under `cost`. This preserves backward-compatible wire format for single-value calls (`cost=5` not `cost[]=5`) and produces the correct array format for multi-value calls.

**No empty-variadic guard**

Calling `->cost()` with no arguments stores an empty array under `cost`, which Guzzle omits from the query string. This is harmless and avoids a conditional throw that would complicate the implementation without a real use case.

## Risks / Trade-offs

[Risk] Some HTTP clients or proxies do not support bracket-notation array params → Guzzle encodes PHP arrays using PHP bracket notation by default; the API already documents this format, so no custom encoder is required.

[Risk] Merge conflict with `pagination-filter` if both branches modify `CardFilter` concurrently → Resolve by rebasing `card-filter-multivalue` onto the merged `pagination-filter` branch before implementation; the two changes touch different methods so conflicts will be minimal.

## Migration Plan

No migration needed. Existing callers using `->cost(5)` are unaffected — the variadic signature is source-compatible with a single positional argument.

## Open Questions

None. Scope is fully defined.
