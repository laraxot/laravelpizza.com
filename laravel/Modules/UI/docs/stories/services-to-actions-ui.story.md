---
title: "[STORY] Services -> Actions nel modulo UI (residui riapparsi)"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
module: UI
tags: [bmad, services, queueable-actions, no-services-rule, null-object, cleanup]
qmd: "ui services residui riapparsi ComponentService ThemeService UIService NullMapService NullGeocodingService Adapters Map"
related:
  - ./ui-services-to-actions.story.md
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Services -> Actions nel modulo UI

## Richiesta

Ordine permanente (2026-10-08): nessun `app/Services` ne' classe `*Service` nei moduli; ogni use case diventa una
Spatie Queueable Action con tutti i chiamanti aggiornati (epic `bmad-output/epic-code-standards-services-mixed-const.md`,
cluster "Moduli piccoli").

## Analisi (lo scopo, non il messaggio)

La story di settembre [`ui-services-to-actions`](./ui-services-to-actions.story.md) aveva gia' chiuso la questione:
i cinque file erano gia' stati archiviati e `UIService` era stato cancellato. Nel commit `3bae460` (2026-10-07) sono
ricomparsi tutti e cinque. Verificato prima di toccare qualunque cosa:

| Classe | Scopo reale | Chiamanti (`rg` su Modules, Themes, app, config, resources, test, anche Blade) |
|---|---|---|
| `Services/ComponentService` | classe vuota (solo docblock) | nessuno |
| `Services/ThemeService` | classe vuota (solo docblock). Non e' lo `ThemeService` di Xot ne' quello del tema Sixteen: stesso nome breve, altro namespace | nessuno |
| `Services/UIService::asset()` | passthrough 1:1 verso `Modules\Xot\Actions\File\AssetAction` | nessuno |
| `Services/Map/NullMapService` | null object di `Contracts\MapServiceContract` | nessuno; copia (stesso codice, cambiano solo namespace e nome classe) di `Adapters/Map/NullMapServiceAdapter` |
| `Services/Map/NullGeocodingService` | null object di `Contracts\GeocodingServiceContract` | nessuno; copia di `Adapters/Map/NullGeocodingServiceAdapter` |

Le due classi `Null*` erano il caso da valutare: sono "fallback quando Geo non e' installato". Nessun provider le lega
al container (`rg` di `MapServiceContract` / `GeocodingServiceContract` in tutto `Modules`, `Themes`, `app`, `config`
trova solo contratti e null object). L'implementazione canonica e' quella in `app/Adapters/Map/` (naming di progetto per
le implementazioni di Contract, non `*Service`); la copia in `Services/Map` era un residuo.

## Modifiche

| Prima | Dopo |
|---|---|
| `app/Services/ComponentService.php`, `ThemeService.php` | eliminati (classi vuote) |
| `app/Services/UIService.php` | eliminato; chi serve chiama `app(\Modules\Xot\Actions\File\AssetAction::class)->execute($path)`. Non si crea una Action che incarta un'altra Action |
| `app/Services/Map/NullMapService.php`, `NullGeocodingService.php` | eliminati; restano `Adapters/Map/Null*ServiceAdapter` come implementazioni di fallback dei Contract |
| `app/Services/` | directory rimossa |

Nessuna `const` nel perimetro. Nessun chiamante da aggiornare.

File cancellati, recuperabili da `HEAD` del repo `Modules/UI`: `git show HEAD:app/Services/<file>`.

## Verifica

- `rg -e 'UI\\Services' -e UIService -e ComponentService -e NullMapService -e NullGeocodingService` su
  `laravel/Modules`, `Themes`, `app`, `config`, `routes`, `resources`, `tests` (esclusi docs/vendor): zero risultati
  oltre ai `UIServiceProvider` (provider Laravel, non pattern Service) e ai `Null*ServiceAdapter`.
- Nessun test del modulo referenziava le classi eliminate.
- PHPStan (`phpstan.neon`, da `laravel/`) su `Modules/UI/app/Adapters`: `[OK] No errors` (esecuzione unica per i cinque moduli, dettaglio nella story Media).

## Decisioni

- I null object non diventano Action: non hanno logica applicativa, implementano un Contract e vivono in `Adapters/`.
- Il binding dei Contract `UI\Contracts\MapServiceContract` / `GeocodingServiceContract` non esiste. Non l'ho creato
  (nessun consumatore): se Geo li dovesse usare, il fallback va registrato nel provider UI con `bindIf`.

## Aperto

- I due Contract `UI\Contracts\*ServiceContract` e le implementazioni null non hanno consumatori (Geo ha i propri
  `Geo\Contracts\GeocodingServiceContract`). Valutare se eliminarli insieme (cluster Geo, onda 4).
