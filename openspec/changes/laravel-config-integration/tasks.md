## 1. Tests

- [ ] 1.1 Update `OpCardsServiceProviderTest`: replace `putenv()` / `afterEach` teardown with `Config::set('opcards.token', ...)` and `Config::set('opcards.base_uri', ...)`
- [ ] 1.2 Add test: throws `InvalidArgumentException` when `opcards.token` is blank
- [ ] 1.3 Add test: reads `opcards.base_uri` from Laravel config (not from process environment)
- [ ] 1.4 Confirm all existing tests fail with the old `getenv()` implementation (red phase)

## 2. Config File

- [ ] 2.1 Create `config/opcards.php` with `token` and `base_uri` keys backed by `env()`

## 3. ServiceProvider

- [ ] 3.1 Add `boot()` method: call `$this->mergeConfigFrom()` for `config/opcards.php` and `$this->publishes()` with tag `opcards-config`
- [ ] 3.2 Update `register()`: read `config('opcards.token')` and `config('opcards.base_uri')` instead of `getenv()`
- [ ] 3.3 Add guard: throw `InvalidArgumentException` when `opcards.token` is blank

## 4. Spec Update

- [ ] 4.1 Update `openspec/specs/laravel-service-provider/spec.md`: replace env-var requirements with config-key requirements; add scenario for blank token guard

## 5. Finalise

- [ ] 5.1 Run `composer test` — all tests green
- [ ] 5.2 Run `composer lint` (Pint) — no style violations
