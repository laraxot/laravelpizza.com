---
title: "RouteNotFoundException — Folio FO"
type: troubleshooting
tags: [cms, folio, routing, troubleshooting, view-cache]
created: 2026-06-10
updated: 2026-06-10
qmd: "RouteNotFoundException folio area-personale notifiche view cache optimize clear"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/289
related:
  - ../concepts/folio-filesystem-routing-no-web-php.md
  - ../../../../Themes/Sixteen/docs/wiki/troubleshooting/route-not-found-view-cache.md
---

# RouteNotFoundException — Folio FO

## Sintomo tipico

`Route [area-personale.notifiche] not defined` in `user-dropdown.blade.php` su `GET /it` (utente autenticato).

## Diagnosi

1. **Nome rotta inventato** — `area-personale.notifiche` non esiste in Folio. Canonico: `notifications` → `/it/notifications`.
2. **Sorgente già fixato ma errore persiste** — vista compilata stale o processo PHP non riavviato.
3. **Confusione web.php** — si cerca la rotta in `routes/web.php`; in FO vive solo in `pages/`.

## Verifica rapida

```bash
cd laravel
grep -n "route(" Themes/Sixteen/resources/views/components/sections/header/partials/user-dropdown.blade.php
# atteso: route('notifications') — NON area-personale.notifiche

php artisan folio:list | grep notifications
php artisan tinker --execute="echo route('notifications');"
```

## Fix

```bash
cd laravel
php artisan view:clear
php artisan optimize:clear
# riavviare php artisan serve (Ctrl+C e ripartire)
```

Hard refresh browser (Ctrl+Shift+R).


## `folio:list` vs `route:list`

Non usare `route:list --name=notifications` per validare il FO. Usare [folio-list-vs-route-list.md](../concepts/folio-list-vs-route-list.md).

## Indizio cache stale

Se nel log compaiono query su `notifications` (count unread) **e** subito dopo `RouteNotFoundException` su `user-dropdown` → il sorgente su disco è probabilmente già corretto; il PHP sta eseguendo Blade compilato vecchio.

```bash
grep -r "area-personale.notifiche" storage/framework/views/ || echo "OK: nessuna view compilata stale"
```


## Regola post-fix

- Pagina owner: `Modules/User/resources/views/pages/notifications/index.blade.php`
- `name('notifications')` — mai italiano nel `name()`
- Header: `route('notifications')` + label `pub_theme::header.user.dropdown.notifications.label`

## Collegamenti

- [filesystem routing](../concepts/folio-filesystem-routing-no-web-php.md)
- [Sixteen view cache](../../../../Themes/Sixteen/docs/wiki/troubleshooting/route-not-found-view-cache.md)
