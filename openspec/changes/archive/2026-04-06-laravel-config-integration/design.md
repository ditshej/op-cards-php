## Context

`OpCardsServiceProvider` currently calls `getenv('OPCARDS_TOKEN')` and `getenv('OPCARDS_BASE_URI')` at resolution time. This works for a plain CLI/queue context but breaks in two common Laravel scenarios: (1) config caching (`php artisan config:cache`) populates `config()` but not the process environment, so `getenv()` returns nothing after caching; (2) tests that use `Config::set()` to override values have no effect, forcing them to fall back to `putenv()` which leaks state across test cases.

The fix is straightforward: introduce a `config/opcards.php` file that delegates to `env()` (the idiomatic way to read `.env` values in Laravel), and switch the ServiceProvider to consume `config('opcards.*')` instead.

## Goals / Non-Goals

**Goals:**
- `config:cache`-compatible configuration
- Test isolation via `Config::set()` rather than `putenv()`
- Guard both `opcards.token` and `opcards.base_uri` — throw `InvalidArgumentException` when either is blank
- Publishable config so users can override defaults without touching vendor files

**Non-Goals:**
- No changes to the framework-agnostic core
- No additional config keys (timeouts, retries, etc.) in this change
- No multi-tenant / multiple-client binding support

## Decisions

### Decision 1: `mergeConfigFrom()` in `register()`, `publishes()` in `boot()`

Laravel's convention is `mergeConfigFrom()` in `register()` (so defaults are available before any other provider runs) and `publishes()` in `boot()` (so publish tags work correctly). Alternative: put both in `register()` — rejected because `publishes()` is a boot-phase concern.

### Decision 2: Throw `InvalidArgumentException` for blank token

Previously a blank `OPCARDS_TOKEN` was silently passed to `OpCardsClient`, resulting in authentication errors at request time. Failing fast in the ServiceProvider makes the misconfiguration obvious and consistent with the existing `base_uri` guard. Exception type matches what is already thrown for `base_uri`, so callers have a uniform surface to catch.

### Decision 3: Keep config key names aligned with env var names

`opcards.token` maps to `OPCARDS_TOKEN`, `opcards.base_uri` maps to `OPCARDS_BASE_URI`. This 1-to-1 mapping is easy to reason about and avoids confusion when users look at both the `.env` file and the config file side by side.

### Decision 4: No change to `OpCardsClient` constructor

`OpCardsClient` remains framework-agnostic — it still accepts `string $token` and `string $baseUri`. The ServiceProvider is the only place that knows about Laravel config.

## Risks / Trade-offs

- **[Risk] Existing installs that rely on `putenv()` at bootstrap** → Mitigation: `mergeConfigFrom()` means the config falls back to `env()`, which reads the process environment, so `.env`-based setups continue to work without changes.
- **[Risk] Test helpers that use `putenv()` still work but are now ignored by config layer** → Mitigation: the test file is updated as part of this change; the migration is contained to the one test file.
- **[Trade-off] `mergeConfigFrom()` means user-published config always wins** → This is the expected Laravel behaviour — users who publish the config file own it.

## Migration Plan

1. Add `config/opcards.php`
2. Update `OpCardsServiceProvider` — add `boot()`, update `register()`
3. Update `OpCardsServiceProviderTest` — replace `putenv()` / `afterEach` teardown with `Config::set()`
4. Run `composer test` to verify green
5. Run `composer lint` (Pint) before committing

No database migrations, no breaking changes to the public API. Users who have already published a config file are unaffected. Users relying on `getenv()` fallback continue to work as-is through `env()` in the config file.

## Open Questions

- Should `config/opcards.php` be included in the package's `extra.laravel.config` auto-discovery list in `composer.json`? (Auto-publishing vs. explicit `php artisan vendor:publish`.) Lean toward explicit publish to avoid overwriting user files silently — confirm before implementing.
