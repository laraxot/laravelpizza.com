---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget architecture"
issues: []
discussions: []
title: "Architecture — Notify"
type: architecture
module: Notify
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Architecture Notify

```
XotData.disable_database_notifications (default true, XotData.php:61)
  └─ false → trigger + polling(60s) + hook panels::user-menu.before
                 └─ @livewire(Filament\Notifications\Livewire\DatabaseNotifications::class)
                      (già FQCN in AdminPanelProvider.php:37)
```

ADR: vendor resta vendor. Il riferimento è **già** tipizzato — nessun PHP da toccare. Verdetto: [livewire-inventory.md](./livewire-inventory.md).
