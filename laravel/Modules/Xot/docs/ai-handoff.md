# ai handoff

## regole non negoziabili
- tests solo pest
- nei tests MAI RefreshDatabase
- se un test fallisce per "manca qualcosa", è il test sbagliato (non si modifica app code)
- phpstan: usare solo la config `phpstan.neon` (non modificare il file, non passare `--level`)

## configurazione ambiente test
- file: `../../.env.testing`
- il bootstrap carica `.env.testing` tramite `Modules/Xot/tests/CreatesApplication.php` (usa `$app->loadEnvironmentFrom('.env.testing')` se presente)
- anche `tests/TestCase.php` root ora usa lo stesso trait `Modules\\Xot\\Tests\\CreatesApplication`, così anche i test che estendono `Tests\\TestCase` usano `.env.testing`

## stato lavori (ultimo)
- Tenant:
  - `Modules/Tenant/tests/Integration/SushiToJsonIntegrationTest.php` convertito a pest, file-based (no DB/auth/tenancy), passa (8 tests)
  - `Modules/Tenant/tests/TestCase.php` reso non invasivo (no migrate/seed automatici)
- Activity:
  - fix syntax error `Modules/Activity/tests/Feature/Actions/ListLogActivitiesActionTest.php` (rimosso `});` finale extra)
- Geo:
  - fix "InvalidPestCommand" durante phpstan: rimossi DSL pest da file autoloadabili
    - `Modules/Geo/tests/Unit/Traits/TestModel.php` ora contiene solo la classe helper
    - `Modules/Geo/tests/Unit/Traits/HasAddressTest.php` ora contiene solo la classe helper
- Xot:
  - `Modules/Xot/tests/pest.php` reso inert (usare `Modules/Xot/tests/Pest.php` come bootstrap)
  - iniziata conversione dei test che usavano `expect()` verso assert PHPUnit (`$this->assert...`) per evitare segnalazioni phpstan su classi interne Pest

## prossimo step tecnico
- continuare a convertire i test in `Modules/Xot/tests/Unit/*` che usano `expect()->...` verso assert PHPUnit
- rilanciare:
  - `./vendor/bin/phpstan analyse Modules --configuration=phpstan.neon --memory-limit=2G`

## note importanti per chi riprende
- evitare file in `Modules/*/tests/**` che contengono **sia** classi namespaced autoloadabili **sia** chiamate pest a livello top (`uses()`, `it()`, `beforeEach()`): spaccare in helper + file `*Test.php`
