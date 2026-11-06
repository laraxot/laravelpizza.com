---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget project context"
issues: []
discussions: []
title: "Project context: Notify notifications"
type: constitution
module: Notify
related:
  - ./livewire-inventory.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
status: draft
---

# Context Notify

Le campanelle del panel sono Filament Notifications (vendor). Notify le monta e le configura (trigger custom `notify::livewire.database-notifications-trigger`, polling 60s, gate `XotData::disable_database_notifications`); non le riscrive come widget proprio. Costituzione piattaforma: [Xot](../../Xot/docs/bmad/livewire-widget-project-context.md).

Stato verificato: [livewire-inventory.md](./livewire-inventory.md).
