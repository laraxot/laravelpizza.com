---
title: "[STORY] routes/web.php e routes/api.php esistono in tutti i moduli, niente require di empty.php"
type: story
status: done
priority: medium
created: 2026-11-24
updated: 2026-11-24
module: Xot
tags: [routes, provider, adr, xot-base]
qmd: "route files exist all modules story"
---

# [STORY] routes/web.php e routes/api.php esistono in tutti i moduli, niente require di empty.php

Sostituisce la decisione dell'ADR [route-entrypoints-canonical-empty](../adr/route-entrypoints-canonical-empty.md) (issue #92), ora `superseded`.

## User Request

«fare require base_path('Modules/Xot/routes/empty.php'); mi sembra brutto e sbagliato e controproducente»

poi, dopo che avevo cancellato i file:

«i files laravel/Modules/*/routes/api.php e laravel/Modules/Lang/routes/web.php sono file che devono esistere in tutti i moduli anche se cn solo <?php»

## Analysis

`XotBaseRouteServiceProvider::mapWebRoutes()` e `mapApiRoutes()` fanno `->group($module_dir.'/../../routes/web.php')` (e `api.php`) senza controllare che il file esista. Provato con una sonda su un modulo senza file: `ErrorException: require(...routes/api.php): Failed to open stream`, cioe' il boot di tutta l'applicazione. Quindi un file per modulo ci deve essere.

L'ADR #92 aveva risolto il boilerplate con `require base_path('Modules/Xot/routes/empty.php');` in sette file (Cms api, Lang web e api, Media web e api, UI web e api). Il costo: un file che dipende dal percorso di un altro modulo per ottenere un no-op che un file minimo ottiene da solo, e un test (`CanonicalEmptyRouteEntrypointsTest`) che nella checkout era gia' rosso: elencava cinque file inesistenti (Blog, Comment, Fixcity, Rating, Seo) e due segnaposto (AI, Job) senza il `require`.

**Errore mio, corretto.** Per primo ho tolto il problema alla radice aggiungendo `is_file` nel provider e cancellando i sette file. Contro la regola dell'utente: i file devono esistere, e il controllo avrebbe nascosto un file sparito per errore. Ripristinati i sette file e il provider.

## Implementation

- Sette file ricreati come segnaposto minimi (`<?php` + `declare(strict_types=1);`, 32 byte, byte per byte come `AI/routes/web.php`).
- `Modules/Xot/routes/empty.php` rimosso; ADR segnato `superseded`.
- `XotBaseRouteServiceProvider`: invariato nel comportamento, solo il docblock dichiara la regola.
- Test `CanonicalEmptyRouteEntrypointsTest` sostituito da `Modules/Xot/tests/Unit/Routing/ModuleRouteEntrypointsExistTest.php`: ogni modulo con `RouteServiceProvider` che estende `XotBaseRouteServiceProvider` (riconosciuto con `is_subclass_of`, non con una ricerca di testo) ha `routes/web.php` e `routes/api.php`, e esistono anche i file che il provider carica davvero (`$module_dir` di default, da riflessione): un provider che non lo ridefinisce eredita la cartella di Xot. Una classe provider non trovata e' un errore, non un salto silenzioso.

## Verification

- `php artisan route:list --json`: 505 route prima e dopo, stessi metodo/URI/nome/azione.
- Logica del test eseguita in autonomia, con il solo `vendor/autoload.php` (Pest non lanciato: `.env.testing` ha credenziali reali, serve il via libera dell'owner): albero vero `checked=17 missing=[]`; albero finto con due `api.php` mancanti li elenca entrambi (controllo positivo).
- Revisione ECC indipendente (`ecc:code-reviewer`, sola lettura): nessun rilievo CRITICAL o HIGH. Corretti: il test non vedeva che AI e Chart caricano le route di Xot (vedi Open), la ricerca di testo fragile, l'ADR con `superseded_by` e il comando di verifica obsoleto, l'indice ADR e `contracts/README.md` che presentavano ancora la decisione come attiva.
- `php -l` pulito su provider, test e i sette file.

## Open

- **AI e Chart caricano le route di Xot, non le proprie.** `XotBaseRouteServiceProvider` legge `$module_dir` (snake_case, default `Modules/Xot/app/Providers`). Il provider AI non lo ridefinisce; quello di Chart dichiara `$moduleDir` e `$moduleNs` in camelCase, proprieta' morte che la base non legge. Quindi `AI/routes/*.php` e `Chart/routes/*.php` oggi non vengono caricati. Non e' un'ipotesi: lo dimostra `ReflectionClass::getDefaultProperties()`. **Non corretto di proposito**: `AI/routes/api.php` contiene route vere (`auth:sanctum`, `/ai/classify`, `/ai/sentiment`, `/ai/priority`) che puntano a `Modules\AI\App\Http\Controllers\Api\AIController`, classe che non esiste (manca la cartella `AI/app/Http/Controllers/Api/`): correggere `$module_dir` le pubblicherebbe rotte. Decide l'owner di AI: o si scrive il controller e si ridefinisce `$module_dir`, o si svuotano i file. Per Chart basta rinominare le due proprieta' in `$module_dir` e `$module_ns`.
- **Consegna nei repo dei moduli.** Nel repo root i sette file risultano modificati, ma nei repo di Lang e Media `routes/` non e' mai stata tracciata (`git log -- routes` vuoto) e in Cms `routes/api.php` e' non tracciato. Niente di questo lavoro e' committato (file route, test, story, cancellazione di `empty.php`). Un commit o una sync dalla sola radice lascia i repo `laraxot` di Lang, Media e Cms senza i file: chi li consuma da solo ottiene il fatale al boot. Il commit e' dell'owner.
- `Xot` ha un proprio `RouteServiceProvider` (non il base) con `base_path('Modules/Xot/routes/web.php')`: fuori dalla regola, non toccato.
- Fra i quindici file elencati dal vecchio test, Blog, Comment, Fixcity, Rating e Seo non esistono in questa checkout: se quei moduli tornano, la regola vale anche per loro e il nuovo test li copre da solo.
