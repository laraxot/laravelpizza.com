---
title: "CMS page middleware — JSON SSoT + PageSlugMiddleware"
type: concept
tags: [cms, middleware, folio, auth, pages-json]
created: 2026-06-12
updated: 2026-06-12
qmd: "cms page middleware json auth PageSlugMiddleware tickets.create folio route name container0 slug0"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/362"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/363"
related:
  - ../../../../docs/stories/STORY-357-tickets-create-auth-middleware.md
  - ../architecture/template-theme-cms-runtime-architecture.md
---

# Middleware per pagina CMS (JSON)

## Scopo

Definire **access control per pagina** nel JSON CMS (`config/local/.../content/pages/*.json`), eseguito a runtime da `PageSlugMiddleware` sul Folio della pagina.

## Contratto JSON

```json
{
  "slug": "tickets.create",
  "middleware": ["auth"]
}
```

Alias supportati come su Laravel (`auth`, `verified`, classi FQCN, parametri `throttle:60,1`).

## Flusso

1. Folio page registra `middleware(PageSlugMiddleware::class)`.
2. `PageSlugMiddleware` risolve lo **slug CMS**:
   - `route()->getName()` se esiste pagina (es. `tickets.create`)
   - `{container0}.{slug0}` o `{container0}.{slug}` per `cms.view` / `container0.view`
   - segmento `slug` / `slug0` da solo se match pagina CMS
3. `Page::getMiddlewareBySlug($slug)` legge l'array dal modello Sushi/JSON.
4. Esecuzione catena middleware (es. `auth` → login localizzato).

## Esempio Fixcity

- URL: `/it/tickets/create`
- Folio: `Modules/Fixcity/resources/views/pages/tickets/create.blade.php` (`name('tickets.create')`)
- JSON: `tickets.create.json` con `"middleware": ["auth"]`

**Nota:** la shell generica `Themes/Sixteen/.../[container0]/[slug].blade.php` non serve per questa URL — vince il Folio dedicato Fixcity.

## Vietato

- `middleware(['auth'])` hardcoded nel Folio **se** la pagina è CMS-driven e il JSON definisce già i middleware (duplicazione).
- Eccezione documentata: il Folio deve comunque **registrare** `PageSlugMiddleware` per attivare il JSON.

## Test

- `Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareTest.php`
- `Modules/Fixcity/tests/Feature/Pages/TicketPagesTest.php`
