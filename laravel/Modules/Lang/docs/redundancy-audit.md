---
updated: 2026-10-23
qmd: "redundancy audit"
issues: []
discussions: []
title: "Lang redundancy audit 2026-05-21"
type: audit
module: Lang
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/platform/issues/89
status: draft
---

# Lang redundancy audit 2026-05-21

Static metrics: 1816 files scanned, 25 case-only groups, 294 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Heavy docs duplication: locale management, quick reference, translation strategies/process, implementation guide, and archive/historical copies.
- `docs/archive` and `docs/translations/archive` duplicate active translation docs.
- Migration directory case-only duplicate: `database/Migrations` vs `database/migrations`: segnato risolto il 2026-07-01, ma al 2026-10-23 `database/Migrations/` è di nuovo tracciata in git (`.gitkeep`, `2024_03_20_000001_create_language_lines_table.php` in versione `Schema::create` diversa da quella in `database/migrations/`, `2025_03_20_000001_create_language_lines_table.php.old3`): il duplicato è aperto; vedi [wiki/concepts/migration-path-canonical.md](wiki/concepts/migration-path-canonical.md).
- Anti-pattern annidato `database/migrations/Migrations/`: reintrodotto per errore in `f840e0cc0`, rimosso; guard in `audit-database-folder-lowercase.sh`.
- Docs index variants include `INDEX.md`/`index.md` and `00-INDEX.md`/`00-index.md`.

Risk:
- Lang is foundational; stale translation rules can propagate wrong patterns across modules.
- Migration case-only duplicate is high-risk for autoload/filesystem portability.

Suggested cleanup order:
1. Fix migration casing with a dedicated code issue and migration discovery check.
2. Consolidate translation docs into canonical lowercase-kebab-case active pages.
3. Remove archive duplicates only after preserving any unique historical decision in `docs/wiki` or log.

Evidence commands:
- Per-owner static scan for case-only paths, byte-identical files, and duplicate FQCN.
- GitHub tracker: issue #89.
