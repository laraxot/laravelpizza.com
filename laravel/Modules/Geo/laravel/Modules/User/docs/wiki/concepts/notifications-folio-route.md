---
title: "notifications — named route Folio (FO)"
type: concept
tags: [user, notifications, folio, frontoffice, route]
created: 2026-06-10
updated: 2026-06-10
qmd: "notifications folio route name english area-personale notifiche forbidden folio list"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/289
related:
  - notifications-folio-page.md
  - notifications-runtime-model.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-named-routes-header.md
---

# notifications — named route Folio FO

Quick reference — dettaglio pagina: [notifications-folio-page.md](notifications-folio-page.md).

## Mapping

| Vietato | Corretto |
|---------|----------|
| `route('area-personale.notifiche')` | `route('notifications')` |
| `/it/area-personale/notifiche` | `/it/notifications` |

## Definizione rotta (Folio, non web.php)

File: `Modules/User/resources/views/pages/notifications/index.blade.php`

```php
name('notifications');
```

## Imparato (sessione 2026-06-10)

- La rotta **non** si registra in `web.php` né con `route()` nel Blade.
- `name('notifications')` nel file Folio User **crea** la named route.
- `route('notifications')` nel tema **risolve** l'URL.
- `folio:list` conferma; `route:list` può non mostrare la pagina FO.
- Errore persistente con sorgente corretto → cache view + riavvio `artisan serve`.

## Audit

```bash
php artisan folio:list | grep notifications
```
