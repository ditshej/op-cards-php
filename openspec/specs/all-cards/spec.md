# all-cards Specification

## Purpose

Provides a single method that fetches all cards matching an optional filter by automatically iterating through all pages and returning a flat `CardResource[]` array.

## Requirements

### Requirement: allCards() returns a flat array of all cards across all pages

`OpCardsClient::allCards(?CardFilter $filter = null): array` SHALL call `cards()` in a loop starting at page 1, merging each page's `data` into an accumulator, and SHALL stop when `meta['current_page'] >= meta['last_page']`.

The return value SHALL be a flat `CardResource[]` containing all cards from all pages.

#### Scenario: Single page returns flat array

- **WHEN** `$client->allCards()` is called and the API returns a single page (`current_page === last_page === 1`)
- **THEN** a flat `CardResource[]` of that page's cards is returned

#### Scenario: Multiple pages are merged

- **WHEN** `$client->allCards()` is called and the API returns multiple pages
- **THEN** the method calls `cards()` once per page and returns all cards merged into a single flat array

#### Scenario: Loop stops after last page

- **WHEN** `$client->allCards()` is called and `meta['current_page'] === meta['last_page']`
- **THEN** no further requests are made

### Requirement: allCards() uses a fresh filter when none is supplied

When `$filter` is `null`, `allCards()` SHALL instantiate a fresh `CardFilter` internally and set the `page` parameter on each iteration.

#### Scenario: allCards(null) uses internal fresh filter

- **WHEN** `$client->allCards()` is called with `null`
- **THEN** the request on page 1 includes `page=1` in the query string and subsequent pages include the correct page number

### Requirement: allCards() forwards caller's filter constraints on every request

When a `CardFilter` is provided, `allCards()` SHALL preserve all caller-supplied filter constraints across every page request; only the `page` parameter is changed per iteration.

#### Scenario: Caller's filter constraints forwarded

- **WHEN** `$client->allCards((new CardFilter)->pack('OP01'))` is called
- **THEN** every outbound request includes `pack_id=OP01` in the query string
