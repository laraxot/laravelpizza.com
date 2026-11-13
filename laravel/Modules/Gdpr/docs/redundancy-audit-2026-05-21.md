---
title: "Gdpr redundancy audit 2026-05-21"
type: audit
module: Gdpr
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Gdpr redundancy audit 2026-05-21

Static metrics: 626 files scanned, 8 case-only groups, 26 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Case-only docs: `INDEX.md`/`index.md`, `SCHEMA.md`/`schema.md`, `METODI_DUPLICATI_ANALISI.md` variants.
- Case-only test file: `ConflictResolutionTest.php`/`conflictresolutiontest.php`.
- `cloudflare.md` exists both at module root and under `docs/`.
- Large docs cluster has many byte-identical placeholders or duplicate pages across architecture, roadmap, packages, privacy, backup, analytics, and integration topics.

Risk:
- QMD/search may surface placeholder duplicates instead of maintained GDPR policy docs.
- Case-only tests are cross-platform fragile.

Suggested cleanup order:
1. Normalize docs to lowercase-kebab-case and one active path.
2. Consolidate placeholder duplicate docs into an index with links to active pages.
3. Normalize test casing in a code cleanup with Pest/PHPUnit check.

Evidence commands:
- Per-owner static scan for case-only paths, byte-identical files, and duplicate FQCN.
- GitHub tracker: issue #89.
