## Context

`OpCardsClient` currently builds its default Guzzle client with a hardcoded `base_uri`. The token was always injectable via the constructor; the base URI needs the same treatment. The change is minimal — one extra constructor parameter that flows into the default Guzzle client.

## Goals / Non-Goals

**Goals:**
- `OpCardsClient` accepts `string $baseUri` as the second positional constructor parameter, defaulting to `'https://op-cards.ditshej.ch/api/'`
- `OpCardsServiceProvider` reads `OPCARDS_BASE_URI` from the environment and passes it to the client

**Non-Goals:**
- No validation of the URI format
- No ability to change the base URI after construction
- No per-request URI override

## Decisions

### `$baseUri` as the second positional parameter, before `?ClientInterface $http`

New signature:
```php
public function __construct(
    private readonly string $token,
    private readonly string $baseUri = 'https://op-cards.ditshej.ch/api/',
    ?ClientInterface $http = null,
)
```

**Why:** Positional order mirrors importance — token and base URI are the two configuration values a caller needs to supply. The `$http` parameter is for test injection and stays last. The default keeps backwards compatibility: existing code that only passes a token continues to work.

**Trade-off:** Any caller currently passing `$http` as the second argument will break. Since `$http` is only used in tests (where `makeClient()` is the sole constructor call), this is a controlled and safe change.

---

### `$baseUri` stored as a readonly property

The base URI is used only when building the default Guzzle client. Storing it as `private readonly string $baseUri` keeps it available in the constructor body without a temporary local variable.

---

### ServiceProvider reads `OPCARDS_BASE_URI` with fallback

```php
new OpCardsClient(
    (string) (getenv('OPCARDS_TOKEN') ?: ''),
    (string) (getenv('OPCARDS_BASE_URI') ?: 'https://op-cards.ditshej.ch/api/'),
)
```

**Why:** Consistent with the existing `OPCARDS_TOKEN` pattern. The fallback default means existing deployments that don't set the env var continue to work.

## Risks / Trade-offs

- **`makeClient()` in `tests/Pest.php` passes `$http` as the second argument** — this will break after the signature change. It must be updated to pass `$http` as the third argument (or use named arguments).
  → Straightforward fix, one line in `Pest.php`.

## Open Questions

<!-- none -->
