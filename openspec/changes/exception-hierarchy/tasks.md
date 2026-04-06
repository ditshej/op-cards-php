## 1. Tests

- [ ] 1.1 Create `tests/Exceptions/ApiExceptionTest.php` — assert it extends `\RuntimeException`, is instantiable with a message, and message is accessible
- [ ] 1.2 Create `tests/Exceptions/AuthenticationExceptionTest.php` — assert it extends `ApiException` and carries the given message
- [ ] 1.3 Create `tests/Exceptions/NotFoundExceptionTest.php` — assert it extends `ApiException` and carries the given message
- [ ] 1.4 Create `tests/Exceptions/RateLimitExceptionTest.php` — assert it extends `ApiException` and carries the given message

## 2. Implementation

- [ ] 2.1 Create `src/Exceptions/ApiException.php` — extends `\RuntimeException`
- [ ] 2.2 Create `src/Exceptions/AuthenticationException.php` — extends `ApiException`
- [ ] 2.3 Create `src/Exceptions/NotFoundException.php` — extends `ApiException`
- [ ] 2.4 Create `src/Exceptions/RateLimitException.php` — extends `ApiException`

## 3. Verification

- [ ] 3.1 Run `composer test` — all tests pass
- [ ] 3.2 Run `vendor/bin/pint --dirty` — no formatting issues
