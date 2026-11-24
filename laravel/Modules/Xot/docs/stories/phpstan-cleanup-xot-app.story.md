---
qmd: "xot stories phpstan cleanup xot app story md"
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
<<<<<<< .merge_file_CwXOzN
=======

## Rimozione `@phpstan-ignore` residue in Xot (seconda tornata)

Regola di progetto: mai `@phpstan-ignore`, mai baseline. Nota di tracciabilita': `phpstan-ignore-removal.story.md` di Xot (campagna 2026-10-30) non e' piu' nel working tree (ultima versione in `bb8832ec9`, sparita col merge `c000be45d`); la sezione sta qui, nessun file nuovo.

### 1. `CheckAccessorTwinsCommand::methodFromVendor()` (`missingType.generics`)
- Scopo: `xot:check-accessor-twins` verifica la regola `accessor-twin-method` (ogni `get{X}Attribute()` ha il gemello `get{X}()`); `methodFromVendor()` risale trait e classi padre di un modello per escludere i metodi che vengono da vendor.
- Causa: `\ReflectionClass` e' generica e il parametro non aveva argomento. L'ignore stava inoltre sopra un secondo docblock, staccato dal metodo.
- Correzione: un solo docblock con `@param \ReflectionClass<covariant object> $reflection`. `ReflectionClass<object>` non basta: il template e' invariante e PHPStan rifiuta `ReflectionClass<Model>` (`argument.type`); `covariant object` e' il tipo vero, perche' il metodo percorre anche trait e padri, non solo Model. Nessun cambio di codice eseguibile.
- Esito: `xot:check-accessor-twins --module=Xot|TechPlanner|User` (sola lettura) identico prima/dopo (12/1/0, 21/14/16, 39/6/1: classi/accessor/senza gemello).

### 2. `tests/FilamentSchemaCoverage.php` (`/* @phpstan-ignore-next-line */` nudo)
- Scopo: helper condiviso dei test `*FilamentSchemaCoverageTest` (Xot, Job, Notify, User, UI) che esegue `getFormSchema()` di ogni form concreto.
- Causa: l'ignore nascondeva `method.staticCall`. `XotBaseResourceForm::getFormSchema()` e' un metodo d'istanza (`abstract public`), il test lo chiamava come `$class::getFormSchema()`: a runtime `Error` ("Non-static method cannot be called statically"), inghiottito dal `catch (\Throwable)`. Il ramo "form" del test non eseguiva mai nessuno schema e passava lo stesso.
- Correzione: `(new $class)->getFormSchema()` (come `testAllTables()` nello stesso file; nessun form ha costruttore). `app($class)` darebbe `mixed` (Larastan non risolve `class-string<T>` ristretto da `is_subclass_of`).
- Esito: `XotFilamentSchemaCoverageTest` 7 passed, asserzioni 106 -> 128 (i form di Xot ora vengono davvero eseguiti). Job e Notify PASS, UI 4 passed + 1 risky (list page, senza asserzioni, gia' risky prima), User invariato (stesso fallimento di prima, `Class "CreatePostViewsTable" not found` nel setup migrazioni del `TestCase` di User, estraneo).
- Da sapere: il `catch (\Throwable)` dell'helper copre ancora `assertKeyedSchema()` e `assertContainsOnlyInstancesOf()`: un form con schema non conforme non fa fallire il test. Decisione da prendere a parte (restringerlo cambia l'esito dei test di altri moduli).

### 3. Trait con `@phpstan-ignore trait.unused` (solo investigazione, nessuna modifica)
Reintrodotti in blocco da `8b27fdf62` (2026-11-06) dopo che il 2026-10-30 erano stati tolti; cinque hanno anche il duplicato inline `trait X // @phpstan-ignore trait.unused` oltre al docblock. `trait.unused` compare solo analizzando una cartella: con `analyse Modules` o `Modules/Xot` (tests/fixture inclusi) i primi cinque hanno un consumatore e l'annotazione e' superflua; analizzando solo `Modules/Xot/app` tornerebbe.

| Trait | Consumatori | Opzione |
|---|---|---|
| `Models/Traits/HasUuid` | nessuno (app, tests, Themes, altri moduli); solo docs/audit | (b): colonna `uuid` separata, Cms/Blog fanno solo il cast; ritirare o far usare a `Cms\BaseModel` se la colonna va generata |
| `Models/Traits/HasDynamicFillable` | `TechPlanner/Models/Client`, `HasDynamicFillableTest` | (a) gia' usato: togliere le annotazioni (docblock e inline) quando l'analisi e' su `Modules` |
| `Traits/HasCsrfToken` | solo classe anonima in `XotExecuteCoverage50Test` | (b): `public string $_token` scrivibile da client su Livewire, ridondante con il CSRF di Laravel/Livewire |
| `Traits/HasTableFunctionsTrait` | fixture `HasTableFunctionsTraitProbe`, `HasTableFunctionsCustomSlugProbe` | (b) o (c): nessuna classe reale; colonne generiche id/name/created_at |
| `Traits/Filament/HasCustomModelLabel` | fixture `HasCustomModelLabelProbeBase` (due copie in `Fixtures/Stubs` e `Fixtures/Traits`) | (b) o (c): nessuna Resource lo usa; le Resource usano `XotBaseResource` |
| `Traits/EnumIntegerTrait` | nessuno; citato in `docs/wiki/rules/enum-pattern-filament.md` e nel wiki `enum-trait-composition-pattern` | (c): API di piattaforma, l'annotazione porta gia' il motivo; (a) se nasce un enum int-backed |
| `Datas/Concerns/HasYearsConfig` | `YearsConfigFixture` in `HasYearsConfigTest`; `YearsConfigContract` (`@see`); attesi dalle `{Modulo}ConfigData` fuori da questo repo | (c) o (a): l'uso reale e' nei moduli applicativi assenti qui |

Duplicati docblock+inline: se si resta su (c), tenerne uno solo. Cancellare o spostare resta decisione dell'utente.

### Verifica
- `phpstan analyse Modules/Xot` (cartella, cache attiva): 0 errori prima (con le due annotazioni) e 0 dopo (senza); `phpstan.neon` invariato. Fra la prima e l'ultima corsa il bootstrap e' stato bloccato piu' volte da marcatori di conflitto di merge di altri agenti (Employee, Notify, Rating, User): corse ripetute a file puliti.
- Il fix e' gia' in `bc975dae5` (commit di un altro agente).
- Non verificato: `analyse Modules` intero; il fallimento preesistente di `UserFilamentSchemaCoverageTest`.
>>>>>>> .merge_file_zAjPyF
