---
title: "XotBaseResourceTable Columns Enforcement — Xot Module"
type: concept
sources: []
confidence: high
created: 2026-05-07
updated: 2026-05-07
tags: [xotbase, filament, tables, enforcement]
related:
  - xotbase-resource-form-pattern.md
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
---

# Xot Module: XotBaseResourceTable Columns

7 Table files populated with columns from Sushi and DB-based models:

- **LogsTable**: id, name, size, created_at, updated_at (Sushi model reading storage/logs)
- **SessionsTable**: id, user_id, ip_address, user_agent, last_activity, created_at, updated_at (standard Laravel sessions)
- **ModulesTable**: id, name, description, status (badge), priority, path, icon, created_at, updated_at (Sushi from nwidart)
- **ExtrasTable**: id, model_type, model_id, extra_attributes, created_at, updated_at (spatie SchemalessAttributes)
- **CachesTable**: key, value, expiration, created_at, updated_at (table=cache, primaryKey=key)
- **CacheLocksTable**: key, owner, expiration, created_at, updated_at

Resources: CacheLock, Cache, Extra, Log, Module, Session

Note: XotBaseResourceTable.php itself is the abstract base class (not counted above).
