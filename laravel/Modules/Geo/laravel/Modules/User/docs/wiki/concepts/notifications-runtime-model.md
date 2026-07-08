---
title: "notifications — modello runtime User"
type: concept
tags: [user, notifications, database-notification, notification-schema]
created: 2026-06-10
updated: 2026-06-10
qmd: notifications runtime user databasenotification NotificationSchema unread
issues: []
discussions: []
---

# notifications — modello runtime User

## Ruolo

`Modules\User\Models\Notification` estende `Illuminate\Notifications\DatabaseNotification`.

- Connessione: `user` (`fixcity_user`)
- Usato da `BaseUser::notifications()` e `unreadNotifications()` nel FO/header

## Schema owner (non qui)

**Vietato** `create_notifications_table` in User. Owner = **Notify** (`XotBaseMigration`).

- Regola: [no-notifications-migration-in-user-module](../rules/no-notifications-migration-in-user-module.md)
- Canon Notify: [notifications-database-contract](../../../Notify/docs/wiki/concepts/notifications-database-contract.md)

## Guard schema FO

`Modules\User\Support\NotificationSchema::isReadable()` verifica `Schema::connection(...)->hasTable('notifications')` prima di query nel header.

Usare quando il DB legacy potrebbe non aver ancora migrato — evita 500 su `unreadNotifications()->count()`.

## Pagina Folio

[notifications-folio-page.md](notifications-folio-page.md) — `route('notifications')`, non `area-personale.notifiche`.

## Collegamenti

- [notifications-folio-page.md](notifications-folio-page.md)
- [notifications-database-contract](../../../Notify/docs/wiki/concepts/notifications-database-contract.md)
- [fo-folio-named-routes-header.md](../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-named-routes-header.md)
