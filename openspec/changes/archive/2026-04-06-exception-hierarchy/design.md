## Context

The SDK currently has empty `src/Exceptions/` and `src/Filters/` and
`src/Resources/` directories with no classes. Before any HTTP logic can be
added, the exception contract must be defined so the http-client-core change
can reference stable, typed exceptions.

## Goals / Non-Goals

**Goals:**

- Provide a base `ApiException` that extends `\RuntimeException`
- Provide three concrete subclasses: `AuthenticationException` (401),
  `NotFoundException` (404), `RateLimitException` (429)
- Each subclass is instantiable with a message; no extra constructor args needed
  at this layer (the HTTP client will add context later)

**Non-Goals:**

- Carrying HTTP response objects or status codes inside the exception (deferred
  to http-client-core)
- Exception serialization or logging
- Framework-specific exception handling

## Decisions

**Single inheritance chain over marker interfaces**
All concrete exceptions extend `ApiException`, which extends `\RuntimeException`.
Callers can catch `ApiException` to handle all SDK errors, or catch specific
subtypes for fine-grained handling. Marker interfaces were considered but add
unnecessary indirection for four classes.

**No constructor arguments beyond message**
The base `ApiException` accepts only `string $message` and optional
`?\Throwable $previous`. Concrete subclasses delegate to `parent::__construct`
without adding new properties. HTTP status codes and response bodies will be
handled by the client layer in the next change.

**Located in `src/Exceptions/`**
Matches the namespace `Ditshej\OpCards\Exceptions\` and the documented
architecture in CLAUDE.md.

## Risks / Trade-offs

[Risk] Future changes may need to attach HTTP status codes or response payloads
to exceptions → The base class signature is kept minimal; extending it in
`http-client-core` with an `$statusCode` property is straightforward.

## Migration Plan

New files only — no existing code is modified or removed. No migration needed.

## Open Questions

None. Scope is fully defined.
