---
title: "Story: Create permissions tables in trade_user database"
type: story
module: User
status: in-progress
created: 2026-10-05
updated: 2026-10-05
---

# Story: Create permissions tables in trade_user database

## Context

Spatie Laravel Permission tables (roles, permissions, etc.) are missing from the `trade_user` (connection `user`) database, causing `Table 'trade_data.permissions' doesn't exist` (it tries to access them in default `trade_data`).

## Scope

Create a migration to add Spatie permission tables to `trade_user` database.

## Acceptance Criteria

- [ ] Permissions tables exist in `trade_user` DB.
- [ ] Admin dashboard (Filament) loads without permission errors.

## Implementation Details

Create a migration in `Modules/User/database/migrations` to create the standard Spatie tables: `roles`, `permissions`, `model_has_permissions`, `model_has_roles`, `role_has_permissions`. Ensure they are created on `user` connection.
