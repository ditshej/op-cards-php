## 1. Tests (write first)

- [x] 1.1 Write test: `OpCardsClient` uses a custom base URI for outbound requests
- [x] 1.2 Write test: `OpCardsClient` uses the default base URI when none is given
- [x] 1.3 Write test: `OpCardsServiceProvider` passes `OPCARDS_BASE_URI` env value to the client

## 2. Implementation

- [x] 2.1 Add `string $baseUri` as the second constructor parameter in `OpCardsClient` (with default), use it when building the default Guzzle client
- [x] 2.2 Fix `makeClient()` in `tests/Pest.php` — pass `$http` as the third argument
- [x] 2.3 Update `OpCardsServiceProvider` to pass `OPCARDS_BASE_URI` as the second constructor argument
