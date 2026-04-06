## Why

Laravel developers expect a ServiceProvider + Facade for zero-config integration. Without them, the SDK works but requires manual instantiation. This change adds the optional Laravel glue in `src/Laravel/` so the core remains framework-agnostic.

## What Changes

- Add `src/Laravel/OpCardsServiceProvider.php` — registers `OpCardsClient` in the service container using `OPCARDS_TOKEN` from config/env
- Add `src/Laravel/Facades/OpCards.php` — Facade backed by `OpCardsClient`

## Capabilities

### New Capabilities

- `laravel-service-provider`: ServiceProvider that binds `OpCardsClient` as a singleton using the app's config/env token
- `laravel-facade`: Facade providing static access to the bound `OpCardsClient`

### Modified Capabilities

<!-- none -->

## Impact

- **New files**: `src/Laravel/OpCardsServiceProvider.php`, `src/Laravel/Facades/OpCards.php`
- **New tests**: `tests/Laravel/OpCardsServiceProviderTest.php`, `tests/Laravel/Facades/OpCardsTest.php`
- **New dev dependency**: `illuminate/support` (for ServiceProvider/Facade base classes in tests)
- **composer.json**: add `illuminate/support` to `require-dev`, add `suggest` entry

## Non-goals

- No config file publishing
- No Artisan commands
- No automatic package discovery annotation (can be added via `extra.laravel` later)
- No testing against a full Laravel application
