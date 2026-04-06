## Context

`cards()` currently takes `?array $query` which is flexible but untyped. `CardFilter` wraps the same query array with named methods, each mapping to a specific API query parameter. The filter converts itself to an array via `toQuery()` which `cards()` passes to Guzzle.

## Goals / Non-Goals

**Goals:**
- Provide a fluent, typed API for all documented `GET /cards` filter parameters
- `toQuery()` returns only keys with non-null values
- `cards(?CardFilter $filter)` accepts the filter and forwards `$filter->toQuery()`

**Non-Goals:**
- No validation of filter values
- No pagination parameters (`page`, `per_page`) in this filter — those can be added later
- No Laravel-specific macro or facade integration

## Decisions

### Fluent interface with method chaining

Each filter method sets a property and returns `$this`, enabling `(new CardFilter)->color('Red')->rarity('L')`.

**Why:** Idiomatic for builder objects. Callers don't need to remember parameter names.

---

### `toQuery()` omits null values

Only parameters that were explicitly set are included in the output array. Unset parameters are omitted entirely.

**Why:** Sending `pack_id=null` to the API would be invalid. Omitting unset keys is the correct REST behavior.

---

### Methods map 1:1 to API query parameters

| Method | Query key |
|--------|-----------|
| `color(string)` | `color` |
| `category(string)` | `category` |
| `cost(int)` | `cost` |
| `costBetween(int, int)` | `cost_min`, `cost_max` |
| `powerBetween(int, int)` | `power_min`, `power_max` |
| `pack(string)` | `pack_id` |
| `search(string)` | `q` |
| `rarity(string)` | `rarity` |
| `attribute(string)` | `attribute` |
| `type(string)` | `type` |
| `keyword(string)` | `keyword` |
| `cardSet(string)` | `card_set` |
| `altArt(bool)` | `alt_art` |
| `perPage(int)` | `per_page` |

**Why:** Transparent mapping makes it easy to verify which API parameter a method sets.

## Risks / Trade-offs

- **Breaking change for `cards()`** — any existing caller using `cards(['pack_id' => 'OP01'])` must switch to `cards((new CardFilter)->pack('OP01'))`. Since the SDK is pre-release, this is acceptable.

## Open Questions

<!-- none -->
