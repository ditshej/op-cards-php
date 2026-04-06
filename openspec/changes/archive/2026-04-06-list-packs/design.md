## Context

`OpCardsClient` already has a `request()` method that handles authentication, JSON decoding, and exception mapping. The pack endpoints wrap `request()` with typed return values. `PackResource` needs a `fromArray()` factory so the client can hydrate API arrays into DTOs without coupling the client to the DTO's constructor signature.

## Goals / Non-Goals

**Goals:**
- Add `packs()` and `pack(string $id)` to `OpCardsClient`
- Add `PackResource::fromArray(array $data): self` static factory
- Keep hydration logic on the resource, not the client

**Non-Goals:**
- No pagination
- No retry or timeout configuration
- No Laravel facades

## Decisions

### Static `fromArray()` factory on the resource

`PackResource::fromArray(array $data): self` constructs a `PackResource` from a raw API response array.

**Why:** Keeps construction logic close to the DTO. The client stays thin — it calls `PackResource::fromArray($item)` rather than inlining field mapping. This pattern will be reused by `CardResource` in `list-cards`.

**Alternatives considered:** Hydrator class (`PackHydrator`); rejected as over-engineering for a simple DTO with three fields.

---

### API paths

- `GET /packs` → `packs()`
- `GET /packs/{id}` → `pack(string $id)`

Response envelope: the API returns `{ "data": [...] }` for collections and `{ "data": {...} }` for single resources. Both endpoints unwrap `data` before hydrating.

**Note:** If the actual API shape differs, the tests will fail and the path/envelope handling must be updated.

## Risks / Trade-offs

- **API response shape is assumed** — `data` key envelope is inferred from convention. If the API returns a flat array, `packs()` will fail with an undefined index.
  → Mitigation: mock tests make this explicit. Real integration tests can catch it.

## Open Questions

<!-- none -->
