---
title: "Activity Migration Ownership"
type: concept
sources: []
confidence: high
created: 2026-06-10
updated: 2026-06-10
tags: [migration, activity, module-owner, one-per-model]
related:
  - ../../../../wiki/rules/one-migration-per-model.md
---

# Activity Migration Ownership

- **Owner module**: `Modules\Activity`. The `activity_log` table is the sole persistence for the `Activity` model, therefore the migration lives in the Activity module.
- **Canonical migration**: `Modules/Activity/database/migrations/2024_01_01_000002_create_activity_table.php` (creates the table) **plus** any schema evolution should be performed inside the same file via `tableUpdate` – **do not** create additional `*_add_*` or `*_fix_*` migration files for the same table.
- **Why**: Enforcing the **one‑migration‑per‑model** principle (see `docs/wiki/bmad/architecture-one-migration-per-model.md`) guarantees a single source‑of‑truth for the table schema, avoids drift, and respects the **module‑model parity** rule (N models = N migrations).
- **Procedure**:
  1. Verify that *only one* migration matches `create_activity_log_table` in `Modules/Activity/database/migrations/`.
  2. If a schema change is required (e.g., adding `attribute_changes` column, fixing `causer_id` to UUID), edit the existing migration:
     - Add the column logic inside the existing `tableUpdate` closure.
     - **Bump the timestamp** of the migration filename (e.g., `2026_07_01_000000_update_activity_log_schema.php`). The timestamp is the heartbeat of the change.
  3. Run `php artisan migrate` (forward‑only, no `--force`, no `--path`).
  4. Keep the migration **idempotent**: guard each column addition with `if (! $this->hasColumn(...))`.
- **Result**: A single, versioned migration governs the `activity_log` table, adhering to the DRY/KISS/Zen philosophy and keeping the migration graph clean.

> **Zen** – One table, one owner, one migration. The timestamp is the pulse of evolution.
