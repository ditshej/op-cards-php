## 1. Preparation

- [x] 1.1 Verify all preceding changes (8–12) are merged to `main` and the public SDK surface is stable
- [x] 1.2 Review `OpCardsClient` public methods to confirm signatures for `packs()`, `pack($id)`, `cards()`, `card($id)`, and `allCards()`
- [x] 1.3 Review `CardFilter` public API to confirm all chainable methods and their argument types

## 2. Write README.md

- [x] 2.1 Add package description section (PHP SDK for the One Piece TCG card API)
- [x] 2.2 Add installation section (`composer require ditshej/op-cards-php`)
- [x] 2.3 Add configuration section documenting `OPCARDS_TOKEN` and `OPCARDS_BASE_URI` as required environment variables
- [x] 2.4 Add standalone usage section with `OpCardsClient` instantiation example
- [x] 2.5 Add Laravel integration section covering ServiceProvider auto-discovery, Facade usage, and config publishing
- [x] 2.6 Add available methods section with all five methods and brief descriptions
- [x] 2.7 Add `CardFilter` section with a fluent chaining example
- [x] 2.8 Add API version compatibility note (no stable v1; both SDK and upstream API are in active development)

## 3. Review

- [x] 3.1 Read through the full README as a first-time user and confirm all steps are self-contained and correct
- [x] 3.2 Verify every code example compiles against the actual implemented classes
