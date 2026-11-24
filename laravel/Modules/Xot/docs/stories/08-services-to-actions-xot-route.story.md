---
title: "[STORY] Services verso Actions: RouteService e RouteDynService"
type: story
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
module: Xot
tags: [services-to-actions, queueable-action, route, urlact, dynamic-routes, bmad]
related:
  - ./2026-10-06-phpstan-cleanup-xot-app.story.md
  - ./2026-10-08-phpstan-xot-app-regressions.story.md
  - ../wiki/decisions/services-to-actions-migration.md
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
---

# [STORY] Services verso Actions: RouteService e RouteDynService

## User Request

Cluster "Xot-route" dell'epic `epic-code-standards-services-mixed-const`: niente `app/Services`, ogni caso d'uso e' una Spatie
Queueable Action con tutti i chiamanti aggiornati; `const` in tipi piu' adeguati; `mixed` ultima spiaggia. Perimetro:
`app/Services/RouteService.php` (8 metodi pubblici) e `app/Services/RouteDynService.php` (18 metodi pubblici).

## Analysis

Scopo prima del codice: entrambi erano gia' residui di una migrazione parziale. Le Action sostitutive esistevano gia' in HEAD
(`app/Actions/Route/`, create il 24-26 settembre) e i due Service non avevano nessun chiamante di produzione: `rg` su
`laravel/Modules`, `laravel/Themes`, `laravel/` e `bashscripts/` (FQCN, nome breve, stringhe, config, provider, Blade) trova
solo test e commenti. L'unica citazione viva era un commento in `Tenant/.../MorphMapConfigResolver.php` ("Ex RouteService::inAdmin()").

Il lavoro vero non era creare Action, ma provare che le Action esistenti fanno quello che faceva il Service, prima di
cancellarlo. Una sonda di parita' (script fuori repo che bootstrappa l'app, registra route fittizie, imposta la route corrente e
confronta Service e Action sugli stessi input) ha trovato divergenze reali:

| Metodo | Divergenza trovata nella Action esistente | Esito |
|---|---|---|
| `urlAct` -> `BuildActionUrlAction` | `row` defaultava a `(object) []` e finiva come parametro posizionale di `route()`: con una route-azione senza parametri `route()` lanciava (il bug che oggi ha corretto l'altro agente nel Service, mai portato nella Action) | `row` opzionale, passato solo se presente |
| `urlAct` -> `BuildActionUrlAction` | `Str::beforeLast($name, '.')` su un nome senza punti lasciava il nome intero (`edit` -> `edit.show` invece di `show`) | si sostituisce l'ultimo segmento come il Service: `beforeLast($name, afterLast($name, '.'))` |
| `getAct`/`getModuleName`/`getControllerName`/`getView` -> `GetCurrentRoute*Action` | usavano `getActionName()`, che per una route a closure restituisce la stringa `Closure`; il Service usava l'azione `controller` e lanciava. Quattro copie dello stesso preambolo | nuova `GetCurrentRouteHandlerAction` (handler `controller` della route corrente, `RuntimeException` se manca), usata dalle quattro |
| `inAdmin`, `getRoutenameN`, `urlLang` | nessuna | invariate |

Sonda su 8 route fittizie e 5 combinazioni di parametri: 21 differenze prima delle correzioni, 8 dopo, tutte volute (route senza nome o assente, vedi "Decisioni"); le altre 13 sono quelle della tabella.

`RouteDynService` (DSL di route -> `Route::group/resource/match`): 18 metodi pubblici che sono passi interni ricorsivi di un
solo algoritmo, gia' portati il 2026-10-06 in `RegisterDynamicRoutesAction` (12 helper privati) piu' `GetRouteMethodAction` per
`getMethod`. Nessun metodo restava da portare. Scoperta: esisteva una terza copia, `app/Actions/RouteDynAction.php` (370 righe, metodi
statici identici al Service, rinominata "Action"): l'anti-pattern "Action contenitore". Zero chiamanti di produzione, solo due test
di coverage. Stessa sonda: sei DSL (resource, param, prefix esplicito, acts con metodi diversi, subs annidati, only/controller/as)
registrate con le tre implementazioni danno tabelle di route identiche (nome, uri, metodi, `uses`, namespace): 0 differenze.

## Modifiche

Mappa Service -> Action (le Action marcate "esistente" erano gia' nel repo prima di questa sessione):

| Service | Action |
|---|---|
| `RouteService::inAdmin` | `IsAdminRouteAction` (esistente) |
| `RouteService::urlAct` | `BuildActionUrlAction` (esistente, allineata) |
| `RouteService::getRoutenameN` | `BuildNestedRouteNameAction` (esistente) |
| `RouteService::urlLang` | `BuildLanguageUrlAction` (esistente, stub che restituisce `?`) |
| `RouteService::getAct` / `getModuleName` / `getControllerName` / `getView` | `GetCurrentRouteActionNameAction` / `GetCurrentRouteModuleNameAction` / `GetCurrentRouteControllerNameAction` / `GetCurrentRouteViewAction` (esistenti, ora su `GetCurrentRouteHandlerAction` nuova) |
| `RouteDynService::dynamic_route` e i 16 passi interni | `RegisterDynamicRoutesAction` (esistente) |
| `RouteDynService::getMethod` | `GetRouteMethodAction` (esistente) |
| `RouteDynAction` (terza copia) | `RegisterDynamicRoutesAction` |

File codice (`laravel/Modules/Xot/`):
- modificati: `app/Actions/Route/BuildActionUrlAction.php`, `GetCurrentRouteActionNameAction.php`, `GetCurrentRouteControllerNameAction.php`, `GetCurrentRouteModuleNameAction.php`, `GetCurrentRouteViewAction.php`
- nuovo: `app/Actions/Route/GetCurrentRouteHandlerAction.php`
- eliminati (il repo Xot e' stato committato nel frattempo dal proprietario: `bea6f0b3` contiene queste cancellazioni, si recuperano da `bea6f0b3^`): `app/Services/RouteService.php` (la versione committata e' precedente al fix di `urlAct` di oggi, che ora vive in `BuildActionUrlAction`), `app/Services/RouteDynService.php`, `app/Actions/RouteDynAction.php`

Test:
- `tests/Unit/Services/RouteServiceTest.php` (non tracciato, creato oggi) -> `tests/Unit/Actions/Route/BuildActionUrlActionTest.php`: le 4 asserzioni originali identiche (URL dalla route corrente, solo ultimo segmento, ancora `#...`, `row` posizionale) piu' 3 nuove (nome senza punti, route senza nome, chiavi `null` di `RouteParamsData` e `query`).
- nuovo `tests/Unit/Actions/Route/CurrentRouteActionsTest.php`: modulo, controller, azione, vista, nomi `Module`/`Item` scartati, vista dai parametri `containerN`, closure rifiutata (il Service non aveva test su questi metodi).
- `tests/Unit/Services/RouteDynServiceTest.php` eliminato: le sue due asserzioni (`getMethod` filtra i valori non stringa e torna a `get,post`) descrivevano un filtro che il codice (`Arr::wrap`) non ha mai avuto; il test non poteva passare ed era gia' stato corretto in `GetRouteMethodActionTest`.
- nuovo `tests/Unit/Actions/Route/RegisterDynamicRoutesActionTest.php`: sostituisce il test "RouteDynAction calcola prefix namespace e resource opts" di `XotExecuteCoverage50Test` (tutte le asserzioni su prefix, namespace, as, controller, uses, method, nomi delle route di resource, ora lette dalle route registrate) e aggiunge subs annidati e lista vuota.
- `tests/Unit/XotExecuteCoverage50Test.php`: tolto il test RouteDynAction e l'import; test `RouteService inAdmin` rinominato (asseriva gia' `IsAdminRouteAction`).
- `tests/Unit/XotArtisanCommandsHelpersCoverageTest.php`: tolto `RouteService::class` dalla lista della reflection.
- `tests/ModuleExecuteCoverage.php`: tolto `testRouteDynActionStatics()` (inghiottiva ogni `Throwable` e asseriva `executed > 0`, sempre vero).

## `const` e `mixed`

- Nessuna `const` di classe nei due Service. `RouteDynService::$namespace_start` era stato statico mutabile condiviso tra chiamate
  (accoppiamento nascosto); in `RegisterDynamicRoutesAction` e' una proprieta' di istanza.
- `mixed`: i parametri `array<string, mixed>` di `BuildActionUrlAction` sono input dinamico (parametri route, `RouteParamsData::toArray()`)
  validato con `is_string`/`is_array`; nell'Action della DSL le chiavi sono validate con Webmozart Assert. Nessun `mixed` nudo introdotto.

## Verifica

- PHPStan: `vendor/bin/phpstan analyse Modules/Xot/app/Actions/Route Modules/Xot/tests/Unit/Actions/Route Modules/Xot/tests/Unit/XotExecuteCoverage50Test.php Modules/Xot/tests/Unit/XotArtisanCommandsHelpersCoverageTest.php Modules/Xot/tests/ModuleExecuteCoverage.php Modules/Xot/tests/Unit/XotExplicitZeroKillersTest.php -c phpstan.neon --no-progress` -> `[OK] No errors`.
- `php -l` su tutti i file toccati: nessun errore.
- Pest: `Modules\Xot\Tests\TestCase` usa `DatabaseTransactions` e il DB di test (`fixcity_user_test` su MariaDB locale) non esiste, quindi i test standard falliscono prima di girare. Eseguiti comunque, su copie temporanee con `XotBaseTestCase` al posto di `TestCase` (stessa app, niente transazioni; copie cancellate): `BuildActionUrlActionTest` 7/7, `CurrentRouteActionsTest` 4/4, `RegisterDynamicRoutesActionTest` 4/4, `RouteActionsTest`, `GetRouteMethodActionTest`, `XotExplicitZeroKillersTest` (action URLs), `XotExecuteCoverage50Test` (IsAdminRouteAction): tutti verdi. Il gate Pest sui file originali va chiuso con i DB di test creati.
- Sonde di parita' (scratchpad, fuori repo): vedi Analysis.

## Decisioni

- Differenza voluta in `urlAct`: senza route corrente o con route corrente senza nome la Action restituisce `#<act>`. Il Service partiva da `''` e cercava una route globale che si chiamasse esattamente come l'azione (`show`): un accidente, non una funzione.
- Closure: il Service lanciava `Exception`, le Action lanciano `RuntimeException` (sottoclasse): stesso contratto "non c'e' un handler da leggere".
- `GetCurrentRouteHandlerAction` rompe la regola scritta in `services-to-actions-migration.md` ("nessuna Action chiama un'altra Action"), gia' non vera per `RegisterDynamicRoutesAction` -> `GetRouteMethodAction`: qui evita quattro copie dello stesso preambolo e riporta il comportamento del Service.
- Fonte della route corrente: il Service usava `Route::current()`, le Action `request()->route()`; in una richiesta reale coincidono.
- `RegisterDynamicRoutesAction` non e' stata toccata (solo test).

## Aperto

- `Helper.php::inAdmin()` (helper globale, usato da `BuildNestedRouteNameAction` come lo era dal Service) controlla `Request::segment(2) === 'admin'`; `IsAdminRouteAction` e il vecchio `RouteService::inAdmin` controllano `segment(1)`. Due definizioni di "sono in admin" divergenti, nessuna delle due letta da codice di produzione tranne l'helper. Va deciso quale e' giusta (prefisso lingua?) e consolidare: fuori perimetro.
- `BuildLanguageUrlAction` restituisce `?` (stub, corpo commentato nel Service originale), zero chiamanti: candidata a eliminazione insieme alla sua asserzione in `RouteActionsTest`.
- `RegisterDynamicRoutesAction` non ha nessun chiamante nel repo (la DSL `dynamic_route` non e' usata da nessun `routes/*.php`): decidere se tenerla (possibile uso da progetti esterni) o eliminarla.
- Documentazione storica che cita `RouteService`/`RouteDynService` (report PHPStan, audit, `helpers.md`) non e' stata riscritta: solo `wiki/decisions/services-to-actions-migration.md` ha la nota datata.
