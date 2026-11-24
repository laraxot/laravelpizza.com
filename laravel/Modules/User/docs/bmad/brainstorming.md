---
title: "Brainstorming — SuperAdmin widget"

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

1. **Livewire HTTP** (oggi) — generico, alias stringa, già rotto con `filament-jet`.
2. **Badge Blade statico** (`user::badges.super-admin`, commentato nel provider) — niente click, viola il bisogno.
3. **Filament widget** (`XotBaseWidget`) montato sull’hook user-menu — chrome Filament, stesso Livewire sotto il cofano.

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

## Opzioni sui finding (2026-11-16)

### Dove fermare il bypass `{modulo}::admin`

- override in `RolePolicy`+`PermissionPolicy` (minimo)
- override in `UserBasePolicy` e riaprire per singola policy
- togliere il bypass da `XotBasePolicy` e fare opt-in per modulo

**Scelta lazy (KISS):** minimo: 2 override. L'opt-in globale è più sicuro ma rompe i pannelli cms/media/lang (ADR).

### `user::operator`

- crearlo solo con permessi espliciti
- eliminare il concetto e usare solo `user::admin`

**Scelta lazy (KISS):** decide il titolare: oggi è in `canAccessPanel` ma non è seminato (`PanelRoleSeeder` crea solo il ruolo del pannello).

### Domande aperte

- `Oauth*Policy`/`Device*Policy` devono davvero dipendere da permessi `hasPermissionToOrCreate`?
- Chi, oltre al super-admin, deve poter creare team?
