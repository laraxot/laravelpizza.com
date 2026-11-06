---
title: "Conversione Livewire → widget: UI"
type: pointer
module: UI
status: superseded-stale
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "ui   canone (non l’analisi 2026-08-25) ui"
---

# UI: canone (non l’analisi 2026-08-25)

SSoT: [livewire-inventory.md](./livewire-inventory.md).

**Scartato** (file maiuscolo precedente):

- creare `ThemeToggleWidget`: esiste già `DarkModeSwitcherWidget`
- creare `ToastNotificationWidget`: toast panel = Filament Notifications / `@livewire('notifications')`
- “UI non ha widget Filament”: falso: 14 widget sotto `Filament/Widgets`
- Epic 10 / story 10.1–10.2 UI: numerazione User; UI è **12.1 ritiro HTTP**

Verdetto: ritiro gemelli HTTP, non nuovi widget. `Toast` resta (montato nel layout radice). `InteractiveMap` (sotto `app/Livewire`, non `Http/Livewire`) è orfano e fuori scope widget: vedi inventario.
