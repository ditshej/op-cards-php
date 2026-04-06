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

**Rule:** Every new feature or major change ALWAYS starts with `/opsx:propose` — never implement directly, not even in plan mode. Implementation with `/opsx:apply` may only begin after the propose commit.

Every OpenSpec change gets its own feature branch. No squash merge — the full history stays on `main`.

> **Autonomous mode (AGENT_MISSION):** When working through a full roadmap autonomously, per-change CHECKPOINTs are skipped. Instead, after the session is complete, the agent must produce a mandatory stop — presenting a full summary of all changes and optionally opening a GitHub PR for review.

### Workflow per Change

```bash
# 0. Explore (optional)
# /opsx:explore — investigate ideas and requirements before proposing
# → CHECKPOINT: Present findings to user → wait for OK before proposing

# 1. Create branch
git checkout -b feat/<change-name>

# 2. Propose
openspec new change "<change-name>"
# /opsx:propose — create proposal.md, specs/, design.md, tasks.md
# → Commit: "docs(<change-name>): add proposal, design and tasks"
# → CHECKPOINT: Present proposal summary → wait for OK before implementing

# 3. Implementation (TDD)
# /opsx:apply — work through tasks
# → Commit(s): "feat(<change-name>): ...", "test(<change-name>): ...", etc.

# 4. Verify
# /opsx:verify — checks Completeness, Correctness, Coherence against specs
# → Fix all CRITICALs before proceeding

# 5. AI Review
# php-library-reviewer Agent — automated review (spawn parallel subagents)
# → Fix critical findings, commit: "refactor(<change-name>): apply review feedback"
# → CHECKPOINT: Present change summary:
#     - What changed (architecture, new/modified files)
#     - Test results (N passed)
#     - How to review manually (git diff, which endpoints/methods to test)
#   → Wait for user OK before archiving

# 6. Archiving
# /opsx:archive — close change, merge specs
# → Commit: "docs(<change-name>): archive change"

# 7. Merge to main (no squash!)
git checkout main
git merge feat/<change-name>
git branch -d feat/<change-name>
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
