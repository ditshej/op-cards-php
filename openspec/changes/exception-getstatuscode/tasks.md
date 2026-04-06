## 1. Tests

- [x] 1.1 Add test asserting `getStatusCode()` returns the HTTP status code passed to `ApiException`
- [x] 1.2 Add test asserting `getStatusCode()` is available on `AuthenticationException` (subclass inheritance)
- [x] 1.3 Add test asserting `getStatusCode()` is available on `NotFoundException` (subclass inheritance)
- [x] 1.4 Add test asserting `getStatusCode()` is available on `RateLimitException` (subclass inheritance)

## 2. Implementation

- [x] 2.1 Add `getStatusCode(): int` method to `ApiException` delegating to `getCode()`

## 3. Finalise

- [x] 3.1 Run `composer lint` and fix any style issues
- [x] 3.2 Run `composer test` and confirm all tests pass
