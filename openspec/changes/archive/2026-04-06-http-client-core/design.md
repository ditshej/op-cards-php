## Context

The SDK currently has no HTTP layer. The `exception-hierarchy` change delivered typed exceptions (`ApiException`, `AuthenticationException`, `NotFoundException`, `RateLimitException`). `OpCardsClient` must use those exceptions and provide a tested, injectable HTTP foundation for all future endpoint methods.

## Goals / Non-Goals

**Goals:**
- Wrap Guzzle with Bearer-token auth and JSON response parsing
- Map HTTP status codes to typed exceptions
- Accept an optional pre-configured `GuzzleHttp\Client` for testability

**Non-Goals:**
- No public endpoint methods (packs, cards) — those belong in later changes
- No retry logic, timeout configuration, or caching
- No Laravel-specific bindings

## Decisions

### Accept Guzzle client via constructor (dependency injection)

`OpCardsClient` accepts an optional `GuzzleHttp\ClientInterface` argument. When omitted, it creates a default client with the base URI and auth header pre-configured.

**Why:** Allows tests to inject a mock client without HTTP calls. Aligns with framework-agnostic design — no service container required.

**Alternatives considered:** Static factory; rejected because it makes testing harder and hides dependencies.

---

### Single `request()` method for all HTTP calls

Internal `private function request(string $method, string $path, array $options = []): array` handles all HTTP interaction, response parsing, and exception mapping.

**Why:** Future endpoint methods (`packs()`, `cards()`) all need the same auth/error handling. Centralising avoids duplication and ensures consistent behaviour.

---

### Exception mapping by status code

| Status | Exception |
|--------|-----------|
| 401    | `AuthenticationException` |
| 404    | `NotFoundException` |
| 429    | `RateLimitException` |
| 4xx/5xx | `ApiException` (base) |

`GuzzleHttp\Exception\ClientException` and `ServerException` are caught; the Guzzle exception is passed as `$previous` to preserve the stack trace.

## Risks / Trade-offs

- **Guzzle mock vs real HTTP in tests** — Tests use `GuzzleHttp\Handler\MockHandler`; behaviour differences with a real server are caught in integration testing.
  → Mitigation: Keep mock responses realistic; add contract tests later if needed.

- **Base URI coupling** — Default Guzzle client is built with the `op-cards.ditshej.ch` base URI. Changing the API host requires a custom `ClientInterface`.
  → Acceptable for v1; configurable base URI can be added in a later change.

## Open Questions

<!-- none -->
