---
title: "PHPStan: costanti di classe tipizzate (Cms, Geo, User, Restaurant)"
type: story
module: Xot
status: done
tags: [phpstan, typeCoverage, constantTypeCoverage, php83, cross-module]
qmd: "phpstan typed constants constantTypeCoverage Cms Geo User Restaurant"
related:
  - "../../../Job/docs/stories/4.31.constant-type-coverage-schedule.story.md"
created: 2026-10-14
updated: 2026-10-14
---

# PHPStan: costanti di classe tipizzate

Fase BMAD: Quick Flow, implementazione + verifica. Story cross-modulo ospitata in Xot.

## Scopo

Chiudere 7 delle 10 segnalazioni `typeCoverage.constantTypeCoverage` ("Out of 149 possible
constant types, only 139 - 93.2 % actually have it"). Le altre 3 (`Restaurant/app/Filament/Pages/Cucina.php`
righe 20, 22, 24) sono di un altro agente e non sono toccate qui.

## Causa radice

La soglia (99%) e' calcolata sull'intero albero `Modules/`, non per file. Le 7 costanti erano
dichiarate senza tipo (`const X = ...`). Un `@var` nel docblock non conta: serve il type
declaration reale PHP 8.3 sulla `const` (stesso pattern di JOB-4.31).

## Fix per costante

| File (da `laravel/`) | Costante | A cosa serve | Tipo |
|---|---|---|---|
| `Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php:18` | `GROUPS_ALREADY_APPLIED` (private) | gruppi middleware gia' applicati da Folio, da saltare (`in_array` a riga 156) | `array` |
| `Modules/Geo/app/View/Components/PointMap.php:24` | `DEFAULT_HEIGHT` (public) | altezza di default della mappa, usata come default del costruttore e come fallback | `string` |
| `Modules/Geo/app/View/Components/PointMap.php:26` | `DEFAULT_ZOOM` (public) | zoom di default, default del costruttore e fallback | `int` |
| `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php:30` | `MAX_ATTEMPTS` (private) | tentativi errati prima del blocco (`RateLimiter::tooManyAttempts`) | `int` |
| `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php:33` | `DECAY_SECONDS` (private) | durata blocco e finestra di conteggio (`RateLimiter::hit`) | `int` |
| `Modules/Restaurant/database/migrations/2026_09_13_000007_add_location_to_existing_tables.php:50` | `REQUIRED_COLUMNS` (private) | colonne da verificare su `restaurant_locations` dopo la creazione | `array` |
| `Modules/Restaurant/database/migrations/2026_09_13_000007_add_location_to_existing_tables.php:64` | `TABLES_TO_SCOPE` (private) | modelli operativi a cui aggiungere il campo sede (`foreach` a riga 208) | `array` |

I docblock `@var list<string>` e `@var list<class-string<Model>>` restano: il tipo `array`
nativo e' il massimo che PHP 8.3 esprime per le costanti, il dettaglio dei valori resta nel PHPDoc.

## Compatibilita

- Nessuna costante sovrascrive o ridefinisce una costante di classe padre, trait o interfaccia.
  Le 5 private non sono ereditate; `PointMap` estende `Illuminate\View\Component` (nessuna
  `DEFAULT_*`) e non ha sottoclassi; `LoginWidget` ha solo una sottoclasse anonima nel test
  `Modules/User/tests/Unit/Filament/Widgets/AuthLoginFeedbackTest.php`, che non vede le private.
- Nessuna costante morta: ogni costante ha almeno un uso (grep su `Modules/`).
- Migration: cambiata solo la dichiarazione delle due costanti. Nessuna modifica a logica schema,
  nessun comando DB, resta `XotBaseMigration`.

## Verifica

- `php -l` sui 4 file: nessun errore di sintassi.
- `./vendor/bin/phpstan analyse <4 file> --memory-limit=-1`: `[OK] No errors`.
- La chiusura dell'errore globale `constantTypeCoverage` si conferma solo con
  `phpstan analyse Modules` sull'intero albero (a carico del coordinatore).
