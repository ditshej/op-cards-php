## Why

The SDK is a generic layer over any deployment of the `one-piece-cards-api` — not just `op-cards.ditshej.ch`. The base URI is currently hardcoded, which forces every other deployment to inject a custom `ClientInterface` just to change the host. The base URI should be as easy to set as the token.

## What Changes

- Add `string $baseUri` as a constructor parameter to `OpCardsClient`, with the current URL as the default
- Update `OpCardsServiceProvider` to read `OPCARDS_BASE_URI` from the environment

## Capabilities

### New Capabilities

<!-- none -->

### Modified Capabilities

- `http-client`: `OpCardsClient` constructor accepts an optional `string $baseUri` parameter in addition to `string $token`

## Impact

- **Modified**: `src/OpCardsClient.php` — add `$baseUri` parameter
- **Modified**: `src/Laravel/OpCardsServiceProvider.php` — read `OPCARDS_BASE_URI` from env
- **Modified**: `tests/OpCardsClientTest.php` — verify base URI is forwarded to the Guzzle client
- **Modified**: `tests/Laravel/OpCardsServiceProviderTest.php` — verify the provider passes the env value

## Non-goals

- No URL validation
- No per-request base URI override
- No config file publishing for the Laravel integration
