## Context

`OpCardsClient::cards()` returns `['data' => CardResource[], 'meta' => array]`. The `meta` array includes `current_page` and `last_page` fields from the API. The `pagination-filter` change adds `CardFilter::page(int): static`, which is the prerequisite for this feature.

The method must work with an optional caller-supplied `CardFilter`. When a filter is provided it carries the caller's query constraints (pack, color, rarity, etc.) across every page request; only the `page` parameter changes per iteration.

## Goals / Non-Goals

**Goals:**
- Provide a single method that returns all cards matching an optional filter as a flat `CardResource[]`
- Reuse `cards()` entirely — no direct HTTP calls inside `allCards()`
- Remain stateless: the original `$filter` passed by the caller is not mutated

**Non-Goals:**
- Lazy/streaming iteration
- Pagination for any resource other than cards
- Retry logic or error recovery within the loop

## Decisions

### Cloning the filter per page

**Decision:** Call `$filter->page($page)` on each iteration without cloning; `page()` returns `$this`, so the same instance is reused across iterations.

**Why:** `CardFilter` is a simple value object with no side effects beyond accumulating query parameters. Mutating the page on each iteration is safe and avoids unnecessary object allocation. The caller's original variable is unaffected because PHP passes objects by reference handle — the caller holds a reference to the same instance, but `page()` merely overwrites a scalar property, so any subsequent `toQuery()` call by the caller after `allCards()` returns would reflect the last page used. This is acceptable: the method is not designed for concurrent use, and callers should not inspect the filter after passing it.

**Alternative considered:** Clone the filter before the loop and operate on the clone. This would be safer but adds complexity for a class with no meaningful clone semantics today.

### Loop termination condition

**Decision:** Stop when `$meta['current_page'] >= $meta['last_page']`.

**Why:** Using `>=` rather than `===` is defensive — if the API ever returns a `current_page` beyond `last_page` for an empty result set, the loop still terminates rather than running indefinitely.

### Default filter when none supplied

**Decision:** Instantiate `new CardFilter` internally when `$filter` is `null`.

**Why:** Avoids a null-check branch inside the loop body. A fresh `CardFilter` with only `page` set produces a minimal query string, matching the behaviour of `cards(null)` on page 1.

## Risks / Trade-offs

- **Large catalogues cause a large number of sequential HTTP requests** → Mitigation: callers can narrow scope with filter parameters (e.g. `pack()`). No batching or concurrency is in scope.
- **API response shape changes** → If `meta` keys are renamed, the loop will not terminate. Mitigation: covered by existing `list-cards` spec; a breaking API change would surface in tests.
- **Filter mutation visible to caller after call** → The `page` property on the caller's `CardFilter` will be set to the last page fetched. This is documented implicitly by the method signature and is an acceptable trade-off given the stateless, synchronous use case.

## Open Questions

- None at this time. The loop logic and filter contract are fully determined by the existing `cards()` and `CardFilter` implementations.
