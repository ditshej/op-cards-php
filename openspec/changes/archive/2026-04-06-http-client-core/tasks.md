## 1. Tests (write first)

- [x] 1.1 Write test: `OpCardsClient` can be instantiated with a token
- [x] 1.2 Write test: custom `ClientInterface` is used when injected
- [x] 1.3 Write test: every request includes `Authorization: Bearer <token>` header
- [x] 1.4 Write test: 200 JSON response is returned as PHP array
- [x] 1.5 Write test: 401 response throws `AuthenticationException`
- [x] 1.6 Write test: 404 response throws `NotFoundException`
- [x] 1.7 Write test: 429 response throws `RateLimitException`
- [x] 1.8 Write test: 500 response throws `ApiException`
- [x] 1.9 Write test: 422 response throws `ApiException`

## 2. Implementation

- [x] 2.1 Create `src/OpCardsClient.php` with constructor (token + optional `ClientInterface`)
- [x] 2.2 Implement private `request()` method with Bearer-token header and JSON decoding
- [x] 2.3 Add exception mapping for 401 → `AuthenticationException`, 404 → `NotFoundException`, 429 → `RateLimitException`, other 4xx/5xx → `ApiException`
