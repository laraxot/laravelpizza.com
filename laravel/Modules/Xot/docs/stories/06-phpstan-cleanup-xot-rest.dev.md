---
title: "[DEV] PHPStan cleanup Xot (tests, helpers, stub) - gruppo Xot_rest"
type: dev
status: done
created: 2026-10-06
updated: 2026-10-06
module: Xot
tags: [phpstan, cleanup, xot, swarm, tests, pest, lessons-learned]
related:
  - ./2026-10-06-phpstan-cleanup-xot-rest.story.md
  - ./2026-10-06-phpstan-cleanup-xot-app.dev.md
  - ../bmad/phpstan-status.md
---

# [DEV] PHPStan cleanup Xot (tests, helpers, stub)

Story: [2026-10-06-phpstan-cleanup-xot-rest.story.md](./2026-10-06-phpstan-cleanup-xot-rest.story.md)

## Technical Plan

1. Rimisurare i 16 file (il file errori e' di un run con result-cache condivisa e contesti di classi anonime).
2. Per ogni test segnaposto: leggere l'azione/modello sotto test e scrivere l'asserzione che il titolo promette; verificarla contro il codice reale, non a occhio.
3. Per gli stub Pest: capire chi li risolve (PHPStan prima dei vendor) e chi li chiama (nessuno a runtime) prima di toccare le firme.
4. Costanti/enum: nessuna nel perimetro.
5. Verifica con `phpstan analyse Modules` (modo dell'utente) e sui singoli file.

## Files to Modify

- `helpers/Helper.php` - `xotPestStubFailure()` + 9 stub globali (`actingAs`, `get`, `post`, `put`, `patch`, `delete`, `head`, `options`, `followingRedirects`).
- `tests/PestStubs.php` - 20 stub `Pest\Laravel\*` che delegano a `xotPestStubFailure()`.
- `tests/Feature/XotBaseModelBusinessLogicTest.php` - 10 test segnaposto con asserzioni reali, osservatore nominato `XotBaseModelFixtureObserver`.
- `tests/Unit/ModuleServiceTest.php`, `tests/Unit/XotExecuteCoverage50Test.php`.
- `tests/Unit/Actions/Arr/SaveArrayActionTest.php`, `tests/Unit/Actions/String/GetStrBetweenStartsWithActionTest.php`, `tests/Unit/Actions/Query/CreateTableIndexByModelClassColumnsActionTest.php`.
- `tests/Unit/SendMailByRecordActionTest.php` (classe nominata `SendMailRecordLogsFixture`).
- `tests/Unit/HasXotTableLayoutHooksTest.php` (docblock duplicati), `tests/Unit/XotFilamentSupportHundredCoverageTest.php` (assegnazione ridondante), `tests/Unit/XotHundredPercentCoverageTest.php` (argomento in piu' su `isSuspiciousRequest`).

Non modificati (voci stale): `XotBaseResourceCoverageTest`, `SafeObjectEloquentCastActionsTest`, `SafeCastActionsTest`, `SafeArrayCastActionTest`, `XotTableLegacyNameResolutionTest`.

## Implementation Steps

- [x] Rimisurazione: 87 -> 75 (le 12 voci `iterableValue` su classi anonime con PHPDoc gia' presente non si riproducono: stale).
- [x] Test segnaposto: asserzioni su `SaveArrayAction`, `GetStrBetweenStartsWithAction`, `CreateTableIndexByModelClassColumnsAction`, `ModuleService`, `MetatagData::make()`.
- [x] `XotBaseModelBusinessLogicTest`: 10 asserzioni; comportamento Eloquent provato con script PHP senza DB (listener, scope, observable events, accessor/mutator).
- [x] Stub Pest: `xotPestStubFailure()` condivisa, firme invariate.
- [x] `SendMailByRecordActionTest`: classe nominata al posto dell'anonima annidata.
- [x] Pulizie: docblock duplicati, `$inst = null` ridondante, argomento in piu' in `XotHundredPercentCoverageTest`.
- [x] `php -l` sui file toccati; `phpstan analyse Modules` -> 0 errori in `Modules/Xot/{tests,helpers}`.
- [x] Story, dev, `bmad/phpstan-status.md`, indice wiki.

## Testing

Pest **non eseguito**: `laravel/.env.testing` punta a MySQL (`DB_CONNECTION=mysql`, `techplanner_data_test`, `APP_ENV=local`) e `Modules\Xot\Tests\TestCase` apre transazioni sulle connessioni `sqlite/user/tenant/xot`. Brief: niente test fuori da sqlite/in-memory.
Cio' che e' stato provato senza DB: script PHP con `vendor/autoload.php` e un `Illuminate\Events\Dispatcher` a mano sul fixture `new class extends BaseModel {}` (trait, scope globali vuoti, listener `Updater`, `observe()`, `addGlobalScope`, accessor/mutator `Attribute`, `relationLoaded`), e chiamata diretta degli stub (`get('/x', [...])` -> messaggio con i tipi degli argomenti).
Da rilanciare dall'utente su sqlite:
- `Modules/Xot/tests/Feature/XotBaseModelBusinessLogicTest.php` (assume `Model::getEventDispatcher()` valorizzato dal `DatabaseServiceProvider`, cosa vera con l'app di test)
- `Modules/Xot/tests/Unit/{ModuleServiceTest,SendMailByRecordActionTest,XotExecuteCoverage50Test,XotHundredPercentCoverageTest}.php`
- `Modules/Xot/tests/Unit/Actions/{Arr/SaveArrayActionTest,String/GetStrBetweenStartsWithActionTest,Query/CreateTableIndexByModelClassColumnsActionTest}.php` (l'ultimo richiede MySQL: `information_schema`).

## Verification

```bash
cd /mnt/nas07/var/www/_bases/base_techplanner_fila5/laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress --error-format=raw | grep "Modules/Xot/\(tests\|helpers\)"   # nessuna riga
./vendor/bin/phpstan analyse Modules/Xot/helpers Modules/Xot/tests --memory-limit=-1 --no-progress
php -l <file>                                                                                                              # per ogni file modificato
```

Risultato: 87 voci -> **0** in `Modules/Xot/{tests,helpers}`.

## Lessons Learned

- **"Variabile mai letta" in un test = asserzione persa.** In 5 file il corpo si fermava a `$action = app(...)` o `$result = ...`; uno di questi (`CreateTableIndex...`) aveva ancora l'`expect()->toThrow()` nella versione pre-merge. Prima di cancellare la variabile, `git log -p` sul file e rileggere il titolo del test.
- **Un test segnaposto non va "riempito" a occhio.** Le asserzioni sull'Eloquent sono state provate con uno script senza DB: ha scoperto che `Model::hasGlobalScope()` ritorna sempre `false` per le classi anonime (il nome contiene il `.` di `File.php` e `Arr::get` lo legge come notazione puntata): si usa `getGlobalScopes()`.
- **Classe anonima annidata = PHPDoc non risolto da PHPStan** (`missingType.iterableValue` riproducibile anche in `analyse Modules`): usare una classe nominata con il suo `@param`. Le classi anonime non annidate con PHPDoc vanno bene; se compaiono errori solo in alcuni run sono stale della result-cache condivisa (`/tmp/phpstan`, nome della classe anonima con radice relativa diversa): rilanciare `analyse Modules` prima di cambiare codice.
- **Chi risolve cosa conta piu' di cosa dice la firma.** `Pest\Laravel\*` e' risolto da `tests/PestStubs.php` prima del vendor: "correggere" le firme degli stub avrebbe cambiato l'analisi di tutti i moduli. Il parametro inutilizzato di uno stub si sana facendolo servire (diagnostica con i tipi degli argomenti), non togliendolo e non con `func_get_args()` finto.
- **`assertIsArray` su un valore gia' `array`** e' `staticMethod.alreadyNarrowedType`: l'asserzione utile e' sul contenuto (qui `[]` per modulo non registrato).

## Sospetti, orfani, non toccati

- `tests/PestStubs.php`: non e' caricato da `composer.json`, `Pest.php` o altro (solo PHPStan lo vede), duplica funzioni che esistono nel vendor con firme inventate (`actingAs` ritorna `TestResponse` ma Pest ritorna `TestCase`; `followingRedirects(int)` in Pest non ha argomenti; `Pest\Laravel\test/it/describe/beforeEach/afterEach/uses` non esistono: sono globali). Il modulo Gdpr l'ha gia' ridotto a un commento (`PHPStan-only stubs`) e `tests/Support/PestFunctionBridge.php` e' "Intentionally empty". Decisione da prendere: allineare alle firme reali o svuotarlo come Gdpr (verificando l'impatto su tutti i test che importano `Pest\Laravel\*`).
- `helpers/Helper.php`: gli stub globali `get/post/put/...` non hanno chiamanti (tutti i test importano `Pest\Laravel\*`) e vivono nell'autoload di produzione.
- `Xot/app/Services/ModuleService::getModels()` (scope `Xot_app`): legge `$mod->getPath().'/Models'`, ma i moduli hanno i model in `app/Models` (nessun `Modules/*/Models` esiste): per un modulo reale `File::files()` lancera' `DirectoryNotFoundException`. Nessun chiamante di produzione; i test usano solo moduli inesistenti e non lo vedono.
- `XotBaseModelBusinessLogicTest` ha test gia' rotti a runtime (non parte della segnalazione): `serialize()` di una classe anonima lancia "Serialization of ... is not allowed" (test "can be serialized/unserialized") e `toArray()` di un modello vuoto e' `[]` (test "array conversion" fa `assertNotEmpty`). Servono un fixture nominato e attributi.
- `docs/wiki/log.md` contiene marker di merge (`<<<<<<< .merge_file_...`).
- `use Modules\User\Models\User;` inutilizzato in `CreateTableIndexByModelClassColumnsActionTest` (lasciato).
