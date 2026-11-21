---
title: "User — teams owner_id in create, no add_*"
type: concept
module: User
tags: [user, teams, migrations, xot-base-migration, owner_id, naming]
created: 2026-07-27
updated: 2026-07-27
qmd: "user teams owner_id create_teams_table no add_owner_id migration naming create snake_case"
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_workorder_fila5/discussions/8"
related:
  - ./migration-naming-religion-user.md
  - ../../../../Xot/docs/wiki/concepts/xotbase-migration-religion.md
  - ../../../../../../docs/wiki/concepts/xotbase-migration-religion.md
---

# Teams — `owner_id` nella create (non in `add_*`)

## Anti-pattern rimosso (2026-07-27)

`2025_05_16_221811_add_owner_id_to_teams_table.php` violava:

| Violazione | Dettaglio |
|------------|-----------|
| Naming | `add_*_to_*` invece di `create_{table}_table` |
| One-model-one-migration | secondo file sulla stessa tabella owner |
| FK errata | `foreignIdFor(Team::class, 'owner_id')` — self-FK; owner è **User** |
| `$connection` | vietato (non serviva, ma pattern sbagliato) |

## Canon attuale

File unico: `database/migrations/2026_07_27_102200_create_teams_table.php`

- `extends XotBaseMigration`
- `protected ?string $model_class = Team::class`
- `owner_id` + `user_id` → `foreignIdFor(XotData::make()->getUserClass(), …)` senza `constrained('users')`
- `tableCreate` + `tableUpdate` idempotente + `updateTimestamps($table, true)`
- Nessun `protected $connection`

## Religione naming

```
{YYYY_MM_DD_HHMMSS}_create_{table_snake}_table.php
```

Evoluzione schema → edit questo file + **bump timestamp** nel nome — mai nuovo `add_*`.

Vedi [migration-naming-religion-user.md](./migration-naming-religion-user.md).
