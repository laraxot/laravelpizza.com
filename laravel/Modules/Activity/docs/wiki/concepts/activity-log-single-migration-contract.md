---
title: "activity_log — una migrazione per modello"
type: concept
tags: [activity, migration, spatie, activitylog, xotbasemigration]
created: 2026-06-10
updated: 2026-06-10
qmd: activity_log single migration xotbasemigration add fix update forbidden
---

# activity_log — una migrazione per modello

## Religione

Un modello (`Modules\Activity\Models\Activity` → `activity_log`) = **un solo** `create_activity_table.php`.

| Vietato | Perché | Consentito |
|---------|--------|------------|
| `add_*_to_activity_table` | seconda migrazione schema | `tableUpdate` nel file owner |
| `fix_*_causer_id_*` | idem | idem |
| `update_activity_log_schema` | `extends Migration` + nome fuori prototipo | `extends XotBaseMigration` |
| Secondo `create_activity_table` | DRY/KISS | edit owner + bump timestamp |

## Anti-pattern espliciti (rimossi)

```
❌ 2024_10_10_000000_add_attribute_changes_to_activity_table.php
❌ 2026_02_13_171410_fix_causer_id_to_uuid.php
❌ 2026_07_01_000000_update_activity_log_schema.php  (extends Migration)
```

Logica assorbita in `tableCreate` + `tableUpdate` idempotente: `attribute_changes`, `causer_id` uuid(36), morph subject, audit timestamps.

## Fonte di verità

`laravel/Modules/Activity/database/migrations/2026_06_10_141000_create_activity_table.php`

- Connessione: `activitylog` / `activity`
- `model_class` = `Modules\Activity\Models\Activity`

## Bump timestamp

```bash
cd laravel/Modules/Activity/database/migrations
mv 2026_06_10_141000_create_activity_table.php \
   2026_06_10_142000_create_activity_table.php
cd ../../../..
php artisan migrate
```

Mai `--force`. Mai `RefreshDatabase`.

## Storico

File errati in `database/migrations/_bak/README.md`.

## Runtime

`ActivityLogSchema::isWritable()` — verifica `attribute_changes` prima di loggare (FO/registrazione).

## Collegamenti

- [activity-log-attribute-changes-column](./activity-log-attribute-changes-column.md)
- [notifications-database-contract](../../../Notify/docs/wiki/concepts/notifications-database-contract.md)
- [one-migration-per-model](../../../../../docs/wiki/memories/one-migration-per-model-bump-timestamp.md)
