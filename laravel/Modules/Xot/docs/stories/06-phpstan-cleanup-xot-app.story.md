---
title: "[STORY] PHPStan cleanup Xot/app (gruppo Xot_app)"
type: story
status: done
priority: high
created: 2026-10-06
updated: 2026-10-06
module: Xot
tags: [phpstan, cleanup, xot, swarm, constants, enum]
---

# [STORY] PHPStan cleanup Xot/app (gruppo Xot_app)

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Scope di questo gruppo: solo `laravel/Modules/Xot/app/**` (147 segnalazioni in 54 voci, molte duplicate dallo stesso file).

## Analysis

Le 147 segnalazioni erano in realta' 5 famiglie. Per ognuna si e' guardato cosa il codice deve fare, non il messaggio.

### 1. Costanti di classe senza tipo nativo (`typeCoverage.constantTypeCoverage`, 21 costanti)
Nel working tree le costanti `private const array X` / `public const string X` erano state riportate a `private const X` (+ `@var`) da un passaggio precedente non committato; il `HEAD` le ha tipizzate. Ripristinate con tipo nativo.
Sono tutte **configurazione** (mappe comando->metodo dei handler Artisan, hex palette PA, prefisso ancora, escape CSV, chunk/limiti seeder, gruppi dell'EnvWidget, connessioni sqlite di test, identificatori che l'estensione PHPStan sopprime), non insiemi di stati/tipi/ruoli: restano costanti tipizzate, **nessun enum creato** (nessun enum esistente da riusare).
Duplicazione palette PA: `Support/PaDesignColors` era replicata identica in `Actions/PaDesignColorsAction` e `Actions/Design/GetPaFilamentPaletteAction`. Ora la sorgente unica e' `PaDesignColors`; le due Action espongono le stesse costanti come alias tipizzato (API invariata) e `GetPaFilamentPaletteAction::execute()` delega a `PaDesignColors::filamentPalette()`.

### 2. Logica che mancava (variabile calcolata e mai usata = bug)
- `RelationX::morphToManyX()`: calcolava `$pivotDbName`/`$dbName` e poi non faceva nulla. La storia git (`19ec93f07`, passaggio PHPStan del 2026-09-03) mostra che il prefisso `database.tabella` per pivot cross-database era stato **tolto per zittire PHPStan**, lasciando le variabili orfane. `belongsToManyX()` ha ancora la stessa logica. Ripristinata, estratta in `qualifyPivotTable()` e usata da entrambi (niente duplicazione; SQLite escluso come prima).
- `RouteService::urlAct()`: il nome della route corrente veniva letto *dopo* aver calcolato il nome della route-azione, che quindi partiva sempre da `''`. Riordinato: prima la route corrente, poi `Str::before($routename, $old_act)`.
- `GetPropertiesFromMethodsByModelAction::extractBelongsToRelations()`: riceveva `array &$data` "dove salvare i dati" ma non scriveva mai nulla (e creava `$fakerAction`/`$type` inutili). Ora valorizza `$data[$foreignKey] = 'factory(Related::class)'`, come da docblock e dal generatore originale.
- `AnalyzeComponentsCommand`: l'opzione `--type` e' dichiarata, testata come "filtro supportato" (`XotExplicitZeroKillersTest`) ma non era mai applicata. Ora filtra i componenti il cui namespace contiene il valore (case-insensitive). Semantica scelta da me, vedi decisioni.
- `Store/BelongsToAction`, `Store/MorphToManyAction`: l'`Assert::isInstanceOf($rows = ...)` serviva a restringere il tipo, ma poi si usava `$relationDTO->rows`; ora si usa `$rows`.

### 3. Codice morto / parametri senza scopo (rimossi, chiamanti verificati)
- Metodi **privati** con parametro mai usato: `ModuleCommandHandler::listModules($moduleName)` (dispatch ora con `match`, entrambe le copie Actions/ e Services/), `PerformanceMonitoringMiddleware::recordRequest($method,$path)`, `SecurityMiddleware::isSuspiciousRequest($response)`, `OptimizeFilamentMemoryCommand::applyOptimizations($issues,$verbose)`, e il `$namespace` vestigiale di 12 helper privati di `RegisterDynamicRoutesAction` (nel `RouteDynService` originale non era mai usato; `execute()` pubblico mantiene la firma e lo documenta).
- Variabili/assegnazioni senza lettura: `$status='running'` (`ExecuteArtisanCommandAction`), `$comp_name=''` (`GetComponentsAction`), `$res` (`GenerateModelByModelClass`: l'exit code di `module:make-model` e' ignorato di proposito, il flusso prosegue anche se il model esiste), `$class0` (`GetTransKeyAction`), `$user/$userRoles` + blocco commentato (`GetModulesNavigationItems`, `hasRole()` e' valutato in `visible()`), `$ids`/`$models` (`Update/*Action`), `$rows` (`Update/PivotAction`), `$name/$model` (`Update/MorphToManyAction`), `$resource`/`$titleString` (`XotBaseManageRelatedRecords::getTitle`), `$message/$stateClass` (`XotBaseState::processStateAction`, no-op dichiarato), `'label'` in `$metrics` (`MeasureAction`), chiave foreach (`ExportXlsStreamByLazyCollection`, `FilterRelationsAction`).
- `GenerateFormByFileAction` (marcata `-WIP`): leggeva il sorgente di `form()` in `$body` senza mai usarlo (dalla prima commit). Rimossa la lettura morta; il generatore di input resta **non implementato**.

### 4. Tipi
- `GetTreeOptionsByModelClassAction`: due `@var` + `@phpstan-ignore-line` sostituiti da un `Assert::isInstanceOf($collection, TreeCollection::class)` (controllo reale a runtime; senza TreeCollection `toTree()` non esisterebbe).

### 5. `HasXotTable` (70 segnalazioni, 5 contesti di classi anonime nei test)
Non riproducibili dopo la modifica del file: erano risultati stale della result-cache condivisa (`/tmp/phpstan`) generati mentre piu' agenti analizzavano in parallelo. Il trait e' corretto (PHPDoc e tipi gia' completi); toccato solo whitespace (righe vuote finali) per invalidare la cache. Nessun cambio funzionale.

## Acceptance Criteria

- [x] `phpstan analyse Modules/Xot/app` senza errori diversi da `classConstant.nativeTypeNotSupported` (vedi decisione composer.json).
- [x] Nessun `@phpstan-ignore*`, `@var` bugiardo, cast per zittire, `assert` finti introdotti.
- [x] Nessun file cancellato/spostato/rinominato; firme pubbliche invariate (chiamanti cercati in `laravel/Modules` e `laravel/Themes`).
- [x] Tutte le costanti di classe di `Xot/app` con tipo nativo.
- [x] Logica mancante ripristinata dove la storia/il docblock la provano (RelationX, RouteService, GetPropertiesFromMethods).
- [x] Dev-story con lezioni imparate.
- [ ] `composer.json` `require.php` allineato a `^8.3` (decisione dell'utente, fuori scope).

## GitHub

Issue: TODO (gh non installato su questa macchina)
Discussion: TODO

Vedi [dev](./2026-10-06-phpstan-cleanup-xot-app.dev.md).
