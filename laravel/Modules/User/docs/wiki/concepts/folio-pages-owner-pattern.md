---
title: "Modulo User — owner pagine Folio, zero web.php"
type: concept
tags: [user, folio, pages, frontoffice, ownership]
created: 2026-06-10
updated: 2026-06-10
qmd: "user module folio pages owner notifications dashboard profile mount cms provider"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/289
related:
  - notifications-folio-page.md
  - notifications-folio-route.md
  - ../../../Cms/docs/wiki/concepts/folio-filesystem-routing-no-web-php.md
  - ../../../Cms/docs/wiki/concepts/folio-list-vs-route-list.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-named-routes-header.md
---

# Modulo User — owner pagine Folio, zero web.php

## Religione

| Ruolo | Modulo | Cosa fa |
|-------|--------|---------|
| **Owner pagine** | **User** | File in `resources/views/pages/` + `name()` + `middleware()` |
| **Mount rotte** | **Cms** | `FolioVoltServiceProvider` → `Folio::path()->uri($locale)` |
| **Link UI** | **Sixteen** | `route('<name>')` nel dropdown — non registra rotte |

Il modulo User **non** aggiunge `Route::get()` in `routes/web.php` per il FO.

## Pagine owner (header dropdown)

| File | `name()` | URL |
|------|----------|-----|
| `dashboard/index.blade.php` | `dashboard` | `/it/dashboard` |
| `notifications/index.blade.php` | `notifications` | `/it/notifications` |
| `profile/edit.blade.php` | `profile.edit` | `/it/profile/edit` |

Pagine auth/login spesso nel tema Sixteen; dominio profilo/notifiche resta User.

## Workflow nuova pagina User

1. `php artisan folio:page <path>` sotto `Modules/User/resources/views/pages/`
2. Blocco PHP: `name('english.name')`, `middleware(['web', 'auth'])` se serve
3. `php artisan folio:list` — verifica nome e path
4. Tema: `route('english.name')` solo se presente in `folio:list`

## Anti-pattern documentato

| Errore | Fix |
|--------|-----|
| `route('area-personale.notifiche')` | `route('notifications')` + file Folio User |
| Cercare rotta in `web.php` | Cercare file in `pages/` |
| `name()` in italiano | Inglese = segmento path |

## Collegamenti

- [notifications-folio-page.md](notifications-folio-page.md)
- [folio-list-vs-route-list.md](../../../Cms/docs/wiki/concepts/folio-list-vs-route-list.md)
