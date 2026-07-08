---
title: "XotBaseResourceTable Columns Enforcement — User Module"
type: concept
sources: []
confidence: high
created: 2026-05-07
updated: 2026-05-07
tags: [xotbase, filament, tables, enforcement]
related:
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
---

# User Module: XotBaseResourceTable Columns

24 Table files populated with columns derived from User module Models and Passport migrations.

Resources: AuthenticationLog, Client, Device, Feature, OauthAccessToken, OauthAuthCode, OauthClient, OauthPersonalAccessClient, OauthRefreshToken, PasswordReset, Permission, PersonalAccessToken, Profile, Role, SocialProvider, SocialiteUser, SsoProvider, TeamInvitation, TeamPermission, Team, TeamUser, Tenant, TenantUser, User

Key conventions applied:
- Models use `BaseModel` / `BasePivot` casts (id as string, uuid, datetime)
- SoftDeletes models include `deleted_at` (toggleable)
- Boolean columns use `->badge()`
- Passport models follow standard Laravel Passport schema
