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

## OpenSpec Workflow

Every feature starts with `/opsx:propose` — never implement directly.

## Testing

Run tests: `composer test`

Pre-commit hook blocks commits when tests fail. Activate once with:

```bash
git config core.hooksPath .githooks
```
