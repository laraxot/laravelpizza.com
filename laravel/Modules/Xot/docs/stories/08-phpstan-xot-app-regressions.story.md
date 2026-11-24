---
title: "[STORY] PHPStan Xot/app: regressioni del cleanup del 2026-10-06"
type: story
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
module: Xot
tags: [phpstan, xot, regressione, swarm, urlact, update-actions]
related:
  - ./2026-10-06-phpstan-cleanup-xot-app.story.md
  - ./2026-10-06-phpstan-cleanup-xot-app.dev.md
---

# [STORY] PHPStan Xot/app: regressioni del cleanup del 2026-10-06

## User Request

Azzerare gli errori PHPStan di `Xot/app` (7 segnalazioni in 5 file) partendo dallo scopo del codice, non dal messaggio. Il sospetto di partenza: il cleanup del 2026-10-06 ([story](./2026-10-06-phpstan-cleanup-xot-app.story.md)) aveva tolto variabili "inutilizzate" che in realta' servivano.

## Analysis

| File | Segnalazione | Scopo scoperto | Esito |
|---|---|---|---|
| `Actions/Model/Update/MorphManyAction.php` | `$res` mai letta, `$models` indefinita | Regressione vera: `saveMany($models)` usa ancora `$models`, che e' cio' che scrive morph type/id sui figli. Senza, le righe del form non venivano associate al padre. | Logica ripristinata (`$models`); `$ids` (mai letta nemmeno nell'originale, copia del template BelongsToMany) tolta |
| `Actions/Model/Update/CustomRelationAction.php` | `$res` mai letta | Una `CustomRelation` non ha save/attach/sync: resta solo l'aggiornamento dei campi per riga. `$ids`/`$models` non servivano a nulla gia' nell'originale. | Il risultato di `UpdateAction` non si salva piu'; docblock con lo scopo |
| `Services/RouteService.php::urlAct` | `$routename` assegnato e mai letto | Il riordino del 2026-10-06 era giusto (route corrente -> route-azione), ma l'ultima assegnazione `$routename = $route_current->getName()` era rimasta orfana. Verificando il flusso e' uscito un bug latente, vedi sotto. | Corretto, con test |
| `Actions/Filament/GenerateFormByFileAction.php` | `array_slice()` senza uso del risultato | WIP: leggeva il sorgente di `form()` per riscriverne lo `->schema(...)` come fa `GenerateTableColumnsByFileAction` con `table()` (tramite `GetMethodBodyAction`). Il generatore non e' mai stato scritto. | Lettura morta rimossa (`$form_method`, `file()`, `SafeStringCastAction`); docblock dichiara il WIP e indica `GetMethodBodyAction` |
| `Console/Commands/OptimizeFilamentMemoryCommand.php` | `Assert` sconosciuta | `Assert::isArray($issues)` / `Assert::boolean($verbose)` su parametri gia' tipizzati erano un finto "uso" per zittire "parametro inutilizzato" (non un controllo). Le ottimizzazioni sono globali (cache, tabelle, autoloader) e non dipendono dai problemi rilevati. | Tolti asserzioni, import e parametri del metodo privato `applyOptimizations()` (unico chiamante: `handle()`) |

### Bug latente in `RouteService::urlAct`

Prima del riordino il nome della route partiva sempre da `''`, quindi `Route::has()` era sempre falso e la funzione restituiva sempre `#show`: il ramo `route(...)` non girava mai. Ora gira, e ha due difetti:

1. `$row = (object) []` come default veniva messo come parametro posizionale di `route()`: lo stdClass finiva nella query string e `route()` andava in errore. Ora `row` e' opzionale (`$params['row'] ?? null`) e si passa solo se presente.
2. `Str::before($routename, $old_act)` taglia alla PRIMA occorrenza dell'ultimo segmento: con `admin.edit_profile.edit` dava `admin.` e quindi `#admin.show`. Ora `Str::beforeLast`.

Chiamanti di `urlAct` in `laravel/Modules` e `laravel/Themes`: nessuno (solo la dichiarazione `@method`). Nessun bug di navigazione in produzione, ma il codice era una trappola per il primo che lo avesse usato.

## Modifiche

- `Xot/app/Actions/Model/Update/MorphManyAction.php`, `CustomRelationAction.php`
- `Xot/app/Services/RouteService.php`
- `Xot/app/Actions/Filament/GenerateFormByFileAction.php`
- `Xot/app/Console/Commands/OptimizeFilamentMemoryCommand.php`
- Test nuovi (senza query: spy al posto della relazione e `UpdateAction` sostituita nel container): `Xot/tests/Unit/Actions/Model/Update/MorphManyActionTest.php`, `CustomRelationActionTest.php`, `Xot/tests/Unit/Services/RouteServiceTest.php`

## Verifica

- PHPStan sui 5 file (`vendor/bin/phpstan analyse <5 file> -c phpstan.neon --no-progress`): prima 7 segnalazioni, dopo `[OK] No errors`.
  Nota: una run intermedia ha dato `identical.alwaysTrue` su `$row === null` (con `$row = null` prima di `extract()` PHPStan non vede la sovrascrittura); risolto leggendo `$params['row'] ?? null` dopo `extract()`, senza `ignore`.
- `php -l` su tutti i file modificati e sui 3 test: nessun errore di sintassi.
- Pest: NON eseguibile da questo host. `Modules\Xot\Tests\TestCase` usa `DatabaseTransactions` su MySQL `10.100.200.53:3306` e la porta va in timeout (`rc=124`); in piu' non c'e' un `phpunit.xml` raggiungibile (Pest esce con `Could not read XML from file "--cache-directory"`). Le stesse asserzioni dei 3 test sono state eseguite con uno script standalone su container Laravel nudo: 10/10 PASS (MorphMany: `saveMany` chiamato una volta con i figli nell'ordine, payload vuoto senza effetti; CustomRelation: ogni riga a `UpdateAction` sul `related`; `urlAct`: caso base, ultimo segmento, ancora `#...`, parametro `row`). Il gate Pest va chiuso da un host che raggiunge il DB di test.

## Decisioni

- `MorphManyAction` non cancella ne' stacca le righe assenti dal payload: l'originale non lo faceva e un `saveMany` non e' un `sync`. Aggiungerlo sarebbe distruttivo senza una richiesta esplicita.
- `GenerateFormByFileAction` resta WIP: implementare il generatore di input e' una funzione nuova, non un fix.
- Durante il lavoro un'altra sessione ha ripristinato `$models` in `MorphManyAction` e tolto `$form_method`/lettura morta in `GenerateFormByFileAction`: ho riletto i file, verificato lo stato e completato (docblock, `$ids`, commento stantio).

## Aperto

- `OptimizeFilamentMemoryCommand` dichiara `{--verbose}`: Symfony ha gia' `--verbose|-v`, quindi eseguirlo fallisce con `An option named "verbose" already exists` (provato con un `Application` Symfony). Il comando e' commentato in `XotServiceProvider::registerCommands()` quindi oggi non gira. Va rimossa l'opzione usando `$this->output->isVerbose()`, ma `XotCommandsActionsHundredCoverageTest` asserisce `hasOption('verbose')`: da aggiornare insieme.
- `UpdateAction` ricorsiva + `dddx()` nei rami "riga senza chiave" di `MorphMany`/`CustomRelation`: comportamento storico, non toccato.
