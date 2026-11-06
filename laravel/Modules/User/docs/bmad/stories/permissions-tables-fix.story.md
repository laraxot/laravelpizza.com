---
title: "Story: permissions tables on fixcity_user"
type: story
module: User
status: done
created: 2026-10-05
updated: 2026-10-18
tags: [docs, user, bmad, permissions, connection]
qmd: "story permissions tables fixcity_user connection user"
related:
  - ../permissions-connection-ownership.md
  - ../authentication-logs-connection-ownership.md
---

# Story: permissions tables on `fixcity_user`

## Context

Spatie tables (`permissions`, `roles`, pivots) belong on connection `user`
(`DB_DATABASE_USER` / `fixcity_user`). Production symptom:
`Table 'fixcity_data.permissions' doesn't exist` on `GET /it/tickets/1`
via `BuildTicketTimelineAction` → `$viewer->can(...)`.

## Acceptance Criteria

- [x] Models `Permission` / `Role` use `$connection = 'user'`.
- [x] Canonical `create_*` migrations create the tables on the user DB.
- [x] Ownership documented in [permissions-connection-ownership](../permissions-connection-ownership.md).
- [x] Public ticket timeline soft-guards missing `permissions` table.
- [x] Filament: `PermissionResource` stays in User panel.

## Implementation

See ownership doc. Deploy: fix `.env`, `config:clear`, run User migrations.
