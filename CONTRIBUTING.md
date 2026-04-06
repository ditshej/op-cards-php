# Contributing

Contributions are welcome — bug reports, improvements, and new features.

## Development Workflow

This project uses [OpenSpec](https://github.com/fission-ai/openspec) for structured change management. Every new feature or significant change **must start with a proposal** — never implement directly.

### Required Tools

- PHP 8.2+, Composer
- [OpenSpec CLI](https://github.com/fission-ai/openspec): `npm install -g @fission-ai/openspec`
- [Claude Code](https://claude.ai/code) (recommended — skills are pre-configured in `.claude/`)

### Feature Branch Convention

Every change gets its own branch:

```bash
git checkout -b feat/<change-name>   # e.g. feat/card-filtering
```

No squash merges — full history stays on `main`. Rebase before merging to keep the branch current.

### Workflow per Change

```bash
# 0. Explore (optional)
# /opsx:explore — investigate before proposing
# → Present findings to user, wait for OK

# 1. Create a feature branch
git checkout -b feat/<change-name>

# 2. Propose (generates proposal, specs, design, tasks)
/opsx:propose
git add openspec/ && git commit -m "docs(<change-name>): add proposal, design and tasks"
# → Present proposal summary to user, wait for OK before implementing

# 3. Implement (TDD — tests first)
/opsx:apply

# 4. Verify — checks Completeness, Correctness, Coherence against specs
/opsx:verify
# → Fix all CRITICALs before proceeding

# 5. AI Review
# Spawn php-library-reviewer agents
# → Fix critical findings, commit
# → Present change summary + manual review instructions → wait for user OK

# 6. Human review — don't proceed until approved

# 7. Archive the change
/opsx:archive

# 8. Rebase onto main before merging
git fetch origin && git rebase origin/main

# 9. Merge (no squash)
git checkout main && git merge feat/<change-name>
```

Use the change name as the commit scope on every commit on that branch:

```
docs(card-filtering): add proposal, design and tasks
feat(card-filtering): add color filter to cards endpoint
fix(card-filtering): correct empty result handling
docs(card-filtering): archive change
```

Multiple commits per phase are fine — commit as often as makes sense.

## TDD

Tests are written **before** implementation. A pre-commit hook enforces this — commits are blocked when tests fail.

```bash
# Activate the hook once
git config core.hooksPath .githooks

# Run all tests
composer test

# Run a specific test file or filter
vendor/bin/pest --filter=CardFilterTest
```

## Code Style

[Laravel Pint](https://laravel.com/docs/pint) is used for formatting. Run it before committing:

```bash
vendor/bin/pint --dirty
```

Or via composer: `composer lint`

## Reporting Issues

Open a GitHub issue with a clear description of the problem and steps to reproduce.
