---
title: MODULE ROOT HYGIENE
module: AI
---

# Module Root Hygiene — Why the AI Module Root Stays Clean

Extends the canonical rule: [`docs/wiki/rules/module-theme-root-cleanup.md`](../../../../docs/wiki/rules/module-theme-root-cleanup.md).

## The rule in one line

No scaffold/scratch directories in the module tree. Forbidden:
`_docs/`, `scripts/`, `bashscripts/`, `docs/archive/`, `docs/archived/`,
`docs/legacy/`, `docs/workbench/`, `.circleci/`, `.claude-audit/`,
`tests/.claude-audit/`, `_bmad-output/`, `test-results/`, `.devcontainer/`,
`.kilocode/`, `.kiro/`, `.ralph/`.

## Why these folders keep reappearing

They are not authored on purpose — they are *deposited* by tools and habits:

- **AI agents carving scratch space.** Audit runs (`.claude-audit/`), planning
  runs (`_bmad-output/`, `.ralph/`), and IDE-agent configs (`.kilocode/`,
  `.kiro/`) each want somewhere to dump intermediate artifacts, and "next to the
  code" is the path of least resistance.
- **Copy-paste module bootstrapping.** New modules are cloned from a sibling and
  inherit its cruft (`.circleci/`, `scripts/`) whether or not this module needs it.
- **"Archive instead of delete" reflex.** Stale docs get moved to `docs/archive/`
  rather than trusting git history. Git already *is* the archive.
- **Genuine tooling that landed in the wrong place.** This is the AI module's
  special case: `scripts/` here held a *real* Python fine-tuning service
  (`fine_tuning.py`) plus a CI helper — actual, referenced code. The mistake was
  not writing it; it was parking it in a forbidden folder inside a PHP module.

## The real need — and its proper home

The underlying needs are legitimate; the module root is just the wrong home:

| Real need | Proper home |
|---|---|
| Standalone Python/service tooling | repo-root `bashscripts/tools/` (see `ai-fine-tuning/`) |
| CI helper scripts | `.github/ci/`, referenced from the workflow |
| Historical versions of a doc | git history (`git log --follow <file>`) |
| Agent/audit scratch output | ephemeral git-ignored temp dir, never committed |
| Personal IDE/devcontainer setup | developer's machine + `.gitignore` |

### What was migrated (2026-07-16)

- `scripts/fine_tuning.py`, `scripts/test_fine_tuning.py` →
  `bashscripts/tools/ai-fine-tuning/` at the repo root. `docs/fine-tuning.md` was
  updated to point there.
- `scripts/ci/contributor-lines-report.mjs` → `.github/ci/`, and
  `.github/workflows/contributor-lines-report.yml` updated to the new path.
- `scripts/.gitignore` patterns (`venv/`, `docs/phpstan/`, `_docs/`, `agentdb.rvf`)
  were folded into this module's `.gitignore`.

Nothing unique was destroyed — real content moved to a real home *before* the
forbidden folder was removed.

> **Drift detected (2026-09-17), in this checkout of the module (`base_restaurant_fila5`)**:
> `Modules/AI/scripts/` still exists with all four items listed above
> (`fine_tuning.py`, `test_fine_tuning.py`, `ci/contributor-lines-report.mjs`,
> `.gitignore`) — the migration described is not reflected here. Neither
> `bashscripts/tools/ai-fine-tuning/` nor `.github/ci/contributor-lines-report.mjs`
> exist at the repo root, and `docs/fine-tuning.md` still has no pointer to
> either. Since `Modules/AI` is its own git repo shared across Laraxot bases
> (`laraxot/module_ai_fila5`), this may be a base whose checkout predates the
> migration, or the migration may have been reverted upstream — needs a
> dedicated follow-up to reconcile (either redo the migration here, or correct
> this doc if the migration was abandoned). Not resolved in this documentation
> pass, since moving `scripts/` is a structural change, not a doc edit.

## The zen of a clean root

A module root should read like a table of contents: `app/`, `config/`,
`database/`, `resources/`, `routes/`, `tests/`, `docs/`, `composer.json`,
`README.md`. A newcomer scanning it should learn *what the module is*, not *what
tools happened to run over it*. The `.gitignore` now blocks every forbidden
pattern, so the folders cannot silently return. When a tool insists on a scratch
directory, point it outside the module tree — the answer is never to commit the mess.
