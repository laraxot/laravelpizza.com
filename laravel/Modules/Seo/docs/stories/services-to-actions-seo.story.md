---
title: "[STORY] Services -> Actions nel modulo Seo (MetatagService)"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
module: Seo
tags: [bmad, services, queueable-actions, no-services-rule, metatag, cleanup]
qmd: "seo MetatagService residuo MetatagFacadeAdapter MergeMetatagDataAction ReplaceMetatagDataAction MetatagManager Data Datas"
related:
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Services -> Actions nel modulo Seo

## Richiesta

Ordine permanente (2026-10-08): nessun `app/Services` ne' classe `*Service`; ogni use case e' una Queueable Action con
tutti i chiamanti aggiornati.

## Analisi (lo scopo, non il messaggio)

`Services/MetatagService` (arrivato col merge `40f732e` da `laraxot/dev`, 2026-10-07) accumulava i metatag di una
richiesta: tiene un `MetatagData` in una proprieta' e ogni `setX()` rifonde l'array con `array_merge`. 16 metodi
pubblici, ma in realta' due soli comportamenti: leggere lo stato (`get`), sostituirlo (`set`) o fonderci un
frammento (tutti i `setX`).

Questi comportamenti esistono gia' in forma corretta:

| Metodo del Service | Equivalente esistente |
|---|---|
| `get()` | `Actions/Metatag/GetMetatagDataAction` (stato request-scoped in `Adapters/MetatagState`, singleton nel provider) |
| `set(array)` | `Actions/Metatag/ReplaceMetatagDataAction` |
| `setTitle` ... `setModifiedTime` (14 setter) | `Actions/Metatag/MergeMetatagDataAction` con il frammento `['title' => ...]` |
| facade `Metatag::setX()` | `Adapters/MetatagFacadeAdapter` (docblock: "mantiene la stessa API" del vecchio Service) |

Non serve un'Action per setter: i setter sono sintassi del facade, non use case. Non serve nemmeno un metodo su
`MetatagData`: il merge e' una funzione di stato globale della richiesta, non un valore.

Chiamanti: nessuno nel codice (`rg MetatagService` su Modules, Themes, app, config, resources, anche Blade). L'unico
riferimento era `tests/Unit/Services/MetatagServiceExtendedTest.php`, che ripete riga per riga
`tests/Unit/Adapters/MetatagFacadeAdapterExtendedTest.php` (stessi 8 setter, stesse asserzioni).

Il Service usava inoltre `Modules\Seo\Data\MetatagData`, non il `Datas\MetatagData` (con `MetatagDataContract`) che usano le
Action: una seconda copia dello stato, mai condivisa con il facade.

## Modifiche

- Eliminati (recuperabili da `HEAD` di `Modules/Seo`): `app/Services/MetatagService.php`, `app/Services/MetatagService.php.bak`,
  `app/Services/.gitkeep`, `tests/Unit/Services/MetatagServiceExtendedTest.php`; la directory `app/Services/` non esiste piu'.
- `Adapters/MetatagFacadeAdapter.php`: solo il docblock, non rimanda piu' a una classe che non c'e'.
- Nessuna `const` nel perimetro. Nessun chiamante da aggiornare.

## Verifica

- `rg MetatagService` / `Modules\Seo\Services` su `laravel/Modules`, `Themes`, `app`, `config`, `routes`, `resources`,
  `tests` (esclusi docs/vendor): resta solo la menzione "ex MetatagService" nel docblock dell'adapter.
- Le asserzioni del test eliminato sono gia' in `MetatagFacadeAdapterExtendedTest` e `Feature/MetatagFacadeAdapterTest`.
- PHPStan (`phpstan.neon`, da `laravel/`) su `Modules/Seo/app/Adapters/MetatagFacadeAdapter.php`: `[OK] No errors` (esecuzione unica per i cinque moduli, dettaglio nella story Media).

## Aperto

Il modulo ha tre "stati" per gli stessi metatag, fuori perimetro di questa story:

1. `Adapters/MetatagState` + Actions (quello usato dal facade `Metatag`);
2. `Adapters/MetatagManager` (singleton nel `SeoServiceProvider`, usato solo da `tests/Feature/MetatagServiceTest.php`);
3. due classi `MetatagData` e `SocialShareData`: in `app/Data/` (usate da `MetatagManager`) e in `app/Datas/` (quelle con il Contract).

Candidato al consolidamento: eliminare `MetatagManager` e `app/Data/*`, spostare i test su `MetatagFacadeAdapter`.
Il file `tests/Unit/Services/MetatagServiceExtendedTest.php.old` (non tracciato) e' rimasto: non e' mio.
