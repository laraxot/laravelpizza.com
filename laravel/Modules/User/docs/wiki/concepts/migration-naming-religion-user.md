---
title: "User — religione naming migrazioni"
type: concept
module: User
tags: [user, migrations, naming, xot-base-migration, one-per-model]
created: 2026-07-27
updated: 2026-07-27
qmd: "user module migration naming create table snake case one model no connection xotbase"
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_workorder_fila5/discussions/8"
related:
  - ./teams-owner-id-in-create-migration.md
  - ./model-migration-seeder-rule.md
  - ../../../../Xot/docs/wiki/concepts/xotbase-migration-religion.md
  - ../../../../../../docs/wiki/concepts/xotbase-migration-religion.md
  - ../../../../../laravel/Themes/docs/shared-components/xotbase-migration-religion.md
---

# Migrazioni User — logica, politica, zen

## Zen

Un modello, un file `create_*`, zero `$connection` — la tabella parla tramite il Model.

## Naming file

```
{data}_{create}_{tabella_snake}_table.php
```

| Segmento | Regola | Esempio |
|----------|--------|---------|
| data | `YYYY_MM_DD_HHMMSS` | `2026_07_27_102200` |
| create | sempre `create_` | — |
| tabella | snake_case dal model | `teams` ← `Team` |
| suffisso | `_table.php` | — |

**Esempio canon:** `2026_07_27_102200_create_teams_table.php`

## Parità modulo

N modelli concreti owner → N `create_*` + N factory + N seeder.

Audit: `bash bashscripts/tools/audit-module-artifact-parity.sh User`

## Vietato

- `add_*_to_*`, `drop_*`, `fix_*`, `repair_*` sulla tabella owner
- `extends Migration` / `Schema::create('teams', …)`
- `protected string $connection` — connection dal model `Team` / `BaseModel`
- `$table->timestamps()` in `tableCreate` se usi `updateTimestamps` in `tableUpdate`

## Evoluzione (forward-only)

1. Edit unico `create_{table}_table.php` (`tableUpdate` + `hasColumn`)
2. Rinomina con timestamp **più recente** (bump)
3. `php artisan migrate` — mai `--force`, mai `RefreshDatabase`

## FK User

```php
$userClass = XotData::make()->getUserClass();
$table->foreignIdFor($userClass, 'owner_id')->nullable()->index();
```

Mai `constrained('users')` cross-DB.

## Caso studio: Team

Vedi [teams-owner-id-in-create-migration.md](./teams-owner-id-in-create-migration.md).

## Pivot Spatie (`ModelHasRole`, …)

- File: `create_model_has_role_table.php` (snake del **modello**, non del valore config)
- Tabella: **mai** nel file — `XotBaseMigration` usa `ModelHasRole::getTable()` → `config('permission.table_names.model_has_roles')`
- Fix 1146: solo config + `config:clear` — vedi [spatie-permission-migration-no-table-name.md](./spatie-permission-migration-no-table-name.md)

## Debt noto (non in scope singolo fix)

Più file `create_team_user_table.php` duplicati — consolidare a **uno** con bump (stessa religione).
