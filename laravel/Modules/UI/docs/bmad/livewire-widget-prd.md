---
title: "PRD: Livewire UI → widget"
type: prd
module: UI
related:
  - ./livewire-inventory.md
  - ./livewire-widget-architecture.md
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "prd ui ui"
---

# PRD UI

### FR-UI-001 [MUST] HTTP DarkMode assente; widget + Blade wrapper restano.
### FR-UI-002 [MUST] HTTP Toast assente se nessun chiamante.: condizione verificata **falsa**: chiamanti reali in `UI layouts/main.blade.php:28` e `User layouts/main.blade.php:49`; il requisito non si applica, Toast resta.
### FR-UI-003 [MUST] Nessun widget nuovo. Nessun `->widgets()` per dark mode chrome se `$isDiscovered` già gestito.
### FR-UI-004 [MUST] `InteractiveMap` non diventa widget: contenuto non-chrome, non registrato/montato, deps Geo assenti ([livewire-inventory.md](./livewire-inventory.md)).

Out: implementare in questa sessione; toccare Filament native dark mode panel.
