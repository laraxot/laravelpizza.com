---
title: "Notifications Migration Ownership"
type: concept
sources: []
confidence: high
created: 2026-06-10
updated: 2026-06-10
tags: [migration, notifications, module-owner, notify, user]
related:
  - ../../../../wiki/rules/one-migration-per-model.md
---

# Notifications Migration Ownership

- **Owner module**: `Modules\Notify`. The `notifications` table stores user‑centric notification records and therefore belongs to the *Notify* domain, not the *User* module.
- **Canonical migration**: `Modules/Notify/database/migrations/2026_06_10_124000_create_notifications_table.php`.
- **Why**: Following the **one‑migration‑per‑model** doctrine (see `docs/wiki/bmad/architecture-one-migration-per-model.md`) each model must have exactly one owning migration. Placing the migration in `User` violates the *module‑model parity* rule and leads to broken foreign‑key expectations (the `user` connection is used while the model lives in `notify`).
- **Procedure**:
  1. Delete any `create_notifications_table` migration that lives under `Modules/User/database/migrations/`.
  2. Ensure the `Notify` migration includes the `$model_class = Notification::class` reference and uses `XotBaseMigration`.
  3. When a schema change is needed, **bump the timestamp** of the existing file (e.g. `2026_07_01_000001_create_notifications_table.php`).
  4. Run `php artisan migrate` (no `--force`, no `--path`).
- **Result**: The `notifications` table is created on the `user` connection but is managed by the correct module, preserving data‑sacred integrity and keeping the migration graph clean.

> **Zen** – One table, one owner, one migration. The timestamp is the heartbeat of change.
