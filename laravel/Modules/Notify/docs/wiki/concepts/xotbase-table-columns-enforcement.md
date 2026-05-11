---
title: "XotBaseResourceTable Columns Enforcement — Notify Module"
type: concept
sources: []
confidence: high
created: 2026-05-07
updated: 2026-05-07
tags: [xotbase, filament, tables, enforcement]
related:
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
---

# Notify Module: XotBaseResourceTable Columns

5 Table files populated with columns from notification models.

Resources: Contact, MailTemplate, Notification, NotificationTemplate, NotifyTheme

Columns derived from Model `$fillable` and `$casts` properties. Includes standard `id`, `created_at`, `updated_at` columns plus notification-specific fields.
