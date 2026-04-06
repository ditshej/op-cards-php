## Why

The `op-cards-php` package is a public Composer package with no `README.md`. Without documentation, developers cannot discover how to install, configure, or use the SDK. A README is the minimum viable entry point for any published package.

## What Changes

- **New file**: `README.md` at the repository root documenting the full public surface of the SDK.

## Capabilities

### New Capabilities

- `readme`: A `README.md` covering package description, installation, configuration, standalone usage, Laravel integration, available methods (`packs()`, `pack($id)`, `cards()`, `card($id)`, `allCards()`), `CardFilter` usage, and API version compatibility note.

### Modified Capabilities

<!-- No existing specs change requirements — this change only adds documentation. -->

## Non-goals

- This change does not introduce or alter any PHP code.
- It does not cover contributing guidelines, changelog, or license sections.
- It does not document internal architecture or class-level API beyond the public SDK surface.

## Impact

- `README.md` (new) — the only file affected.
- No code, tests, or configuration are changed.
- Depends on all SDK capabilities (changes 8–12) being implemented first, as it documents the final public surface.
