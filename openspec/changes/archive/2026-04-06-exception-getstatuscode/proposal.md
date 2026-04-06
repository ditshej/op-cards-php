## Why

`ApiException` stores the HTTP status code as the exception `$code`, but callers must use the generic `getCode()` method inherited from `\Exception` to retrieve it. This is semantically ambiguous — `getCode()` suggests an application error code, not an HTTP status. A dedicated `getStatusCode()` method makes the intent explicit and aligns with how HTTP status codes are typically surfaced in PHP HTTP libraries (e.g. Guzzle, Symfony HttpClient).

## What Changes

- Add `getStatusCode(): int` method to `ApiException` that returns `$this->getCode()`
- All subclasses (`AuthenticationException`, `NotFoundException`, `RateLimitException`) inherit the method automatically — no changes needed in subclasses

## Capabilities

### New Capabilities

- `exception-get-status-code`: Exposes the HTTP status code on `ApiException` via a semantically correct `getStatusCode()` method

### Modified Capabilities

<!-- No existing spec-level requirements are changing -->

## Non-goals

- Replacing or deprecating `getCode()` — it remains available from `\Exception`
- Changing how the HTTP status code is stored or passed to the exception constructor
- Adding any other convenience methods to the exception hierarchy

## Impact

- `src/Exceptions/ApiException.php` — one method added
- `tests/Exceptions/ApiExceptionTest.php` — new assertions for `getStatusCode()`
- No breaking changes; fully additive
