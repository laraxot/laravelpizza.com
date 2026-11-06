---
title: "[STORY] Xot: PHPStan a zero errori (110 errori, 18 file)"
type: story
status: review
priority: high
created: 2026-10-28
updated: 2026-10-28
module: Xot
tags: [phpstan, merge, swarm, tests, bmad]
related:
  - ./phpstan-l10-systematic-resolution.story.md
  - ../bmad/stories/module-service-test-decision.story.md
  - ../wiki/memories/merge-residui-codice-rimosso-riesumato.md
---

# Story: Xot a zero errori PHPStan

## User Request
Swarm PHPStan sui Modules (baseline 1600 errori / 181 file). Ambito Xot: 110 errori in 18 file. Regola: risolvere la causa, capire lo scopo del codice prima dell'errore, niente `@phpstan-ignore`, niente baseline, niente cancellazioni.

## Analysis
Quasi tutti gli errori hanno una sola origine: il merge `ae2239de0` / `3bfdfff16` (28/10/2026) di due rami che avevano gia' risolto gli stessi errori in modo diverso. Dove un ramo aveva **tolto un parametro/variabile** e l'altro l'aveva **zittito** (`Assert::string($method)`), sopravvive il silenziatore senza il parametro: `Undefined variable`. Dove un ramo aveva **cancellato una classe** (rimossa di proposito) e l'altro la usava ancora, sopravvivono i test della classe cancellata.

| Causa radice | Errori | Scopo del codice | Soluzione |
|---|---|---|---|
| Silenziatori di parametro orfani (`Assert::nullOrString($_namespace)`, `Assert::string($method/$path)`, `Assert::isInstanceOf($response, ...)`) | 11 (`RegisterDynamicRoutesAction` 6, `PerformanceMonitoringMiddleware` 2, `SecurityMiddleware` 1, `AnalyzeComponentsCommand` `$_type`/`$type` 1, ...) | I parametri erano stati eliminati perche' inutili (`1f1265e12`) | Tolte le righe orfane; in `AnalyzeComponentsCommand` l'opzione `--type` e' davvero usata come filtro: variabile `$type`, non `$_type` |
| `$rows = $relationDTO->rows` perso dentro l'`Assert` | 6 (`BelongsToAction`, `MorphToManyAction`) | `Assert::isInstanceOf($rows = $relationDTO->rows, X::class)` restringe il tipo; stesso pattern delle altre Action `Model/Store` | Ripristinato il pattern |
| `GetPropertiesFromMethodsByModelAction`: `$data[...] =` scritto su una copia locale | 1 | Raccogliere `FK => factory(Related::class)` dai metodi `belongsTo` (il parametro by-reference era stato tolto: i dati non uscivano mai) | `extractBelongsToRelations()` ritorna l'array, `execute()` lo unisce |
| Classe rimossa di proposito: `Services\ModuleService` | 27 (+18 nel brief) | `setName($m)->getModels()`: modelli concreti di un modulo, chiave snake_case. Nessun chiamante di produzione | Sostituita da `Actions\Model\GetAllModelsByModuleNameAction`; `tests/Unit/ModuleServiceTest.php` riscritto sul suo contratto (decisione gia' presa in `module-service-test-decision.story.md`, annullata dal merge) |
| Classe rimossa di proposito: `FileAction` (monolite statico, `139ff7294`) | 24 (`XotExecuteCoverage50Test`) | Test "coverage floor" di helper che non esistono piu'; le Action che li hanno assorbiti hanno test dedicati (`tests/Unit/Actions/File/*`) | Tolto il blocco obsoleto (come gia' fatto in `a0b502f08`) |
| `Support\ColumnBuilder` spostata in `Builders\ColumnBuilder` + `use ReflectionClass/Method` mancanti | 24 (`XotFilamentSupportHundredCoverageTest`) | Test per riflessione dei builder Filament | Tolto il riferimento alla classe sparita (c'e' gia' `Builders\ColumnBuilder` nella lista), aggiunti gli `use` |
| Test con variabile/`use` persi dal merge | 8 | `XotBaseModelBusinessLogicTest` (`use` del fixture `TestConcreteBaseModel`, `$baseModel =`), `CreateTableIndexByModelClassColumnsActionTest` (ultimo test: colonna mancante), `SaveArrayActionTest` (`$filename` mai letto) | Ripristinati secondo la versione sana del ramo che li aveva sistemati |
| Handler `ModuleCommandHandler` x2 (interfaccia e `ArtisanService` inesistenti) | 8 | Strategy dei comandi `module-*` di `act()`; sostituita da `HandleArtisanActRequestAction` + `ArtisanActEnum` (`services-to-actions-xot-artisan.story.md`) | Vedi "Decisioni aperte": la fix giusta e' cancellarli; non potendo, resi compilabili e marcati `@deprecated` |
| `typeCoverage.paramTypeCoverage` (3 parametri senza tipo nativo) | 3 | `HasRecursiveRelationshipsContract::newEloquentBuilder($query)`, `HasXotFactory::factory($count, $state)` | `Builder $query` (il tipo di `Model::newEloquentBuilder`); `callable|array|int|null $count`, `callable|array $state` (cio' che il corpo gia' gestiva). Verificato caricando i 203 model dei moduli: nessun conflitto di firma con `HasFactory` |
| `trait.unused` `HasYearsConfig` | 1 | Anni proposti dalle `{Modulo}ConfigData` di Ptv/Progressioni/...: non presenti in questa installazione | Nuovo `tests/Unit/Datas/Concerns/HasYearsConfigTest.php` con implementazione minima: il trait e' analizzato e la normalizzazione (stringhe, duplicati, ordine) e' testata |

## Result
- Baseline Xot: **110** errori / 18 file. Dopo: **0 dei 110**. `phpstan analyse Modules/Xot Modules/Media/app/Datas/MediaConfigData.php` = **1 errore**, nuovo e non in baseline: `TypedHasRecursiveRelationships` `trait.unused` (vedi Decisioni aperte).
- `trait.unused` di `MakesFromTenantConfig` compare solo se non si analizza `Media` (lo usa `MediaConfigData`): non e' un errore sul run completo.
- `typeCoverage.paramTypeCoverage` e' globale e si calcola solo sul run con i path interi di `phpstan.neon` (`./Modules/`): con `Modules/Xot` da solo viene saltato. I 3 parametri sono tipati (scansione AST: nessuno dei tre e' piu' senza tipo); la verifica numerica richiede il run completo.
- Pest **non eseguito** (`.env.testing` = MySQL condiviso). Logica di `HasYearsConfigTest` verificata con uno script PHP standalone (3 casi veri).

## Acceptance Criteria
- [x] Nessun `@phpstan-ignore`, baseline o `ignoreErrors`; `phpstan.neon` non toccato
- [x] Nessun file cancellato; 4 `.md` con data nel nome rinominati con `git mv` e link aggiornati
- [x] Cause radice risolte alla fonte (parametri, classi rimosse, import)
- [ ] `TypedHasRecursiveRelationships`: decisione di chi risolve il merge (vedi sotto)
- [ ] Pest in ambiente sqlite
- [ ] Issue/Discussion GitHub (`gh` non installato)

## Decisioni aperte
1. `app/Models/Traits/TypedHasRecursiveRelationships.php` e' stato **riaggiunto dalla risoluzione del merge in corso** (era stato rimosso di proposito: `bmad/stories/remove-typedhasrecursiverelationships.story.md`; il ramo "loro" lo usava ancora in `BaseTreeModel` e `XotBaseTreeModel`, la risoluzione ha tenuto la versione senza). Cosi' com'e' e' un trait mai usato. Scelta da fare insieme alla risoluzione: o si rimuove il file (coerente con la storia), o i due tree model tornano a usarlo.
2. `app/Actions/Artisan/Handlers/ModuleCommandHandler.php` e `app/Services/Artisan/Handlers/ModuleCommandHandler.php` sono codice morto riesumato dal merge. Soluzione corretta: `git rm`. Vietato dal brief: tenuti, il primo senza interfaccia, il secondo come sottoclasse del primo.
3. `AnalyzeComponentsCommand` usa `base_path("laravel/Modules/...")`: con `base_path()` gia' = `laravel/` il percorso diventa `laravel/laravel/Modules`. Non e' nell'elenco errori, non toccato.

## GitHub
### Issues
- TODO (`gh` non installato)
### Discussions
- TODO
