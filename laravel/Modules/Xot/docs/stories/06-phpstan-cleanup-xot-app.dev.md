---
title: "[DEV] PHPStan cleanup Xot/app (gruppo Xot_app)"
type: dev
status: done
created: 2026-10-06
updated: 2026-10-06
module: Xot
tags: [phpstan, cleanup, xot, swarm, lessons-learned]
related:
  - ./2026-10-06-phpstan-cleanup-xot-app.story.md
  - ../bmad/phpstan-status.md
---

# [DEV] PHPStan cleanup Xot/app

Story: [2026-10-06-phpstan-cleanup-xot-app.story.md](./2026-10-06-phpstan-cleanup-xot-app.story.md)

## Technical Plan

1. Rimisurare: `phpstan analyse Modules/Xot/app` (il file errori del gruppo e' di un run completo, con contesti di test e result-cache vecchia).
2. Per ogni file: leggere lo scopo, `grep` dei chiamanti in `laravel/Modules` + `laravel/Themes`, `git log -p` per capire se la variabile orfana e' logica tolta per errore.
3. Correggere secondo lo scopo: ripristinare la logica mancante, altrimenti togliere il codice morto (solo metodi privati / variabili locali), mai toccare le firme pubbliche.
4. Costanti: tipo nativo ovunque; enum solo per insiemi di valori (qui nessuno).
5. Verifica con PHPStan + `php -l`; scrivere story/dev/status.

## Files to Modify

Costanti (tipo nativo ripristinato, uguali al `HEAD`): `Actions/Artisan/Handlers/{Cache,Error,Route}CommandHandler.php`, `Services/Artisan/Handlers/{Cache,Error,Route}CommandHandler.php`, `PHPStan/PestInternalClassAccessIgnoreExtension.php`, `Console/Commands/BuildTestSqliteCommand.php`, `Filament/Widgets/EnvWidget.php`, `Exports/XotBaseExporter.php`, `Filament/Support/RecordAnchor.php`, `Actions/ModelClass/FakeSeederAction.php`, `Support/PaDesignColors.php`.

Modificati (diff reale):
- `Actions/Artisan/Handlers/ModuleCommandHandler.php`, `Services/Artisan/Handlers/ModuleCommandHandler.php` (match al posto del dispatch dinamico)
- `Actions/PaDesignColorsAction.php`, `Actions/Design/GetPaFilamentPaletteAction.php` (alias costanti a `PaDesignColors`)
- `Actions/Debug/MeasureAction.php`, `Actions/ExecuteArtisanCommandAction.php`, `Actions/Export/ExportXlsStreamByLazyCollection.php`
- `Actions/Factory/GetPropertiesFromMethodsByModelAction.php` (popola `$data`)
- `Actions/Filament/GenerateFormByFileAction.php`, `Actions/Filament/GetModulesNavigationItems.php`
- `Actions/File/GetComponentsAction.php`, `Actions/Generate/GenerateModelByModelClass.php`, `Actions/GetTransKeyAction.php`
- `Actions/Model/FilterRelationsAction.php`, `Actions/Model/Store/{BelongsTo,MorphToMany}Action.php`, `Actions/Model/Update/{BelongsToMany,CustomRelation,MorphMany,MorphToMany,Pivot}Action.php`
- `Actions/Route/RegisterDynamicRoutesAction.php`, `Actions/Tree/GetTreeOptionsByModelClassAction.php`
- `Console/Commands/AnalyzeComponentsCommand.php` (filtro `--type`), `Console/Commands/OptimizeFilamentMemoryCommand.php`
- `Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php`, `Filament/Traits/HasXotTable.php` (solo whitespace)
- `Http/Middleware/PerformanceMonitoringMiddleware.php`, `Http/Middleware/SecurityMiddleware.php`
- `Models/Traits/RelationX.php` (`qualifyPivotTable`), `Services/RouteService.php` (`urlAct`), `States/XotBaseState.php`

## Implementation Steps

- [x] Rimisurazione: `Modules/Xot/app` a 21 errori reali (tutte le altre voci del file errori erano risolte dal codice o stale).
- [x] Costanti: tipo nativo su 21 costanti, alias palette PA su `PaDesignColors`.
- [x] `RelationX`: ripristino prefisso database del pivot per `morphToManyX`, helper condiviso.
- [x] `RouteService::urlAct`: ordine di lettura della route corrente.
- [x] `GetPropertiesFromMethodsByModelAction`: valorizzazione `$data`.
- [x] `AnalyzeComponentsCommand`: filtro `--type`.
- [x] Metodi privati: rimossi parametri senza scopo (Module handler x2, middleware x2, OptimizeFilamentMemory, 12 helper di RegisterDynamicRoutes).
- [x] Variabili morte / assegnazioni sovrascritte: 15 file.
- [x] `GetTreeOptionsByModelClassAction`: `Assert` runtime al posto di `@var`+ignore.
- [x] `php -l` sui 32 file con diff.
- [x] Story, dev, aggiornamento `bmad/phpstan-status.md` e indice wiki.

## Testing

Pest **non eseguito**: `laravel/.env.testing` punta a MySQL (`DB_CONNECTION=mysql`, `techplanner_data_test`, `APP_ENV=local`) e il brief vieta test non su sqlite/in-memory. `phpunit.xml` usa sqlite `:memory:` ma `.env.testing` potrebbe prevalere: non verificato.
Test che toccano il codice modificato, da rilanciare dall'utente su ambiente sqlite:
- `Modules/Xot/tests/Unit/XotRelationManageStatesCoverageTest.php` (`belongsToManyX`/`morphToManyX`; su sqlite il prefisso non si applica)
- `Modules/Xot/tests/Unit/XotExecuteCoverage50Test.php` (`GetPropertiesFromMethodsByModelAction`)
- `Modules/Xot/tests/Unit/XotExplicitZeroKillersTest.php` (`--type` esiste)
- `Modules/Xot/tests/Unit/XotHundredPercentCoverageTest.php:399` invoca `isSuspiciousRequest` via reflection con 2 argomenti: ora il metodo ne ha 1, l'argomento in piu' viene ignorato da PHP, il test continua a funzionare (da ripulire nel gruppo `Xot_rest`).

## Verification

```bash
cd /mnt/nas07/var/www/_bases/base_techplanner_fila5/laravel
./vendor/bin/phpstan analyse Modules/Xot/app --memory-limit=-1 --no-progress
./vendor/bin/phpstan analyse Modules/Xot --memory-limit=-1 --no-progress   # contesti test (HasXotTable)
php -l <file>                                                                # per ogni file modificato
```

Risultato: 147 (file errori) -> **21**, tutte `classConstant.nativeTypeNotSupported` ("Class constants with native types are supported only on PHP 8.3 and later"): PHPStan legge `laravel/composer.json` `"php": "^8.2"` e assume PHP 8.2, ma il runtime e' 8.4.26 e il `HEAD` ha gia' costanti tipizzate. Non risolvibile dentro `Xot/app`: serve `require.php: ^8.3` (o `phpVersion` nel neon, vietato). Con costanti non tipizzate si torna a `typeCoverage.constantTypeCoverage`: il conflitto e' nella dichiarazione di piattaforma, non nel codice.

## Lessons Learned

- **Il numero dell'errore non e' il bug.** Quattro "variabile mai letta" (`$pivotDbName`, `$routename`, `$data` by-ref, `--type`) erano funzionalita' tolte o mai finite: `git log -p` sulla riga orfana ha spiegato l'intento in due minuti.
- **Un passaggio PHPStan "a zero" puo' aver rimosso comportamento**: `morphToManyX` aveva perso il prefisso cross-database nel commit del 2026-09-03 proprio per eliminare un `variable.unused`. Quando si "zittisce" una variabile, controllare cosa leggeva prima.
- **Tipo nativo di costante vs versione PHP dichiarata**: PHPStan usa `composer.json` `require.php`, non il binario. Prima di tipizzare in massa, verificare `classConstant.nativeTypeNotSupported`; altrimenti si oscilla tra `typeCoverage` e `nativeTypeNotSupported` (e c'e' chi toglie i tipi per non vedere il secondo).
- **Result-cache condivisa tra agenti paralleli**: errori "in context of class@anonymous" su un trait non toccato erano stale (sparivano appena il file veniva modificato). Prima di rincorrerli: rieseguire su un sottoinsieme e confrontare; non toccare i test altrui.
- **Parametro inutilizzato**: se il metodo e' privato e il chiamante e' lo stesso file, si toglie il parametro (e a cascata quelli di solo passaggio); se e' pubblico/contratto si mantiene e si documenta (`RegisterDynamicRoutesAction::execute($namespace)`).

## Sospetti, orfani, non toccati

- `Actions/Artisan/Handlers/*` e `Services/Artisan/Handlers/*`: due alberi quasi identici (uno chiama `RunArtisanCommandAction`, l'altro `ArtisanService`). Duplicazione da unificare con decisione.
- `Support/PaDesignColors`, `Actions/PaDesignColorsAction`, `Actions/Design/GetPaFilamentPaletteAction`: tre classi per la stessa palette; solo `PaDesignColorsAction` ha consumatori (`XotServiceProvider`, `MetatagData`).
- `Http/Middleware/PerformanceMonitoringMiddleware.php`: non registrato da nessuna parte, nessun lettore delle chiavi cache (`avg_response_time`, ...); esiste anche `PerformanceMonitoringMiddleware.php.wip`. `Services/RouteService.php.bak` idem.
- `Actions/Model/Update/{CustomRelation,MorphMany,Pivot}Action` e `Store/MorphToManyAction`: contengono ancora `dddx(...)` (WIP). `FilterRelationsAction` assert che ogni valore di `$data` sia una `Relation`: il flusso Store/Update e' incompleto.
- `Actions/Filament/GenerateFormByFileAction`: comando `xot:generate-form` non genera nulla (WIP dalla prima commit).
- `RouteService::urlAct`: nessun chiamante nel repo.
