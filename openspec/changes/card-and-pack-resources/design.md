## Context

The SDK will eventually return typed objects from its endpoint methods. Before implementing those endpoints, the DTO classes must exist. This change defines the data shapes exactly as documented in the API (ROADMAP.md), so downstream changes can reference concrete types.

## Goals / Non-Goals

**Goals:**
- Define `CardResource` and `PackResource` as readonly PHP classes
- Match field names exactly to the API response keys (snake_case)
- Keep DTOs pure — no methods beyond construction

**Non-Goals:**
- No `fromArray()` factory — hydration logic belongs with the HTTP layer
- No nullable coercion or default values beyond what the API guarantees
- No serialization helpers

## Decisions

### Readonly constructor-promoted properties

Both DTOs use `readonly` properties with constructor promotion. This makes them immutable, concise, and immediately usable after construction without manual assignment.

**Why:** Aligns with project PHP standards (constructor property promotion, typed properties). Readonly enforces immutability without extra code.

---

### Nullable fields for optional API data

Fields that the API may omit (`effect`, `trigger`, `img_url`, `alt_art_variant`, `cost`, `power`) are typed as `?string` / `?int`. Fields that are always present are typed non-nullable.

**Why:** Reflects actual API contract. Using non-nullable types for optional fields would cause construction errors when the API omits them.

---

### Array fields typed as `array`

`colors`, `attributes`, `types` are typed as plain `array`. No generic collection wrapper at this stage.

**Why:** PHP has no native generic arrays. Typed collections add complexity (separate classes) for marginal benefit at this stage.

## Risks / Trade-offs

- **Array typing is loose** — `array` for `colors[]` doesn't enforce element types. A malformed API response could pass type checks.
  → Acceptable at v1; strict typed collections can be added later.

- **Hydration is deferred** — DTOs cannot construct themselves from raw API arrays without a factory. The next changes (list-packs, list-cards) must add `fromArray()` or inline construction.
  → Intentional: keeps this change minimal and focused.

## Open Questions

<!-- none -->
