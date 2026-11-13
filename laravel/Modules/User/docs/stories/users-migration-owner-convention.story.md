---
title: "User migration owner convention"
type: story
bmad: true
status: complete
owner: module:User
tags: [user, migration, convention, schema]
---

# User migration owner convention

The `User` model has one canonical owner migration:
`2026_11_12_120000_create_users_table.php`.

When the owner schema needs a column correction, update that migration and refresh
its timestamp. Do not add a parallel `repair_*`, `add_*`, or `update_*` migration
for the same model/table. This preserves the module rule:

> one model → one migration → one seeder → one factory

The migration remains forward-only and idempotent through `XotBaseMigration`,
`tableCreate()`, `tableUpdate()`, `hasColumn()` and `updateTimestamps()` guards.
The `deleted_at` repair is therefore part of the User owner migration, not a
second migration.
