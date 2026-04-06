## Why

The SDK needs a functional HTTP client to communicate with the op-cards API. Without it, no endpoint methods can be implemented — this is the foundation every other change builds upon.

## What Changes

- Introduce `OpCardsClient` as the main entry point for the SDK
- Implement Bearer-token authentication via Guzzle HTTP client
- Parse JSON responses into typed PHP arrays
- Map HTTP status codes (401, 404, 429, 5xx) to the typed exception hierarchy

## Capabilities

### New Capabilities

- `http-client`: Authenticated Guzzle-based HTTP client with JSON handling and exception mapping from HTTP status codes

### Modified Capabilities

<!-- none -->

## Impact

- **New file**: `src/OpCardsClient.php`
- **Dependencies**: `guzzlehttp/guzzle` (already in composer.json), `Ditshej\OpCards\Exceptions\*` (from exception-hierarchy)
- **Tests**: `tests/OpCardsClientTest.php`

## Non-goals

- No endpoint methods (`packs()`, `cards()`) — those come in later changes
- No retry logic or timeout configuration
- No response caching
