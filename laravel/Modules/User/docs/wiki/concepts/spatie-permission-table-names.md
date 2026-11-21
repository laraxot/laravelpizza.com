---
title: spatie permission table names contract
type: concept
module: User
tags: [spatie, permission, config, migration, model_has_role, immutable]
updated: 2026-07-27
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/7"
related:
  - ../../bugfix-permission-table-names-singular.md
  - ./spatie-permission-migration-no-table-name.md
  - ../../../../../config/permission.php
  - ../../../Themes/docs/shared-components/spatie-permission-philosophy.md
---

# Spatie Permission — config `table_names` immutabile

## Regola assoluta (maintainer)

**`laravel/config/permission.php` → `table_names` non si modifica mai dagli agenti.**

Le query, Spatie, i modelli pivot e le migrazioni (`Model*::getTable()`) **seguono** la config — **mai** il contrario.

Overlay `config/local/{tenant}/permission.php`: **no** `table_names` (solo `models` se serve).

## Valori canon

| Chiave config (Spatie) | Tabella DB |
|------------------------|------------|
| `model_has_roles` | `model_has_role` |
| `model_has_permissions` | `model_has_permission` |
| `role_has_permissions` | `role_has_permission` |

## Catena

```
config/permission.php (fissa)
  → ModelHasRole::getTable()
  → XotBaseMigration via $model_class
  → Spatie HasRoles / HasPermissions
```

## Errore 1146 — fix corretto

1. `php artisan config:show permission.table_names`
2. `SHOW TABLES` sul DB modulo User
3. Se mismatch: **migrazione** sul modello pivot (nome tabella dal modello, mai letterale)
4. `php artisan config:clear`
5. **Non** toccare `permission.php`

## Anti-pattern

| ❌ | Perché |
|----|--------|
| Modificare `table_names` in config | Config = scelta utente |
| `Schema::rename('model_has_role', 'model_has_roles')` | Schema inseguisce errore query |
| Tabella default plurale Spatie | Laraxot usa singolare in config |
| `$table` hardcoded sul modello | Ignora config |

## Riferimenti

- [bugfix-permission-table-names-singular.md](../../bugfix-permission-table-names-singular.md)
- [spatie-permission-migration-no-table-name.md](./spatie-permission-migration-no-table-name.md)
