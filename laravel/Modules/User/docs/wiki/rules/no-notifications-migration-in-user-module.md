---
title: vietato create_notifications_table nel modulo User
type: rule
tags:
dates:
  created: 2026-06-10
  updated: 2026-06-10
qmd:
issues: []
discussions: []
related:
  - "./agent-confidence-protocol.md"
  - "./can-comment-retired-wrong-placement.md"
  - "./frontend-stack-canonical.md"
  - "./header-auth-flow.md"
  - "./header-design-colors.md"
  - "./module-commit-push-after-change.md"
  - "./navigation-properties.md"
  - "./no-filament-labels.md"
---

# Vietato `create_notifications_table` in User

## Perché

- **Schema owner** = modulo **Notify** (dominio canale/persistenza notifiche)
- **Runtime** = `Modules\User\Models\Notification` + `BaseUser::unreadNotifications()` (notifiable)
- Mettere la migrazione in User confonde owner e rompe la regola **1 modello = 1 create_*** nel modulo giusto

## Anti-pattern (vietato)

```php
// ❌ Modules/User/database/migrations/2026_07_02_000000_create_notifications_table.php
return new class extends Migration { ... };
```

| Errore | Corretto |
|--------|----------|
| File in `User/database/migrations/` | Solo in `Notify/database/migrations/` |
| `extends Migration` | `extends XotBaseMigration` |
| `Schema::connection(...)->create(...)` manuale | `tableCreate` + `tableUpdate` idempotente |

## Fonte di verità

`laravel/Modules/Notify/database/migrations/2026_06_10_134000_create_notifications_table.php`

Contratto: [notifications-database-contract](../../../../Notify/docs/wiki/concepts/notifications-database-contract.md)

## Se manca tabella su `fixcity_user`

1. Edit file owner **Notify** + bump timestamp nel nome
2. `cd laravel && php artisan migrate` — mai `--force`

## Collegamenti

- [notifications-runtime-model](../concepts/notifications-runtime-model.md)
- [main-module-profiles-ownership](../../../../Fixcity/docs/wiki/concepts/main-module-profiles-ownership.md) (stesso pattern boundary)
