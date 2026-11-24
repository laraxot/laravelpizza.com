---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget project context"
issues: []
discussions: []
title: "Project context — Gdpr legal UI"
type: constitution
module: Gdpr
related:
  - ./livewire-inventory.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
---

# Context Gdpr

Costituzione piattaforma: [Xot](../../Xot/docs/bmad/livewire-widget-project-context.md). Gdpr possiede consenso e testi legali; User non deve tenere Privacy/Terms Livewire. Vincoli ereditati: estendere `XotBaseWidget`, mai `Filament\Widgets\Widget` diretto; chrome con `$isDiscovered = false` + FQCN; FO/legal ≠ widget forzato.

Stato verificato del modulo: [livewire-inventory.md](./livewire-inventory.md) (zero `Http\Livewire`, 2 widget auth già Filament).
