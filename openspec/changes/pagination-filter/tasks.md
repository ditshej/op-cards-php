## 1. Spec

- [ ] 1.1 Add delta scenario to `openspec/specs/card-filter/spec.md` covering `page()` sets the `page` key

## 2. Tests

- [ ] 2.1 Add test in `tests/Filters/CardFilterTest.php` asserting `(new CardFilter)->page(2)->toQuery()` returns `['page' => 2]`
- [ ] 2.2 Add test asserting `page()` is chainable with other filter methods

## 3. Implementation

- [ ] 3.1 Add `page(int $value): static` method to `src/Filters/CardFilter.php`

## 4. Housekeeping

- [ ] 4.1 Run `composer lint` and fix any style issues
- [ ] 4.2 Run `composer test` and confirm all tests pass
