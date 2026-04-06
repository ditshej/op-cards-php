## 1. Tests (write first)

- [x] 1.1 Write test: empty `CardFilter` produces empty query array
- [x] 1.2 Write test: each single-value method sets the correct query key (dataset)
- [x] 1.3 Write test: `costBetween()` sets `cost_min` and `cost_max`
- [x] 1.4 Write test: `powerBetween()` sets `power_min` and `power_max`
- [x] 1.5 Write test: `altArt(true)` sets `alt_art` to `1`
- [x] 1.6 Write test: multiple methods chain and produce all set keys
- [x] 1.7 Update test: `cards()` query-forwarding test uses `CardFilter` instead of raw array

## 2. Implementation

- [x] 2.1 Create `src/Filters/CardFilter.php` with all fluent methods and `toQuery()`
- [x] 2.2 Update `OpCardsClient::cards()` signature to `?CardFilter $filter = null`
