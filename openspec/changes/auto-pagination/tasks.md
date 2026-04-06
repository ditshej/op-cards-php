## 1. Spec

- [ ] 1.1 Create `openspec/specs/all-cards/spec.md` with requirements and scenarios for `allCards()`

## 2. Tests

- [ ] 2.1 Add test: `allCards()` with a single page returns a flat `CardResource[]`
- [ ] 2.2 Add test: `allCards()` with multiple pages merges all pages into one flat array
- [ ] 2.3 Add test: `allCards()` stops after the last page (`current_page === last_page`)
- [ ] 2.4 Add test: `allCards(null)` uses a fresh `CardFilter` with `page` set per iteration
- [ ] 2.5 Add test: `allCards($filter)` forwards caller's filter constraints on every request

## 3. Implementation

- [ ] 3.1 Add `allCards(?CardFilter $filter = null): array` to `OpCardsClient`
- [ ] 3.2 Implement the loop: start at page 1, call `cards()`, merge `data`, stop when `current_page >= last_page`

## 4. Cleanup

- [ ] 4.1 Run `composer lint` and fix any Pint violations
- [ ] 4.2 Run `composer test` and confirm all tests pass
