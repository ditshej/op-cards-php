## Why

The SDK is a generic layer over any deployment of the `one-piece-cards-api`. Shipping `https://op-cards.ditshej.ch/api/` as the default base URI bakes one specific deployment into the library — every other user gets the wrong default silently. `$baseUri` must be a required parameter so callers are forced to provide their own endpoint.

## What Changes

- **BREAKING**: Remove the default value from `$baseUri` in `OpCardsClient` — callers must now supply it explicitly
- Update `OpCardsServiceProvider` to require `OPCARDS_BASE_URI` to be set (no fallback default)

## Capabilities

### New Capabilities

<!-- none -->

### Modified Capabilities

- `http-client`: `OpCardsClient` constructor — `$baseUri` becomes a required parameter with no default **BREAKING**

## Impact

- **Modified**: `src/OpCardsClient.php` — remove default from `$baseUri`
- **Modified**: `src/Laravel/OpCardsServiceProvider.php` — remove hardcoded fallback URI
- **Modified**: `tests/Pest.php` — `makeClient()` must pass `$baseUri` explicitly
- **Modified**: `tests/OpCardsClientTest.php` — all client instantiations must pass `$baseUri`
- **Modified**: `tests/Laravel/OpCardsServiceProviderTest.php` — tests must set `OPCARDS_BASE_URI`

## Non-goals

- No validation that `$baseUri` is a well-formed URL
- No runtime warning when `OPCARDS_BASE_URI` is missing in the ServiceProvider
