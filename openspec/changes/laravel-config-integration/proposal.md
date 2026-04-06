## Why

`OpCardsServiceProvider` reads configuration via `getenv()`, which bypasses `php artisan config:cache`, cannot be overridden with `Config::set()` in tests, and violates Laravel conventions. Replacing it with Laravel's config system makes the package a first-class Laravel citizen.

## What Changes

- **New**: `config/opcards.php` — publishable config file that wraps `env('OPCARDS_TOKEN')` and `env('OPCARDS_BASE_URI')` in Laravel's standard config layer
- **Modified**: `OpCardsServiceProvider::register()` — reads values via `config('opcards.token')` and `config('opcards.base_uri')` instead of `getenv()`; registers `mergeConfigFrom()` and `publishes()` in `boot()`
- **Modified**: Guard for missing `OPCARDS_BASE_URI` is retained; a new guard for missing `OPCARDS_TOKEN` is added (it was silently ignored before)
- **Modified**: `OpCardsServiceProviderTest` — replaces `putenv()` / `getenv()` setup with `Config::set()` calls

## Capabilities

### New Capabilities

- `laravel-config-integration`: ServiceProvider uses `config()` to read `opcards.token` and `opcards.base_uri`; ships a publishable `config/opcards.php`; guards both values with `InvalidArgumentException`

### Modified Capabilities

- `laravel-service-provider`: Requirements change — config values are sourced from Laravel's config system rather than the environment directly; both `token` and `base_uri` are required (previously only `base_uri` was guarded)

## Non-goals

- No changes to the framework-agnostic core (`OpCardsClient`, resources, filters, exceptions)
- No new config keys beyond `token` and `base_uri`
- No support for runtime config hot-reload or multiple named client bindings

## Impact

- **Files modified**: `src/Laravel/OpCardsServiceProvider.php`, `tests/Laravel/OpCardsServiceProviderTest.php`
- **File added**: `config/opcards.php`
- **Spec updated**: `openspec/specs/laravel-service-provider/spec.md` (delta for changed requirements)
- **No new dependencies** — uses Laravel's existing config and service-container APIs
