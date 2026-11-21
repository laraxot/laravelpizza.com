---
qmd: "temporary uploads migration consolidation"
issues: []
discussions: []
title: "TemporaryUpload migration consolidation — one create migration per model"
type: concept
sources: []
confidence: high
created: 2026-07-22
updated: 2026-07-22
tags: [migration, xotbase, temporary-uploads, technical-debt]
related:
  - ../../../../../../bashscripts/ai/.agents/rules/migration-xot-base-standard.md
  - ../../../../../../bashscripts/ai/.agents/rules/migration-naming-standard.md
  - ../../MIGRATIONS.md
---

# TemporaryUpload: consolidated into a single create migration

## Problem found

Three migrations touched the `temporary_uploads` table:

- `2023_01_01_000000_create_temporary_uploads_table.php` — the real create migration
  (`XotBaseMigration`, `tableCreate()` + `tableUpdate()` for timestamps).
- `2026_01_18_152545_add_columns_to_temporary_uploads_table.php` — **violation**: plain
  `Illuminate\Database\Migrations\Migration`, `Schema::table()` +
  `Schema::hasColumn('temporary_uploads', ...)`, `add_` filename prefix.
- `2026_01_18_152545_create_temporary_uploads_table.php` — a duplicate leftover that
  already re-implemented the add-columns logic correctly (`XotBaseMigration`,
  `$this->hasColumn()`), but as a **second, separate** "create" file for the same
  model — itself a violation of the "one migration per model" rule.

This violates `migration-xot-base-standard.md` (no plain `Migration`, no
`Schema::hasColumn`) and `migration-naming-standard.md` (no `add_` prefix, and
column additions must live inside the model's single `create_<table>_table.php`).

## Fix

- Merged the five columns (`user_id`, `file_name`, `file_size`, `mime_type`,
  `status`) into `2023_01_01_000000_create_temporary_uploads_table.php` as a
  **second `tableUpdate()` block**, guarded with `$this->hasColumn(...)`, placed
  between the base `tableCreate()` (id, session_id) and the existing
  `tableUpdate()` for audit timestamps.
- Columns were deliberately **not** folded directly into `tableCreate()`: since
  this migration already ran in every existing environment before these columns
  existed, `tableCreate()` is a no-op there (`XotBaseMigration::tableCreate()`
  skips if the table already exists) — the columns would never reach an
  already-migrated database. A guarded `tableUpdate()` runs in both cases: it
  creates the columns as part of table creation on fresh installs, and alters
  the existing table on installs that already ran the old migration.
- Deleted both the non-conforming `add_columns_to_temporary_uploads_table.php`
  and the duplicate `2026_01_18_152545_create_temporary_uploads_table.php` file
  — their logic now lives entirely in the one canonical create migration.
- Verified no other file referenced either deleted filename or the anonymous
  class they defined (`grep -rn "add_columns_to_temporary_uploads"` and
  `2026_01_18_152545` across `Modules/` — no hits).

## Result

One migration per model restored: `TemporaryUpload` →
`2023_01_01_000000_create_temporary_uploads_table.php` only. See
[MIGRATIONS.md](../../migrations.md) for the module's migration parity table.

- `phpstan analyse Modules/Media` → 0 errors (174 files).
- `phpmd` on the migration file → no violations.
- `phpinsights analyse Modules/Media/database/migrations` → Code 98.8, Complexity
  100, Architecture 100, Style 97.5 (the only style flags — brace-on-own-line —
  are pre-existing across every migration in the module, not introduced here).
