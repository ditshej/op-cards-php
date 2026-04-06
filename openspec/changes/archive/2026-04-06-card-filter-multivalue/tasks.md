## 1. Tests

- [x] 1.1 Add scenario to `tests/Filters/CardFilterTest.php`: single-value `->cost(5)` still emits `['cost' => 5]`
- [x] 1.2 Add scenario to `tests/Filters/CardFilterTest.php`: multi-value `->cost(3, 5, 7)` emits `['cost' => [3, 5, 7]]`
- [x] 1.3 Add scenario to `tests/Filters/CardFilterTest.php`: `->cost()` with no arguments does not include `cost` in `toQuery()`

## 2. Spec Delta

- [x] 2.1 Add delta scenarios to `openspec/specs/card-filter/spec.md` covering single-value, multi-value, and empty-variadic behaviour of `cost()`

## 3. Implementation

- [x] 3.1 Change `cost(int $value): static` to `cost(int ...$values): static` in `src/Filters/CardFilter.php`
- [x] 3.2 Update the parameter-building logic: store scalar for one value, array for multiple values, nothing for zero values

## 4. Verification

- [x] 4.1 Run `composer test` — all tests pass
- [x] 4.2 Run `vendor/bin/pint --dirty` — no formatting issues
