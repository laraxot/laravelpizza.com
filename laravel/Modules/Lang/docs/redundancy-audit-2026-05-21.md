---
title: "Lang redundancy audit 2026-05-21"
type: audit
module: Lang
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Lang redundancy audit 2026-05-21

Static metrics: 1816 files scanned, 25 case-only groups, 294 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Heavy docs duplication: locale management, quick reference, translation strategies/process, implementation guide, and archive/historical copies.
- `docs/archive` and `docs/translations/archive` duplicate active translation docs.
- Migration directory case-only duplicate: `database/Migrations` vs `database/migrations`.
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
