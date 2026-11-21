---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget prd"
issues: []
discussions: []
title: "PRD — Notify hook FQCN"
type: prd
module: Notify
related:
  - ./livewire-inventory.md
---

# PRD Notify

### FR-N001 [MUST] Hook usa `DatabaseNotifications::class`. — **già soddisfatto** (`AdminPanelProvider.php:37`)
### FR-N002 [MUST] Nessun `NotifyDatabaseNotificationsWidget` nuovo.
### FR-N003 [MUST] `disable_database_notifications` resta il gate (default `true`, XotData.php:61).
### FR-N004 [MUST] User non riattiva l'hook commentato (`Modules/User/.../AdminPanelProvider.php:41-47`).

Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).
