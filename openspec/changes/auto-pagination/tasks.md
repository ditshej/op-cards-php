## 1. Spec

- [x] 1.1 Create `openspec/specs/all-cards/spec.md` with requirements and scenarios for `allCards()`

## 2. Tests

- [x] 2.1 Add test: `allCards()` with a single page returns a flat `CardResource[]`
- [x] 2.2 Add test: `allCards()` with multiple pages merges all pages into one flat array
- [x] 2.3 Add test: `allCards()` stops after the last page (`current_page === last_page`)
- [x] 2.4 Add test: `allCards(null)` uses a fresh `CardFilter` with `page` set per iteration
- [x] 2.5 Add test: `allCards($filter)` forwards caller's filter constraints on every request

## 3. Implementation

- [x] 3.1 Add `allCards(?CardFilter $filter = null): array` to `OpCardsClient`
- [x] 3.2 Implement the loop: start at page 1, call `cards()`, merge `data`, stop when `current_page >= last_page`

## 4. Cleanup

- [x] 4.1 Run `composer lint` and fix any Pint violations
- [x] 4.2 Run `composer test` and confirm all tests pass
