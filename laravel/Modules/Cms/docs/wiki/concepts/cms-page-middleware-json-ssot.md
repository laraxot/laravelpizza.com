---
title: "CMS page middleware — JSON SSoT + PageSlugMiddleware"
type: concept
tags: [cms, middleware, folio, auth, pages-json]
created: 2026-06-12
updated: 2026-10-26
qmd: "cms page middleware json auth PageSlugMiddleware tickets.create folio route name container0 slug0"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/362"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/363"
related:
  - ../../../../../../docs/stories/STORY-357-tickets-create-auth-middleware.md
  - ../../template-theme-cms-runtime-architecture.md
status: draft
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
- Folio che risponde (verificato 2026-10-13 con `data-slug` e `wire:name` della risposta): `Themes/Sixteen/resources/views/pages/[container0]/[slug0]/index.blade.php`. La Folio del modulo `Modules/Fixcity/resources/views/pages/tickets/create.blade.php` (`name('tickets.create')`, `middleware('auth')`) è registrata ma non è quella che risponde.
- JSON: `tickets.create.json` NON ha la chiave `middleware` (verificato 2026-10-13 nelle tre copie: `config/local/fixcity`, `config/eu/fixcity`, `Modules/Fixcity/config`); un ospite riceve `200` su `/it/tickets/create`. Il contratto sopra vale per le pagine il cui JSON dichiara `middleware`.

**Nota (corretta 2026-10-13):** per `/it/tickets/create` risponde proprio la shell generica `Themes/Sixteen/.../[container0]/[slug0]/index.blade.php`, non il Folio dedicato Fixcity. Dettagli: `Modules/Fixcity/docs/wiki/concepts/ticket-crea-url-routing-chain.md`.

## Vietato

- `middleware(['auth'])` hardcoded nel Folio **se** la pagina è CMS-driven e il JSON definisce già i middleware (duplicazione).
- Eccezione documentata: il Folio deve comunque **registrare** `PageSlugMiddleware` per attivare il JSON.

## Test

- `Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareTest.php`
- `Modules/Fixcity/tests/Feature/Pages/TicketPagesTest.php`


## Da URL a JSON: come verificare (2026-10-13)

Lo slug CMS e' quello che il server usa davvero, non quello che un doc suggerisce.

| URL | Folio | Slug |
|-----|-------|------|
| `/it/tickets/create` | `Themes/Sixteen/.../pages/[container0]/[slug0]/index.blade.php` | `tickets.create` (`<container0>.<slug0>`) |
| `/it/tests/<x>` | `Themes/Sixteen/.../pages/tests/[slug].blade.php` | `tests.<x>`; `/it/tests` = `tests.index` |

Il prefisso `tests.` si compone SOLO nel secondo canale. `components.blocks.tests.*` e' una cartella di view dei blocchi, non uno slug.

Comando: `bash bashscripts/tools/cms/page-json-for-url.sh <url>` stampa lo slug (`data-slug` della risposta) e i JSON trovati; exit 2 = nessun JSON, non crearlo senza chiedere. Lo stesso JSON puo' esistere in piu' tenant (`config/local/fixcity`, `config/eu/fixcity`, `Modules/*/config`): confrontarli prima di dire che sono uguali.


## Cosa si puo' scrivere nell'array `middleware` (2026-10-13, DCP-50)
- Solo i nomi in allowlist: `cms.config.page_middleware_allowlist`, default `auth` e `throttle` (i soli usati dai JSON, DCP-283). Si confronta il nome prima dei due punti (`throttle:10,1` e' ammesso). Una classe scritta nel JSON NON viene piu' eseguita: per ammetterne una si aggiunge il nome alla configurazione, con un test. `PageSlugMiddleware` risolve poi la voce con l'alias del kernel e con `app()`.
- `web` e' un gruppo gia' applicato dallo stack Folio: viene ignorato (no-op), ma non va scritto. Prima faceva 500 per tutti (`Target class [web] does not exist`, 2026-10-13).
- Un nome non risolvibile (refuso come `auht`, o un gruppo come `api`) lancia `InvalidArgumentException` con un messaggio chiaro. NON viene mai ignorato in silenzio: ignorarlo renderebbe pubblica una pagina protetta.
- Fail-closed (DCP-283, C-03): se la ricerca della pagina, la lettura del campo `middleware` o la sua validazione falliscono (slug duplicato, JSON illeggibile, `"middleware": "auth"` al posto di `["auth"]`, voce non stringa, nome fuori allowlist), la pagina risponde 503 e non viene servita; il log registra slug, nomi e tipo di errore, mai IP, utente o percorso. Un middleware che non restituisce una `Response` o non ha `handle` lancia `LogicException` invece di lasciar passare la richiesta. `null` o assente restano "pagina pubblica" (come `home`). Guardia: `Modules/Cms/tests/Unit/Content/PageJsonMiddlewareAllowlistTest.php` percorre tutti i JSON di pagina e verifica che ogni middleware dichiarato sia in allowlist.
Test: `Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareTest.php`, `PageSlugMiddlewareFailClosedTest.php` (DCP-283). Guardia dei template: `Themes/Sixteen/tests/Unit/BladeTemplatesCompileTest.php`.
