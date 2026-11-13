---
title: "Area personale /servizi: pagina CMS mancante (404)"
type: story
bmad: true
status: done
created: 2026-11-19
owner: module:User
module: User
related: [DCP-110, front-office-audit]
tags: [cms, folio, area-personale, 404, design-comuni]
---

# Area personale /servizi: pagina CMS mancante (404)

## Contesto

Audit front office (guest + authenticated): `GET /it/area-personale/servizi` risponde **404**.
Le altre quattro pagine dell'area personale (`pratiche`, `seguite`, `notifiche`, `impostazioni`)
sono pagine CMS JSON in `config/local/fixcity/database/content/pages/area-personale/` con
`layout: design-comuni` e `middleware: ["auth"]`.

Esiste anche un blade Volt `Modules/User/resources/views/pages/area-personale/servizi.blade.php`
(route Folio `area-personale.servizi`), ma e' irraggiungibile: la catch-all del tema
`[container0]/[slug0]` risolve prima via `ResolvePageAction` e, non trovando la pagina CMS
`area-personale.servizi`, abortisce 404. Lo stesso vale per i blade Volt delle altre pagine:
il JSON CMS e' la SSoT, il blade e' codice legacy.

In header non e' linkata (la nav area personale ha 4 tab: pratiche, seguite, notifiche,
impostazioni), ma la route esiste ed e' raggiungibile per URL diretta: deve funzionare o
dare un comportamento coerente.

## Decisione

Creare `config/local/fixcity/database/content/pages/area-personale/servizi.json` con la
stessa struttura delle sorelle: `layout: design-comuni`, `middleware: ["auth"]`,
blocchi tradotti it/en/de/es. Contenuto: pagina segnaposto "I miei servizi" in stile
Design Comuni (breadcrumb, hero, testo descrittivo), coerente col blade Volt esistente
("Elenco dei servizi disponibili per l'utente").

## File toccati

- `laravel/config/local/fixcity/database/content/pages/area-personale/servizi.json` (nuovo)

## Verifica

- `GET /it/area-personale/servizi` guest → 302 a `/it/auth/login` (anche `/en`)
- `GET /it/area-personale/servizi` auth → 200, H1 "I miei servizi", title "I miei servizi | FixCity"
- `php artisan view:cache` → exit 0
- `vendor/bin/pest Modules/Fixcity/tests/Feature/Pages/PersonalAreaPagesTest.php` → 34 pass, 233 assertions

## Esito

Fatto. La pagina usa `content-page` + `cards-simple` (vista `design-comuni`): breadcrumb
Home › Area personale, hero e una card verso `/services`. Non e' linkata dai 4 tab
(`cmp-nav-tab` resta sulle 4 pagine canoniche) ma l'URL diretto non da' piu' 404.

## Dev Agent Record

- 2026-11-19: creato `config/local/fixcity/database/content/pages/area-personale/servizi.json`
  (unico file di contenuto; i blade Volt in `Modules/User/resources/views/pages/area-personale/`
  restano legacy irraggiungibili perche' la catch-all CMS del tema risolve prima).
