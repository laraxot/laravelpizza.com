---
title: "Pagina Folio notifiche — centro in-app"
type: concept
tags: [folio, notifications, user, front-office]
created: 2026-06-10
updated: 2026-06-10
qmd: "notifications folio page route name english header dropdown area-personale forbidden"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/289
related:
  - notifications-folio-route.md
  - notifications-runtime-model.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-named-routes-header.md
  - ../../../Cms/docs/wiki/concepts/folio-filesystem-routing-no-web-php.md
---

# Pagina Folio notifiche — centro in-app

## Scopo

Centro notifiche per utenti autenticati nel FO. **Owner UI**: modulo User. **Link header**: tema Sixteen.

La rotta non si definisce in `web.php` — esiste perché esiste il file sotto `pages/`.

## Contratto Folio

| Campo | Valore |
|-------|--------|
| File | `resources/views/pages/notifications/index.blade.php` |
| `name()` | `notifications` (inglese) |
| URL | `/it/notifications` |
| Middleware | `web`, `auth` |
| Widget | `NotificationsCenterWidget` |

```php
name('notifications');
middleware(['web', 'auth']);
```

## Header (tema Sixteen)

```blade
<a href="{{ route('notifications') }}" role="menuitem">
    <span>{{ __('pub_theme::header.user.dropdown.notifications.label') }}</span>
</a>
```


## Imparato — catena completa

```
File Folio (User)          name('notifications')
        ↓
FolioVoltServiceProvider   Folio::path + uri('it')
        ↓
folio:list                 GET /it/notifications
        ↓
Header Sixteen             route('notifications')
        ↓
Label IT                   pub_theme::header.user.dropdown.notifications.label
```

Schema DB notifiche: owner Notify — vedi `Modules/Notify/docs/wiki/concepts/notifications-database-contract.md`.

Runtime unread count: `NotificationSchema::isReadable()` in header prima del link.


## Anti-pattern (caso `area-personale.notifiche`)

| Vietato | Perché |
|---------|--------|
| `route('area-personale.notifiche')` | Nome inventato, non in `folio:list` |
| `/it/area-personale/notifiche` | Path non corrisponde al filesystem Folio |
| `Route::get` in `web.php` | FO = Folio only |

## Verifica

```bash
cd laravel && php artisan folio:list | grep notifications
```

Troubleshooting cache: [route-not-found-view-cache.md](../../../../Themes/Sixteen/docs/wiki/troubleshooting/route-not-found-view-cache.md)

## Collegamenti

- [Route name quick ref](notifications-folio-route.md)
- [Runtime model](notifications-runtime-model.md)
- [Folio no web.php](../../../Cms/docs/wiki/concepts/folio-filesystem-routing-no-web-php.md)
