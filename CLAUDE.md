# op-cards-php

PHP SDK for the `op-cards.ditshej.ch` API — framework-agnostic, with optional Laravel integration.

## Package Conventions

- Framework-agnostic core — no Laravel, no Artisan, no Eloquent
- `src/` maps to `Ditshej\OpCards\` namespace
- Optional Laravel integration lives in `src/Laravel/` (ServiceProvider, Facade)
- Use Pest 4 for all tests

## Architecture

```
src/
├── OpCardsClient.php          # Main entry point
├── Resources/                 # Typed DTOs (CardResource, PackResource)
├── Filters/                   # Fluent filter builders
└── Exceptions/                # API exceptions
```

## PHP Standards

- Constructor property promotion over manual assignment
- Typed properties; PHPDoc only where types are insufficient
- Early returns, happy path last, never use `else`
- Self-documenting code over comments

## OpenSpec Workflow

Every feature starts with `/opsx:propose` — never implement directly.

## Testing

Run tests: `composer test`

- Write tests FIRST, then implement (TDD)
- Every class in `src/` needs a corresponding test in `tests/`
- Pre-commit hook blocks commits when tests fail

Activate hook once with:

```bash
git config core.hooksPath .githooks
```

## Pint (Code Formatter)

Run before finalizing a feature:

```bash
vendor/bin/pint --dirty
```

Or via composer: `composer lint`
