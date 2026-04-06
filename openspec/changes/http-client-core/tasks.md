## 1. Tests (write first)

- [ ] 1.1 Write test: `OpCardsClient` can be instantiated with a token
- [ ] 1.2 Write test: custom `ClientInterface` is used when injected
- [ ] 1.3 Write test: every request includes `Authorization: Bearer <token>` header
- [ ] 1.4 Write test: 200 JSON response is returned as PHP array
- [ ] 1.5 Write test: 401 response throws `AuthenticationException`
- [ ] 1.6 Write test: 404 response throws `NotFoundException`
- [ ] 1.7 Write test: 429 response throws `RateLimitException`
- [ ] 1.8 Write test: 500 response throws `ApiException`
- [ ] 1.9 Write test: 422 response throws `ApiException`

## 2. Implementation

- [ ] 2.1 Create `src/OpCardsClient.php` with constructor (token + optional `ClientInterface`)
- [ ] 2.2 Implement private `request()` method with Bearer-token header and JSON decoding
- [ ] 2.3 Add exception mapping for 401 → `AuthenticationException`, 404 → `NotFoundException`, 429 → `RateLimitException`, other 4xx/5xx → `ApiException`
