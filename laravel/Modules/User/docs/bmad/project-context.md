---
title: "Project context: SuperAdmin widget"
type: constitution
module: User
status: approved
track: quick-flow
related:
  - ./decision-log.md
  - ./prd.md
  - ./architecture.md
  - ./tech-spec.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "project context   superadmin nel user menu user"
---

# Project context: SuperAdmin nel user menu

Costituzione di **questo slice**, non del modulo User intero. Non contraddice la religione User (Actions, PHPStan max, Spatie ruoli, XotBase*).

## Perché esiste

Nel pannello Filament (`GET /admin`) un utente con ruolo `super-admin` o `negate-super-admin` deve **vedere e invertire** quel ruolo dal menu utente (icona corona), senza aprire una Resource. La logica di business vive sul profilo (`ProfileContract::toggleSuperAdmin()`). L’UI oggi è un Livewire in `Http/Livewire`, montato con un render hook: è chrome Filament, non un form pubblico.

## Utenti

- Operatore autenticato nel panel `admin`.
- Solo chi ha già `super-admin` o `negate-super-admin` vede il controllo. Chi non ha nessuno dei due vede vuoto.

## Vincoli non negoziabili

1. Estendere `XotBaseWidget`, mai `Filament\Widgets\Widget` diretto.
2. Nessuna nuova dipendenza (`filament-jet` resta fuori).
3. Namespace viste `user::filament.widgets…` (chrome admin). `pub_theme::` è per i widget auth del tema, non per questo hook.
4. Non mettere il widget nella griglia dashboard (`discoverWidgets` lo scansiona: va escluso).
5. Non cambiare `toggleSuperAdmin()` sul modello/trait: solo il contenitore UI.
6. `laravel/phpstan.neon` immutabile. Errori si risolvono nel codice, non con ignore.
7. Nessun `->label()` hardcoded: tooltip e testi da `user::` lang.
8. Documentazione e codice restano nel modulo User (repo `laraxot/module_user_fila5`).

## Fuori costituzione (slice SuperAdmin)

Team switcher, Socialite, Gdpr terms, Notify: [livewire-widget-project-context.md](./livewire-widget-project-context.md) + Epic 10.

Campagna: [livewire-inventory.md](./livewire-inventory.md).
