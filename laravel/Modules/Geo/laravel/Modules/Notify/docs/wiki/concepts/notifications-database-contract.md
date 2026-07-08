---
title: "notifications — schema Notify, runtime User"
type: concept
tags: [notify, notifications, migration, database, user-connection, xotbasemigration]
created: 2026-06-10
updated: 2026-06-10
qmd: notifications database notify owner xotbasemigration user forbidden
---

# notifications — schema Notify, runtime User

## Religione (boundary)

| Ruolo | Modulo | Artefatto |
|-------|--------|-----------|
| **Schema owner** | **Notify** | unica `create_notifications_table` (`XotBaseMigration`) |
| **Runtime Eloquent** | **User** | `Modules\User\Models\Notification` |
| **Connessione** | `user` | `fixcity_user` |

Notify **persiste** il canale DB; User **è** il notifiable. La migrazione **non** va in User.

## Anti-pattern esplicito (vietato)

```
❌ laravel/Modules/User/database/migrations/2026_07_02_000000_create_notifications_table.php
❌ return new class extends Migration
❌ Schema::create manuale senza tableCreate/tableUpdate
```

## Fonte di verità (unica)

`laravel/Modules/Notify/database/migrations/2026_06_10_134000_create_notifications_table.php`

- `protected ?string $model_class = Modules\User\Models\Notification::class`
- `tableCreate` + `tableUpdate` idempotente
- `updateTimestamps()` in `tableUpdate`

## Regola operativa

| Azione | Consentito |
|--------|------------|
| Manca colonna | Edit owner Notify → bump timestamp → `php artisan migrate` |
| `create_notifications` in User/ | **Vietato** |
| `extends Migration` | **Vietato** |
| `migrate --force` | **Vietato** |

## Bump timestamp

```bash
cd laravel/Modules/Notify/database/migrations
mv 2026_06_10_134000_create_notifications_table.php \
   2026_06_10_135000_create_notifications_table.php
cd ../../../..
php artisan migrate
```

## Runtime guard

`Modules\User\Support\NotificationSchema::isReadable()` — header FO e widget non queryano pre-migrate.

## Collegamenti

- [no-notifications-migration-in-user-module](../../User/docs/wiki/rules/no-notifications-migration-in-user-module.md)
- [notifications-runtime-model](../../User/docs/wiki/concepts/notifications-runtime-model.md)
- [one-migration-per-model](../../../../../docs/wiki/memories/one-migration-per-model-bump-timestamp.md)


## Pagina FO collegata (User + Sixteen)

La migrazione Notify abilita il DB; la **pagina** e il **link header** sono altrove:

| Pezzo | Owner |
|-------|-------|
| Tabella `notifications` | Notify (questo modulo) |
| Model `Notification` / unread | User |
| Folio `name('notifications')` | User `pages/notifications/` |
| `route('notifications')` header | Sixteen |

- [notifications-folio-page.md](../../User/docs/wiki/concepts/notifications-folio-page.md)
- [folio-list-vs-route-list.md](../../Cms/docs/wiki/concepts/folio-list-vs-route-list.md)
