---
title: activity_log — colonna attribute_changes (Spatie v4+)
type: concept
tags: [activity, spatie, migration, register]
qmd:
  index: true
created_at: 2026-06-10
updated_at: 2026-06-10
---

# activity_log — attribute_changes

## Perché

Spatie `laravel-activitylog` v4+ scrive `attribute_changes` (anche `[]`) su INSERT. Senza colonna → errore 1054.

## Schema owner (unica migrazione)

`2026_06_10_140000_create_activity_table.php` — vedi [activity-log-single-migration-contract.md](activity-log-single-migration-contract.md).

```bash
cd laravel && php artisan migrate
```

## Runtime

`Modules\Activity\Support\ActivityLogSchema::isWritable()` — connection da `config('activitylog.database_connection')`.

## Collegamenti

- [activity-log-single-migration-contract.md](activity-log-single-migration-contract.md)
