---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget decision log"
issues: []
discussions: []
title: "Decision log — Notify"
type: decision-log
module: Notify
related:
  - ./livewire-inventory.md
---

# Decision log

## [2026-09-21] FQCN, non fork

Docs only. Un file provider.

## [audit] FQCN già in codice; zero componenti posseduti

`AdminPanelProvider.php:37` monta `DatabaseNotifications::class` (FQCN) — la story 12.1 è già soddisfatta, va marcata done. `Http/Livewire` contiene solo `_components.json` (`[]`) e due `.fila2` inerti (`Auth/FilamentLogin`, relitto savannabits). Gate `disable_database_notifications` default `true`. Citazioni: [livewire-inventory.md](./livewire-inventory.md).
