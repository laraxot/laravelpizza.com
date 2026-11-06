---
title: "Project context: solo Filament widget"
type: constitution
module: User
status: approved
track: campaign
related:
  - ./project-context.md
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "project context   campagna livewire http → widget user"
---

# Project context: campagna Livewire HTTP → widget

Costituzione della **campagna**, non del solo slice SuperAdmin. Lo slice SuperAdmin resta in [project-context.md](./project-context.md).

## Perché esiste

Il panel Filament è la porta dell’identità. L’UI di quella porta deve vivere nel namespace Filament (`XotBaseWidget`), non in `Http\Livewire`. Due stack UI sullo stesso chrome hanno già spento `/admin`.

## Utenti

- Operatore panel (`/admin`): menu, team, login social.
- Utente FO auth: login/register/password: già coperti da widget; gli HTTP sono gemelli orfani.
- Maintainer User: un solo albero da far passare a PHPStan e agli upgrade Filament.

## Vincoli non negoziabili

1. Estendere `XotBaseWidget` / `XotBaseSchemaWidget`, mai `Filament\Widgets\Widget` o `Livewire\Component` nudo per UI admin.
2. Nessuna nuova dipendenza Jet/FilamentJet.
3. Viste chrome: `user::filament.widgets…`. Auth tema: `pub_theme::` solo se il tema è SSoT, **mai** copiata in `render()` con `ViewCopyAction`.
4. Chrome (user menu, login form after): `$isDiscovered = false` + hook FQCN. KPI dashboard: discovery ok.
5. Business logic invariata: trait, Action, Spatie. Si cambia il guscio.
6. `laravel/phpstan.neon` immutabile.
7. Nessun `->label()` hardcoded; lang `user::`.
8. Un file PHP contended per story sul provider: un hook per volta.
9. Privacy/Terms non rientrano in User: Gdpr.

## Fuori costituzione

Notify vendor, canale `notifications` Laravel, Resource Filament, riattivazione Volt (altro epic).
