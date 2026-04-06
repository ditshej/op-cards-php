## Context

`CardFilter` is a fluent query-parameter builder. Every method sets a key in a private `$params` array and returns `$this`. The `perPage()` method already maps `per_page` using this pattern. Adding `page()` is a direct extension of the same pattern — no new concepts are introduced.

## Goals / Non-Goals

**Goals:**
- Add `page(int $value): static` to `CardFilter` following the existing fluent setter pattern
- Cover the new method with a Pest test before implementation (TDD)
- Update the `card-filter` spec with the new scenario

**Non-Goals:**
- Auto-pagination, cursor-based pagination, or any iteration helper
- Input validation of the page value
- Changes to the HTTP layer or response parsing

## Decisions

**Use `page` as the query parameter key** — mirrors the API's own parameter name and is consistent with how `per_page` is mapped by `perPage()`. No translation or aliasing needed.

**No separate class or trait** — the change is a single method addition. Extracting pagination concerns into a trait or base class would be premature given only two pagination-related methods exist.

## Risks / Trade-offs

[Page value not validated] → The API returns an error response for invalid values; the SDK surfaces this as an `ApiException` through the existing error-handling path. No additional handling needed.

## Migration Plan

No migration required. The method is additive; existing callers are unaffected.
