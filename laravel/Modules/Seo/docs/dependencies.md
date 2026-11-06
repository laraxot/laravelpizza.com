---
title: "dependencies"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "dependencies"
issues: []
discussions: []
status: active
---

# Dependencies (Module Seo)

Canonical dependency map:

- [../../../../docs/dependencies.md](../../../../docs/dependencies.md)

Module/theme specific notes:

- `spatie/laravel-sitemap` ^7.0 — sitemap.xml generation.
- `spatie/laravel-feed` ^4.4 — RSS/Atom feed capability, dichiarato qui perché trasversale (usabile da qualunque modulo con contenuti indicizzabili: blog, catalogo prodotti, ecc.), non legato a un singolo modulo consumer. Consumer attuale: `Modules/Blog` (`Article implements Feedable`). Vedi `Modules/Blog/docs/dependencies.md`.
- Installazione pacchetti moduli: dichiarare in `Modules/{Nome}/composer.json`, poi da `laravel/` root `composer update -W` (no nome pacchetto) — root `composer.json` resta minimo, merge-plugin nwidart unisce tutti i `Modules/*/composer.json`. Mai installare dipendenze di modulo a root.
---
- (add notes here when a dependency is directly used by this module/theme)

Installed packages index:

- [../../../../docs/packages/index.md](../../../../docs/packages/index.md) _(target mancante, verificato 2026-10-08)_
