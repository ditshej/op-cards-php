## 1. Tests

- [x] 1.1 Create `tests/Exceptions/ApiExceptionTest.php` — assert it extends `\RuntimeException`, is instantiable with a message, and message is accessible
- [x] 1.2 Create `tests/Exceptions/AuthenticationExceptionTest.php` — assert it extends `ApiException` and carries the given message
- [x] 1.3 Create `tests/Exceptions/NotFoundExceptionTest.php` — assert it extends `ApiException` and carries the given message
- [x] 1.4 Create `tests/Exceptions/RateLimitExceptionTest.php` — assert it extends `ApiException` and carries the given message

## 2. Implementation

- [x] 2.1 Create `src/Exceptions/ApiException.php` — extends `\RuntimeException`
- [x] 2.2 Create `src/Exceptions/AuthenticationException.php` — extends `ApiException`
- [x] 2.3 Create `src/Exceptions/NotFoundException.php` — extends `ApiException`
- [x] 2.4 Create `src/Exceptions/RateLimitException.php` — extends `ApiException`

## 3. Verification

- [x] 3.1 Run `composer test` — all tests pass
- [x] 3.2 Run `vendor/bin/pint --dirty` — no formatting issues
