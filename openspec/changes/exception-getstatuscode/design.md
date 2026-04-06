## Context

`ApiException` extends `\RuntimeException` and receives the HTTP status code as the constructor's `$code` argument. Currently the only way to retrieve this value is via the inherited `getCode(): int` from `\Exception`, which is semantically generic. The four exception classes in `src/Exceptions/` (`ApiException`, `AuthenticationException`, `NotFoundException`, `RateLimitException`) are all empty bodies — `ApiException` is the sole place to add shared behaviour.

## Goals / Non-Goals

**Goals:**
- Add a single `getStatusCode(): int` method to `ApiException` that delegates to `getCode()`
- All subclasses inherit the method without modification

**Non-Goals:**
- Altering exception construction or how `$code` is set
- Introducing an `HttpExceptionInterface` or any interface contract
- Any other additions to the exception hierarchy

## Decisions

**Delegate to `getCode()` rather than storing a separate property.**

The HTTP status code is already stored as `$code` via the parent constructor. Introducing a second storage location would create a potential inconsistency (two sources of truth) and require updating all call sites that construct exceptions. Delegation is a single line, always consistent, and adds zero memory overhead.

*Alternative considered:* Add a `protected int $statusCode` property populated in an overridden constructor. Rejected — it requires overriding `__construct` and duplicating logic already handled by `\Exception`.

## Risks / Trade-offs

- **`getCode()` and `getStatusCode()` are permanently coupled** → Acceptable: `$code` on this exception class is always an HTTP status code by design. If that contract ever changes, both methods would need updating together, which is discoverable.
- **Very thin method** → No risk; the simplicity is the point. The value is semantic clarity, not logic.

## Migration Plan

No migration required. The change is purely additive. Existing callers using `getCode()` continue to work unchanged.
