---
title: "TestCase del modulo Activity"
type: note
status: active
created: 2026-10-07
updated: 2026-10-20
tags: [docs, activity, tests, testcase, pest]
qmd: "testcase activity xotbasetestcase databasetransactions connectionsToTransact makeListLogActivitiesPage pesthelpers"
related:
  - ./wiki/concepts/testcase-hierarchy-architecture.md
  - ./stories/phpstan-test-wave-activity.story.md
---

# TestCase del modulo Activity

Questa nota descrive `tests/TestCase.php` cosi' com'e' nel codice. Il perche' dell'ereditarieta' (Activity -> Xot -> Laravel) sta in [wiki/concepts/testcase-hierarchy-architecture.md](./wiki/concepts/testcase-hierarchy-architecture.md).

## Cosa fa

`Modules\Activity\Tests\TestCase` estende `Modules\Xot\Tests\XotBaseTestCase` e aggiunge solo cio' che riguarda Activity:

- `DatabaseTransactions` su `$connectionsToTransact = ['sqlite', 'activity', 'user']`: ogni test annulla le scritture di tutte e tre le connessioni. Nessun `RefreshDatabase` e nessuna migrazione nel `setUp()`.
- `setUp()` chiama `prepareSharedSqliteForTesting()` prima di `parent::setUp()` (punta le connessioni sqlite al file condiviso e condivide un solo PDO), poi imposta `auth.providers.users.model` su `Modules\User\Models\User`.
- `getPackageProviders()` compone `parent::getPackageProviders()` con `UserServiceProvider`, `ActivityServiceProvider` ed `EventServiceProvider`.
- Dati condivisi tra test: `$activityData`, `$storedEventData`, `$snapshotData`.
- Pagina Log: `$page`, `requirePage()` e il metodo statico `makeListLogActivitiesPage()`, che restituisce una `ListLogActivities` anonima con `exposeRestoreSuccess()` ed `exposeRestoreFailure()`. E' statico perche' PHPStan non tipizza `$this` nelle closure Pest annidate (`describe()` e `test()`).

## Helper per i test

- `tests/Helpers.php`: `activityCreateUser()`, `activityCreateActivity()` e `mockeryExpect()`, con prefisso `activity` per non collidere con gli helper degli altri moduli. Pest carica `Helpers.php` da solo quando si lancia con `--test-directory=Modules/Activity/tests`. Il file si chiamava `PestHelpers.php`, nome che Pest non carica: `mockeryExpect()` risultava indefinita e 18 test fallivano (misura del 2026-11-05).
- `tests/Feature/TestActivityModel.php`: modello concreto per provare `BaseModel`. Sta in `Tests\Feature` e non in `Models`, quindi `GetFactoryAction` non puo' ricavarne il modulo e generargli una factory: i test verificano che esponga `factory()`, non che ne risolva una. Usa `HasFactory` (richiesto dai test sui trait) con `HasXotFactory::factory insteadof HasFactory`; una regola `insteadof` su un metodo che il trait non ha (per esempio `newFactory`) e' un fatal error di PHP che PHPStan non segnala.
- Factory nei test: `ActivityFactory::new()->createOne([...])` e `UserFactory::new()->createOne()`, come nei test gia' tipizzati del modulo.

## Eseguire i test

```bash
cd laravel
XDEBUG_MODE=off ./vendor/bin/pest --test-directory=Modules/Activity/tests Modules/Activity/tests/Unit/Models/BaseModelTest.php --no-coverage
./vendor/bin/phpstan analyse Modules/Activity --memory-limit=2G --no-progress
```

Limiti verificati il 2026-10-20:

- Il TestCase forza le connessioni SQLite verso il file condiviso risolto da
  `XotBaseTestCase::sharedSqlitePath()`. In questo checkout non esiste un file SQLite
  in `laravel/database`, quindi il resolver ricade su `database/test_data.sqlite`,
  ignorato da Git e non materializzato. `.env.testing` dichiara invece MySQL: i due
  contratti sono incoerenti. Il comando `xot:build-test-sqlite` può costruire lo
  schema, ma modifica il target e non va eseguito senza verificare che sia usa-e-getta.
  Non aggiungere migrazioni al `setUp()` e non usare `migrate:fresh`: vedi
  [testing-coverage-policy.md](./testing-coverage-policy.md) e
  [rules-testing-no-migrate-fresh.md](./rules-testing-no-migrate-fresh.md).
- Lanciando `pest <file>` senza `--test-directory=Modules/Activity/tests` ne' `tests/Pest.php` ne' `tests/Helpers.php` del modulo vengono caricati, quindi gli helper risultano non definiti nei test che li usano. PHPStan li vede perche' analizza tutto `Modules/`.

## Storia

Il 2026-10-20 il pull dei sottomoduli ha riportato in `tests/` una generazione precedente di test e di `TestCase` (classi PHPUnit su `Tests\TestCase`, colonne inesistenti, un modulo `IndennitaResponsabilita` che qui non c'e'): 605 errori PHPStan in 19 file. Il riallineamento e' descritto in [stories/phpstan-test-wave-activity.story.md](./stories/phpstan-test-wave-activity.story.md).
