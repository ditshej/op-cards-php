## Context

`$baseUri` currently has `'https://op-cards.ditshej.ch/api/'` as its default. That default must be removed. The change is purely a signature change — no logic changes.

## Goals / Non-Goals

**Goals:**
- `$baseUri` has no default — PHP will throw a fatal error if omitted
- `OpCardsServiceProvider` drops its hardcoded fallback, relying solely on `OPCARDS_BASE_URI`
- All test helpers and test cases updated to pass an explicit URI

**Non-Goals:**
- No validation of the URI value
- No migration path for old callers — this is intentionally breaking

## Decisions

### New `OpCardsClient` signature

```php
public function __construct(
    private readonly string $token,
    private readonly string $baseUri,
    ?ClientInterface $http = null,
)
```

No default. Any caller omitting `$baseUri` gets a PHP `ArgumentCountError` immediately.

---

### `OpCardsServiceProvider` — no fallback

```php
$this->app->singleton(OpCardsClient::class, fn () => new OpCardsClient(
    (string) (getenv('OPCARDS_TOKEN') ?: ''),
    (string) getenv('OPCARDS_BASE_URI'),
));
```

If `OPCARDS_BASE_URI` is not set, `getenv()` returns `false`, which casts to `''`. The client is constructed but all requests will fail with a malformed URI. This is acceptable — a missing env var is a deployment error, not a code error.

---

### `makeClient()` in `tests/Pest.php`

The helper currently defaults `$baseUri` to the old hardcoded URI. That default is removed too — every test call must pass an explicit value. A short constant `'https://op-cards.example.com/'` is used as the test fixture base URI to make it obvious it is a test value and not a real deployment.

## Risks / Trade-offs

- **Breaking change for all existing callers** — any code constructing `new OpCardsClient($token)` will error. This is intentional and the right trade-off for a generic SDK.

## Open Questions

<!-- none -->
