## 1. Tests

- [ ] 1.1 Add test asserting `getStatusCode()` returns the HTTP status code passed to `ApiException`
- [ ] 1.2 Add test asserting `getStatusCode()` is available on `AuthenticationException` (subclass inheritance)
- [ ] 1.3 Add test asserting `getStatusCode()` is available on `NotFoundException` (subclass inheritance)
- [ ] 1.4 Add test asserting `getStatusCode()` is available on `RateLimitException` (subclass inheritance)

## 2. Implementation

- [ ] 2.1 Add `getStatusCode(): int` method to `ApiException` delegating to `getCode()`

## 3. Finalise

- [ ] 3.1 Run `composer lint` and fix any style issues
- [ ] 3.2 Run `composer test` and confirm all tests pass
