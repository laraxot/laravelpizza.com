---
title: "module-directory-structure-boundary — puntatore"
type: reference
updated: 2026-06-18
related:
  - ../../../../../../docs/wiki/rules/module-root-php-folders-forbidden.md
  - ../../../../../../laravel/Modules/Xot/docs/module-directory-structure-rule.md
---

# Struttura directory — confine tema vs modulo

I **temi** (`laravel/Themes/{Nome}/`) seguono la stessa logica: **codice PHP solo sotto `app/`**.

| Layer | Dove vive la logica |
| :--- | :--- |
| Business / dominio | `laravel/Modules/*/app/` |
| Presentazione Filament/Blade | `laravel/Themes/*/app/` + `resources/views/` |

## Vietato anche nei temi

Cartelle `Actions/`, `Models/`, `Http/` nella **root** del tema — stesso anti-pattern dei moduli.

## Canon

- [architecture-module-directory-structure.md](../../../../../../docs/wiki/bmad/architecture-module-directory-structure.md)
