---
title: "folio:list vs route:list — audit rotte FO"
type: concept
tags: [cms, folio, routing, artisan, troubleshooting]
created: 2026-06-10
updated: 2026-06-10
qmd: "folio list route list notifications named route audit frontoffice"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/289
related:
  - folio-filesystem-routing-no-web-php.md
  - ../troubleshooting/folio-route-not-found.md
---

# folio:list vs route:list — audit rotte FO

## Regola

Per il **front office Folio**, fonte di verità: **`php artisan folio:list`**, non `route:list`.

| Comando | Cosa mostra | Uso Laraxot |
|---------|-------------|-------------|
| `folio:list` | Pagine montate da `Folio::path()` + `name()` | **Audit FO** — menu header, link Blade |
| `route:list` | Rotte Laravel (web, Filament, API, …) | BO / infrastruttura — **non** elenca tutte le named Folio FO |

## Confusione osservata (2026-06-10)

`route:list --name=notifications` può mostrare **solo** rotte Filament Notify (`notify/admin/...`), mentre la pagina FO esiste:

```bash
php artisan folio:list | grep notifications
# GET /it/notifications  notifications  →  Modules/User/.../notifications/index.blade.php

php artisan tinker --execute="echo route('notifications');"
# http://fixcity.local/it/notifications
```

**Conclusione:** assenza in `route:list` ≠ rotta inesistente. Verificare sempre `folio:list` + `route()` in tinker.

## Workflow audit link header

```bash
cd laravel
php artisan folio:list | grep -E "services.categories|dashboard|notifications|profile.edit|logout|login"
```

Ogni `route('<name>')` nel Blade deve avere una riga corrispondente.

## Collegamenti

- [filesystem routing](folio-filesystem-routing-no-web-php.md)
- [RouteNotFoundException](../troubleshooting/folio-route-not-found.md)
