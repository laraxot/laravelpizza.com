---
title: "Folio app pages: owner modulo (non tema)"
type: concept
tags: [user, folio, area-personale, dashboard, pageslugmiddleware]
created: 2026-07-13
updated: 2026-07-13
qmd: "user module folio app pages area-personale dashboard not in theme sixteen"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/362"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/363"
related:
  - ../../../../../Themes/Sixteen/docs/page-directory-structure.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/folio-volt-app-pages.md
  - folio-app-pages-owner.md
  - ../../../../../Themes/Sixteen/docs/page-directory-structure.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/folio-volt-app-pages.md
  - folio-app-pages-owner.md
status: draft
---

# Folio app pages: owner `User`

## Perché non nel tema

`Themes/Sixteen/resources/views/pages/` accetta solo `auth/`, `[container0]/`, `tests/` (+ `index.blade.php` home).

Pagine con **logica utente** (dashboard, area personale) vivono qui:

```text
Modules/User/resources/views/pages/
├── dashboard/index.blade.php
├── area-personale/pratiche.blade.php
├── area-personale/servizi.blade.php
├── area-personale/impostazioni.blade.php
├── area-personale/notifiche.blade.php   # redirect → notifications
└── notifications/index.blade.php
```

Folio monta **tema prima**, poi **moduli** (`FolioVoltServiceProvider`). Rotte dominio solo nei moduli evitano collisioni e rispettano nwidart.

## Contratto Volt

- `PageSlugMiddleware` + JSON CMS (`dashboard.json`, `area-personale.*.json`)
- `new class extends Component` + `mount()` per query/redirect
- `@volt('…')` statico = `name()`

Canon: [folio-volt-app-pages.md](../../../../../Themes/Sixteen/docs/wiki/concepts/folio-volt-app-pages.md).
- `PageSlugMiddleware` + JSON CMS (`pages/area-personale/pratiche.json` e le altre voci: lo slug nel file è solo `pratiche`, la cartella aggiunge `area-personale.`)
- `new class extends Component` + `mount()` per query/redirect
- `@volt('…')` statico = `name()`

Canon: [folio-volt-app-pages.md](../../../../../Themes/Sixteen/docs/wiki/concepts/folio-volt-app-pages.md).

## Pratiche + Fixcity

`area-personale.pratiche` usa `BuildAuthenticatedUserTicketsQueryAction` (modulo **Fixcity**): dipendenza consumer→dominio ticket, non spostare la blade in Fixcity se la UX è area utente.

## Collegamenti

- [page-directory-structure.md](../../../../../Themes/Sixteen/docs/page-directory-structure.md)
- [personal-area-routes.md](../../../../../Themes/Sixteen/docs/wiki/concepts/personal-area-routes.md)
- [page-directory-structure.md](../../../../../Themes/Sixteen/docs/page-directory-structure.md)
- [personal-area-routes.md](../../../../../Themes/Sixteen/docs/wiki/concepts/personal-area-routes.md)
