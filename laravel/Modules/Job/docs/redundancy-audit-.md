---
title: "Job redundancy audit 2026-05-21"
type: audit
module: Job
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Job redundancy audit 2026-05-21

Static metrics: 956 files scanned, 6 case-only groups, 49 duplicate hash groups, 0 duplicate FQCN.

Findings:
- `Config/` and `config/` contain case-only duplicate config files.
- Docs include duplicate active/archive pages for Filament migration, schedules, optimization, PHPStan fixes, and integration notes.
- `artisan.md` exists at module root and under `docs/`.
- `.github` files have case-only duplicates.

Risk:
- Config case duplication can confuse package publishing and service provider loading.
- Documentation duplication makes operational job/schedule instructions unreliable.

Suggested cleanup order:
1. Confirm provider loads lowercase `config/`, then remove uppercase mirror in a dedicated issue.
2. Pick active schedule/optimization docs and collapse archive duplicates.
3. Keep root docs only if they are bootstrap pointers; otherwise move into `docs/`.

Evidence commands:
- Per-owner static scan for case-only paths, byte-identical files, and duplicate FQCN.
- GitHub tracker: issue #89.
