---
qmd: "ARCHITECTURE"
issues: []
discussions: []
title: "Notify Module Architecture"
type: architecture
tags: [module, architecture, notifications]
created: 2026-07-28
updated: 2026-07-28
status: superseded
superseded_by: architecture.md
---

# Notify Module: Architecture

## Purpose
Manages notifications and messaging via Laravel Notifications and Mailable. Supports email, Slack, SMS, in-app notifications.

## Core Components
- `Notification` classes for each notification type
- `Mailable` classes for email templates
- Filament notification UI
- Queue integration

## Database
- `notifications` table: id, notifiable_id, notifiable_type, type, data, read_at, created_at
