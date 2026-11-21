---
title: "GetTenantNameAction — path safety typo fix"
type: troubleshooting
tags: [tenant, pageslugmiddleware, sushi, cms]
created: 2026-07-13
updated: 2026-07-13
qmd: "GetTenantNameAction containsUnsafePathCharacters Page Sushi zero pages middleware auth"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/362"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/363"
related:
  - ../concepts/cms-page-middleware-json-ssot.md
  - ../../../../Fixcity/docs/wiki/concepts/ticket-crea-url-routing-chain.md
---

# Tenant name — Page Sushi vuoto → auth JSON ignorato

## Sintomo

- `GET /it/tickets/create` → 200 per guest (dovrebbe 302 login)
- `Page::count()` → 0
- `PageSlugMiddleware` non applica `auth` dal JSON

## Causa (2026-07-13)

`GetTenantNameAction` chiamava metodo inesistente `containsUnsafeTenantPathCharacters()` → fatal in bootstrap tenant → pagine CMS non caricate da `config/local/fixcity/database/content/pages/`.

## Fix

Usare `containsUnsafePathCharacters()` (metodo esistente nella stessa classe).

## Verifica

```bash
cd laravel && php artisan optimize:clear
curl -sI http://127.0.0.1:8000/it/tickets/create | head -3   # 302 → login
php -r "require 'vendor/autoload.php'; \$a=require 'bootstrap/app.php'; \$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo Modules\Cms\Models\Page::count();"
```

Atteso: count > 0, guest redirect.
