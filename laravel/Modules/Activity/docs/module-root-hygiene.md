# Module Root Hygiene — Why the Activity Root Stays Clean

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
  `.kiro/`) each want a place to dump intermediate artifacts. The path of least
  resistance is "write it next to the code," so the module root accretes junk.
- **Copy-paste module bootstrapping.** New modules are cloned from a sibling.
  Whatever cruft lived in the template (`.circleci/`, `scripts/`, `bashscripts/`)
  rides along, even when this module has no CI of its own and no scripts to run.
- **"Archive instead of delete" reflex.** When docs get stale, the temptation is
  to move them to `docs/archive/` rather than trust git history. The archive then
  grows without bound — 86 `.old.md` files in this module alone — and nobody ever
  reads them again. Git already *is* the archive.
- **Local-only concerns leaking into the repo.** `.devcontainer/`, editor and
  per-developer tool configs are personal environment, not shared source. They
  belong in a developer's home or in `.gitignore`, never committed.

## The real need — and its proper home

The underlying needs are legitimate; the module root is just the wrong home:

| Real need | Proper home |
|---|---|
| Reusable shell tooling | `bashscripts/tools/` at the **repo root**, not per-module |
| Historical versions of a doc | git history (`git log --follow <file>`) |
| Agent/audit scratch output | ephemeral temp dir, git-ignored, never committed |
| CI configuration | one place at the repo/org level, not duplicated per module |
| Personal IDE/devcontainer setup | developer's machine + `.gitignore` |

## The zen of a clean root

A module root should read like a table of contents: `app/`, `config/`,
`database/`, `resources/`, `routes/`, `tests/`, `docs/`, `composer.json`,
`README.md`. Every entry earns its place by being part of the module's public
shape. A newcomer scanning the root should learn *what the module is*, not *what
tools happened to run over it*. Scratch directories are noise that hides signal;
deleting them is not destruction, it is restoring the module's legibility.

The `.gitignore` in this module now blocks every forbidden pattern (see the
"AI/TOOL SCAFFOLD" section), so the folders cannot silently return. When a tool
insists on a scratch directory, point it outside the module tree — the answer is
never to commit the mess.
