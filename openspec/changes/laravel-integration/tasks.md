## 1. Setup

- [x] 1.1 Add `illuminate/support` and `illuminate/container` to `require-dev` in composer.json and run `composer update`

## 2. Tests (write first)

- [x] 2.1 Write test: `OpCardsServiceProvider` binds `OpCardsClient` as a resolvable singleton
- [x] 2.2 Write test: `OpCards` facade accessor returns `OpCardsClient::class`

## 3. Implementation

- [x] 3.1 Create `src/Laravel/OpCardsServiceProvider.php`
- [x] 3.2 Create `src/Laravel/Facades/OpCards.php`
