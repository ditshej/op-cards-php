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

**Rule:** Every new feature or major change ALWAYS starts with `/opsx:propose` — never implement directly.

Every OpenSpec change gets its own feature branch. No squash merge — the full history stays on `main`.

### Workflow per Change

```bash
# 1. Create branch
git checkout -b feat/<change-name>

# 2. Propose the change (generates proposal, specs, design, tasks)
/opsx:propose
# → Commit: "docs(<change-name>): add proposal, design and tasks"

# 3. Implement (TDD — tests first)
/opsx:apply
# → Commit(s): "feat(<change-name>): ...", "fix(<change-name>): ...", etc.

# 4. Verify — checks Completeness, Correctness, Coherence against specs
/opsx:verify
# → Fix all CRITICALs before proceeding

# 5. Code Review
# Run php-library-reviewer agent, fix findings
# → Commit: "refactor(<change-name>): apply review feedback"

# 6. Archive the change
/opsx:archive
# → Commit: "docs(<change-name>): archive change"

# 7. Rebase onto main, then merge (no squash)
git rebase main
git checkout main && git merge feat/<change-name>
```

Use the change name as the commit scope for every commit on that branch.

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
