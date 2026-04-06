# Agent Mission: Implement op-cards-php Roadmap

## Overview

Implement all pending changes in `openspec/ROADMAP.md` for the `op-cards-php` PHP SDK.
Work through each change sequentially using the OpenSpec workflow with a review step before archiving.

**Working directory:** `/Users/ditshej/localweb/op-cards-php`
All commands are run from this directory.

---

## Workflow Per Change

For each change in the roadmap (in order), execute these steps:

### Step 0: Branch

```bash
git checkout main
git checkout -b feat/<change-name>
```

All commits for this change (propose, apply, review, archive) go on this branch.

---

### Step 1: Propose

Create the change scaffold and write all planning artifacts:

```bash
openspec new change "<change-name>"
```

Then fetch instructions and write each artifact in order:

```bash
openspec instructions proposal --change "<change-name>" --json
# → write openspec/changes/<change-name>/proposal.md

openspec instructions design --change "<change-name>" --json
# → write openspec/changes/<change-name>/design.md

openspec instructions tasks --change "<change-name>" --json
# → write openspec/changes/<change-name>/tasks.md
```

Use `openspec/ROADMAP.md` as the primary source for scope.
Use `openspec/config.yaml` for project context and rules.
Each `instructions` call returns a template — fill it in. Do NOT copy `context` or `rules` blocks into the output files.

**Commit after propose:**
```bash
git add openspec/changes/<change-name>/
git commit -m "docs(<change-name>): add proposal, design and tasks

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```

---

### Step 2: Apply

```bash
openspec instructions apply --change "<change-name>" --json
```

Work through all tasks in `tasks.md`:
- Mark each task `[x]` as you complete it
- Write tests FIRST for each implementation task (TDD)
- Run `composer test` after each task — never leave failing tests
- If tests fail: fix before moving to the next task
- If a task is unclear: make a reasonable decision, note it in the task file
- Pause and report back if you hit a blocker you cannot resolve

**Commit after apply (all tasks done):**
```bash
git add src/ tests/ openspec/changes/<change-name>/tasks.md
git commit -m "feat(<change-name>): <short description of what was implemented>

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```

---

### Step 3: Review (parallel subagents)

Spawn **two review agents in parallel** using the Agent tool.

The reviewer agents use the branch diff to see all code changes cleanly:
`git diff main..HEAD -- src/ tests/`

**Agent A** — Code quality + formatting:
```
You are reviewing the change "<change-name>" in /Users/ditshej/localweb/op-cards-php.
Use the php-library-reviewer agent.
Run `git diff main..HEAD --name-only -- src/ tests/` to find all modified files
in this branch, then read and review each one.
Check: PHP standards, constructor promotion, typed properties, no else, no framework
imports in src/ root, pint formatting.
Fix all critical findings directly. Run composer test after fixes.
Return a structured report with critical and minor findings.
```

**Agent B** — Test coverage + quality:
```
You are reviewing the tests for change "<change-name>" in /Users/ditshej/localweb/op-cards-php.
Run `git diff main..HEAD --name-only -- src/ tests/` to find all modified files
in this branch.
Check: Does every new class in src/ have a corresponding test? Are assertions
specific and meaningful (expect()->toBe() not assertTrue)? Are datasets used
for repetitive cases? Does ArchTest.php need updating for new structural rules?
Fix all critical findings directly. Run composer test after fixes.
Return a structured report with critical and minor findings.
```

Collect both reports. Fix all **critical** findings. Document **minor** findings.
Run `composer test` one final time to confirm everything passes.

**Commit after review (only if changes were made):**
```bash
git add src/ tests/
git commit -m "refactor(<change-name>): apply review feedback

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```
Skip this commit entirely if the review produced zero changes.

---

### Step 4: Archive

```bash
openspec archive <change-name> --yes
```

The `--yes` flag skips confirmation prompts.

**Commit after archive:**
```bash
git add -A openspec/
git commit -m "docs(<change-name>): archive change

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```

Note: `git add -A openspec/` is required because the archive moves files
(deletion from `changes/` + creation in `changes/archive/`).

---

### Step 5: Merge to main

```bash
git checkout main
git merge feat/<change-name>
git branch -d feat/<change-name>
```

No squash. Full history stays on main.

---

### Step 6: Report

After merging, output a summary block:

```
## Change: <change-name>
Status: ✓ merged to main
Branch: feat/<change-name> (deleted)
Commits: docs · feat · [refactor] · docs
Files created: <list>
Review findings: <N> critical fixed, <N> minor noted
Tests: <N> passed
```

---

## Change Sequence

Check `git log --oneline` first — if some changes are already merged to main, skip them.

Implement in this exact order (each builds on the previous):

1. `exception-hierarchy`
2. `http-client-core`
3. `card-and-pack-resources`
4. `list-packs`
5. `list-cards`
6. `card-filter`
7. `laravel-integration`

---

## Rules

- **TDD**: Write the test before the implementation, always
- **No framework dependencies** in `src/` root (only `src/Laravel/` may use Illuminate)
- **No `else`**: Early returns, happy path last
- **Constructor property promotion**: always
- **Typed properties**: always, no `mixed` unless unavoidable
- **Run `composer test` after every task** — never leave failing tests
- **Run `vendor/bin/pint --dirty`** before committing
- **Pause and report** if you hit a blocker — do not guess past breaking issues

---

## Final Output

After all 7 changes are complete, output a full summary:

```
# Mission Complete

## Changes Implemented

| Change                  | Status | Branch (deleted)             | Commits                        | Tests      |
|-------------------------|--------|------------------------------|--------------------------------|------------|
| exception-hierarchy     | ✓      | feat/exception-hierarchy     | docs · feat · docs             | 8 passed   |
| http-client-core        | ✓      | feat/http-client-core        | docs · feat · refactor · docs  | 12 passed  |
| card-and-pack-resources | ✓      | feat/card-and-pack-resources | ...                            | ...        |
| list-packs              | ✓      | feat/list-packs              | ...                            | ...        |
| list-cards              | ✓      | feat/list-cards              | ...                            | ...        |
| card-filter             | ✓      | feat/card-filter             | ...                            | ...        |
| laravel-integration     | ✓      | feat/laravel-integration     | ...                            | ...        |

## How to Review

Run all tests:            composer test
Check formatting:         vendor/bin/pint --dirty
Browse archived changes:  openspec/changes/archive/
View git history:         git log --oneline
```
