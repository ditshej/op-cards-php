## 1. Setup

- [ ] 1.1 Add `illuminate/support` and `illuminate/container` to `require-dev` in composer.json and run `composer update`

## 2. Tests (write first)

- [ ] 2.1 Write test: `OpCardsServiceProvider` binds `OpCardsClient` as a resolvable singleton
- [ ] 2.2 Write test: `OpCards` facade accessor returns `OpCardsClient::class`

## 3. Implementation

- [ ] 3.1 Create `src/Laravel/OpCardsServiceProvider.php`
- [ ] 3.2 Create `src/Laravel/Facades/OpCards.php`
