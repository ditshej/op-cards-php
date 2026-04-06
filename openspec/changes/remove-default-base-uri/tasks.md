## 1. Tests (update first)

- [ ] 1.1 Add test: omitting `$baseUri` throws `ArgumentCountError`
- [ ] 1.2 Update `makeClient()` in `tests/Pest.php` — remove default from `$baseUri`
- [ ] 1.3 Update `tests/OpCardsClientTest.php` — pass explicit URI where `new OpCardsClient` is called directly
- [ ] 1.4 Update `tests/Laravel/OpCardsServiceProviderTest.php` — ensure `OPCARDS_BASE_URI` is set in all tests

## 2. Implementation

- [x] 2.1 Remove default from `$baseUri` in `src/OpCardsClient.php`
- [x] 2.2 Remove hardcoded fallback URI from `src/Laravel/OpCardsServiceProvider.php`
