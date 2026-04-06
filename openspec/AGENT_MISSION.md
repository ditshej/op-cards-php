# Agent Mission: Implement op-cards-php Roadmap

## Overview

Implement all pending changes in `openspec/ROADMAP.md` for the `op-cards-php` PHP SDK.
Work through each change sequentially using the OpenSpec workflow with a review step before archiving.

**Working directory:** `/Users/ditshej/localweb/op-cards-php`

---

## Workflow Per Change

For each change in the roadmap (in order), execute these steps:

### Step 1: Propose
```bash
openspec new change "<change-name>"
openspec instructions proposal --change "<change-name>" --json
```
Write `openspec/changes/<change-name>/proposal.md` using the template.
Then write `design.md` and `tasks.md` following the same pattern.

Use `openspec/ROADMAP.md` as the primary source for what each change should do.
Use `openspec/config.yaml` for project context and rules.

**Commit after propose:**
```bash
git add openspec/changes/<change-name>/
git commit -m "docs(<change-name>): add proposal, design and tasks

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```

### Step 2: Apply
```bash
openspec instructions apply --change "<change-name>" --json
```
Work through all tasks in `tasks.md`:
- Mark each task `[x]` as you complete it
- Write tests FIRST for each implementation task
- Run `composer test` after each task to verify nothing breaks
- If tests fail: fix before moving to the next task
- If a task is unclear: make a reasonable decision, note it in the task file

**Commit after apply (all tasks done):**
```bash
git add src/ tests/
git commit -m "feat(<change-name>): <short description of what was implemented>

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```

### Step 3: Review (parallel subagents)

After all tasks are complete, spawn **two review agents in parallel** using the Agent tool:

**Agent A** — Code quality review:
```
Use the php-library-reviewer agent to review all recently modified files in
/Users/ditshej/localweb/op-cards-php for this change: <change-name>.
Check code quality, PHP standards, and pint formatting.
Return a structured report with critical and minor findings.
```

**Agent B** — Test coverage review:
```
Review the test files recently added or modified in
/Users/ditshej/localweb/op-cards-php for change: <change-name>.
Check: Does every new class in src/ have a corresponding test?
Are assertions specific and meaningful? Are datasets used for repetitive cases?
Return a structured report with critical and minor findings.
```

Collect both reports. Fix all **critical** findings. Document **minor** findings.
Run `composer test` again to confirm everything passes.

**Commit after review (only if changes were made):**
```bash
git add src/ tests/
git commit -m "refactor(<change-name>): apply review feedback

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```
Skip this commit if the review produced no changes.

### Step 4: Archive
```bash
openspec archive <change-name>
```

**Commit after archive:**
```bash
git add openspec/changes/archive/
git commit -m "chore(<change-name>): archive change

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"
```

### Step 5: Report

After archiving, output a summary block:

```
## Change: <change-name>
Status: ✓ archived
Commits: docs · feat · [refactor] · chore
Files created: <list>
Review findings: <N> critical fixed, <N> minor noted
Tests: <N> passed
```

---

## Change Sequence

Implement in this exact order (each builds on the previous):

1. `exception-hierarchy`
2. `http-client-core`
3. `card-and-pack-resources`
4. `list-packs`
5. `list-cards`
6. `card-filter`
7. `laravel-integration`

Check `git log --oneline` first — if some changes are already archived, skip them.

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

| Change | Status | Commits | Tests |
|--------|--------|---------|-------|
| exception-hierarchy    | ✓ | docs · feat · chore | 8 passed |
| http-client-core       | ✓ | docs · feat · refactor · chore | 12 passed |
| card-and-pack-resources| ✓ | ... | ... |
| list-packs             | ✓ | ... | ... |
| list-cards             | ✓ | ... | ... |
| card-filter            | ✓ | ... | ... |
| laravel-integration    | ✓ | ... | ... |

## How to Review

Run all tests:         composer test
Check formatting:      vendor/bin/pint --dirty
Browse archived changes: openspec/changes/archive/
View git history:      git log --oneline
```
