## Context

`list-packs` established the pattern: a `fromArray()` factory on the resource, thin endpoint methods on the client. `list-cards` replicates that pattern for cards and adds pagination — the API's `GET /cards` response includes a `meta` object with `current_page`, `last_page`, `per_page`, and `total`.

The `card-filter` change (next) will add a `CardFilter` class. To avoid coupling this change to that one, `cards()` accepts an optional `?array $query = null` parameter internally and passes it as Guzzle query params. When `card-filter` lands, it will provide the query array via a `toQuery()` method.

## Goals / Non-Goals

**Goals:**
- Add `cards(?array $query = null)` and `card(string $id)` to `OpCardsClient`
- Add `CardResource::fromArray(array $data): self`
- Return a simple paginated result shape for `cards()`: `['data' => CardResource[], 'meta' => array]`

**Non-Goals:**
- No `CardFilter` class here — that is `card-filter`
- No dedicated `PaginatedResult` DTO — a plain array with `data` and `meta` keys is sufficient for now

## Decisions

### Return shape for `cards()`

`cards()` returns `array{data: CardResource[], meta: array}` — a plain PHP array with two keys.

**Why:** Avoids introducing a `PaginatedResult` DTO in this change. The meta shape is opaque at this stage; wrapping it in a typed class would require knowing all pagination fields upfront. A plain array defers that decision to a future change without losing information.

**Alternatives considered:** Typed `PaginatedResult` class; deferred to a later change if needed.

---

### `cards()` signature accepts `?array $query`

```php
public function cards(?array $query = null): array
```

The `card-filter` change will call `cards($filter->toQuery())`. This keeps `list-cards` standalone.

## Risks / Trade-offs

- **`meta` is untyped** — callers get a raw array for pagination metadata. Breaking changes in the API meta shape go undetected.
  → Acceptable at v1.

## Open Questions

<!-- none -->
