---
title: "Brainstorming: SuperAdmin widget"
type: brainstorming
module: User
status: done
related:
  - ./decision-log.md
  - ./architecture.md
  - ./prd.md
  - ./livewire-widget-brainstorming.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "brainstorming: dove vive il toggle superadmin user"
---

# Brainstorming: dove vive il toggle SuperAdmin

## Idea

Il toggle non è una pagina e non è un form. È un **privilegio visibile** nel chrome del panel. Tre contenitori possibili:

1. **Livewire HTTP** (oggi): generico, alias stringa, già rotto con `filament-jet`.
2. **Badge Blade statico** (`user::badges.super-admin`, commentato nel provider): niente click, viola il bisogno.
3. **Filament widget** (`XotBaseWidget`) montato sull’hook user-menu: chrome Filament, stesso Livewire sotto il cofano.

## Scelta

(3). Il widget Filament *è* un componente Livewire, ma nel namespace e nella discovery del panel.

## Scartato

- `userMenuItems()` MenuItem URL: non inverte un ruolo, naviga.
- Pagina Filament “Super admin”: troppa UI per un bit.
- Action nuova che wrappa `toggleSuperAdmin()`: il trait è già SSoT.
- Convertire anche `team.change` nello stesso slice: scope creep.
