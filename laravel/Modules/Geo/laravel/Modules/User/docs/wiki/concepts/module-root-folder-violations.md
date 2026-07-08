---
title: "Violazioni struttura root — modulo User (risolto)"
type: concept
module: User
status: deprecated
tags: [module-structure, psr-4, cleanup, resolved]
created: "2026-06-18"
updated: "2026-06-18"
related:
  - ../../../../../../docs/wiki/bmad/architecture-module-directory-structure.md
  - ../../../../../../docs/wiki/rules/module-root-php-folders-forbidden.md
  - ../../directory-structure-checklist.md
qmd: "user module root folder violations resolved Actions Application Database Events Listeners"
---

# Violazioni struttura root — modulo User (risolto)

> **Stato:** ✅ Bonifica completata 2026-06-18. Cartelle root `Actions/`, `Application/`, `Database/`, `Events/`, `Listeners/` rimosse.

## Regola (canon)

[architecture-module-directory-structure.md](../../../../../../docs/wiki/bmad/architecture-module-directory-structure.md) — tutto il PHP sotto `app/`, DB sotto `database/` minuscolo.

## Storico

Il modulo User aveva copie legacy nella root (non PSR-4). I file attivi vivono in:

- `app/Actions/`, `app/Application/`, `app/Events/`, `app/Listeners/`
- `database/migrations/`, `database/factories/`

Inventario migration: [migrations-users-inventory.md](./migrations-users-inventory.md).

## Verifica

```bash
cd laravel/Modules/User
for bad in Actions Application Database Events Listeners; do
  [ -d "$bad" ] && echo "VIOLAZIONE: $bad"
done
```

Output atteso: vuoto.
