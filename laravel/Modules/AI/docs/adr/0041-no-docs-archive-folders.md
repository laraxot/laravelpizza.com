---
status: accepted
date: 2026-11-25
decision-makers:
  - Xot
title: "No docs archive folders — restore via Git only"
type: decision
module: Xot
qmd: "ADR 0041 no docs archivio archive _archive backup historical git restore only"
related:
  - ./0005-owner-local-documentation.md
  - ./0040-bmad-stories-numbered-filenames.md
  - ../bmad/stories/0175-no-docs-archive-folders.story.md
  - ../../../../../bashscripts/ai/wiki/memories/docs-second-brain.md
  - ../../../../../.cursor/rules/no-docs-archive.mdc
---

# No docs archive folders — restore via Git only

## Context and Problem Statement

Agents and humans keep creating `docs/archivio/`, `docs/archive/`, `docs/_archive/`
(and similar) as “safe” dumps of superseded `.md` files. Those trees inflate the
docs ceiling, duplicate Git history, and become a second SSoT nobody curates.
How do we forbid doc-backup folders without losing recoverability?

## Decision Drivers

- User order: no `archivio` / archive-style doc dumps; restore with Git
- KISS / DRY: one live docs tree per module/theme
- Docs ceiling ≤100 `.md` (ADR campaign / story 0174)
- Enforcement via `.gitignore` so folders cannot re-enter the index silently

## Considered Options

- Keep archive folders + stubs — rejected (second SSoT)
- Quarantine elsewhere outside `docs/` — rejected (still a dump)
- **Ban archive-named directories under `docs/`; history = Git** — chosen

## Decision Outcome

Chosen: **never create or keep documentation archive directories under
`Modules/*/docs` or `Themes/*/docs`**.

Forbidden directory names (any depth under `docs/`):

- `archivio`, `archive`, `_archive`, `archived`
- `historical`, `backup`, `backups`

Allowed elsewhere:

- Git history (`git show`, `git checkout <rev> -- path`)
- Topic synthesis / digests that are **live** curated docs (not named as archive trees)
- ADR `superseded` stubs that point to a numbered canon (not an archive folder)

Enforcement:

1. Delete existing forbidden trees (content recoverable from Git).
2. Every module/theme `.gitignore` ignores those paths under `docs/`.
3. Cursor rule + second-brain memory `no-docs-archive-folders`.

### Consequences

- Good, because docs stay current; ceiling stays enforceable; restore path is Git.
- Bad, because agents must stop “parking” md in archivio (mitigated by ignore + ADR).

### Confirmation

- `find laravel/Modules laravel/Themes -type d \( -name archivio -o -name archive -o -name _archive -o -name archived -o -name historical -o -name backup -o -name backups \) -path '*/docs/*'` → empty
- Module `.gitignore` contains the ignore block
- Rule `.cursor/rules/no-docs-archive.mdc` present
