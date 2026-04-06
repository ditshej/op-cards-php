## Why

The SDK needs a structured exception hierarchy so callers can catch specific
error conditions (authentication failures, rate-limiting, not-found) without
parsing HTTP status codes themselves. Establishing this layer first lets every
subsequent change rely on a stable, typed error contract.

## What Changes

- Add `src/Exceptions/ApiException.php` — base exception for all SDK errors
- Add `src/Exceptions/AuthenticationException.php` — thrown on HTTP 401
- Add `src/Exceptions/NotFoundException.php` — thrown on HTTP 404
- Add `src/Exceptions/RateLimitException.php` — thrown on HTTP 429

## Capabilities

### New Capabilities

- `exception-hierarchy`: Typed exception classes the SDK throws for API error
  responses, covering authentication, not-found, and rate-limit scenarios.

### Modified Capabilities

## Impact

- New files only in `src/Exceptions/` — no existing code is touched
- All four exceptions must be covered by tests in `tests/Exceptions/`
- No external dependencies required
- Downstream changes (`http-client-core`) will use these types when mapping
  HTTP responses to exceptions
