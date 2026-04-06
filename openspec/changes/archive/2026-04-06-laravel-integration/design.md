## Context

The framework-agnostic core is complete. `src/Laravel/` is the designated home for Laravel-specific code per `CLAUDE.md`. The ServiceProvider binds `OpCardsClient` as a singleton; the Facade delegates static calls to that binding.

## Goals / Non-Goals

**Goals:**
- `OpCardsServiceProvider` extends `Illuminate\Support\ServiceProvider`, registers `OpCardsClient::class` as a singleton using `env('OPCARDS_TOKEN')`
- `OpCards` facade extends `Illuminate\Support\Facades\Facade`, returns `OpCardsClient::class` as the accessor
- `illuminate/support` added to `require-dev` so the classes can be tested

**Non-Goals:**
- No config file (`config/op-cards.php`) — `env()` is sufficient for v1
- No package auto-discovery (`extra.laravel.providers`) — explicit registration for now
- No full Laravel app in tests — use `Illuminate\Container\Container` directly

## Decisions

### Test with the real Illuminate Container, not mocks

`OpCardsServiceProviderTest` boots the provider against a real `Illuminate\Foundation\Application` (or a minimal `Container`) and asserts that `OpCardsClient::class` is bound and resolvable.

**Why:** Mocking the container would not verify that the binding is correct. A real container is lightweight enough to use in unit tests.

**Approach:** Use `Illuminate\Container\Container` directly (no full app needed), register the provider manually, call `register()`, and resolve the binding.

---

### Facade accessor returns `OpCardsClient::class`

`OpCards::getFacadeAccessor()` returns `OpCardsClient::class` — the string key used by the container.

**Why:** Using the FQCN as the container key is the standard Laravel convention for type-safe resolution.

## Risks / Trade-offs

- **`illuminate/support` version range** — `^10.0|^11.0|^12.0` covers recent Laravel. Older projects on Laravel 9 are not supported.
  → Acceptable; the SDK targets PHP 8.2+ which aligns with Laravel 10+.

## Open Questions

<!-- none -->
