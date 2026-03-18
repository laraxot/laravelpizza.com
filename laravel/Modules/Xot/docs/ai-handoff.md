# ai handoff

## regole non negoziabili
- tests solo pest
- nei tests MAI RefreshDatabase
- se un test fallisce per "manca qualcosa", è il test sbagliato (non si modifica app code)
- phpstan: usare solo la config `phpstan.neon` (non modificare il file, non passare `--level`)

## prima di eseguire un task
- chiarire nei `docs/` il perche', lo scopo, la ragione, la policy, la visione e la filosofia del lavoro richiesto
- trattare `docs/` come canale di scambio tra agenti, non solo come documentazione finale
- lasciare handoff sintetici quando un altro agente puo' riprendere il contesto senza riaprire tutta la codebase
- se il tema attivo e' coinvolto, aggiornare anche i `Themes/*/docs/` pertinenti
- se la decisione cambia governance o merita confronto asincrono, valutare GitHub Issue/Discussion dopo verifica con `git remote -v`
- se il task tocca quality gates PHP, ricordare che `PHPMD` va usato come `.phar` standalone e non installato via Composer nel repository
- prima di introdurre helper locali di cast/normalizzazione, studiare `Modules/Xot/app/Actions/Cast/` e riusare o estendere l'action autorevole; duplicare micro-helper come `castNullableString()` viola DRY e segnala studio incompleto del codebase
- prima di introdurre helper locali di cast/normalizzazione, studiare `Modules/Xot/app/Actions/Cast/` e riusare o estendere l'action autorevole; duplicare micro-helper come `castNullableString()` viola DRY e segnala studio incompleto del codebase
- se compare un helper locale di cast/normalizzazione ripetuto, cercare prima in `Modules/Xot/app/Actions/` e convergere li' la logica condivisa
- se un bug arriva da una URL reale o da uno stack trace runtime, non chiudere il task con test statici sul source: serve almeno un Pest che riproduca la stessa shape runtime
- se la stessa URL reale continua a rompersi dopo il fix, il Pest precedente e' da considerare insufficiente anche se passava; non vale come prova un test che controlla solo stringhe nel source o un run Pest senza output/esito affidabile
- nei widget Filament/Livewire evitare proprieta' pubbliche con array di oggetti custom non serializzabili: preferire payload array serializzati e ricostruzione esplicita nel componente

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

## tracking governance
- issue di riferimento quality gates: `#76`
- discussion di riferimento quality gates: `#75`
- usare issue per il delta operativo verificabile
- usare discussion per convergere su policy, eccezioni, tradeoff e coordinamento tra agenti

## note importanti per chi riprende
- evitare file in `Modules/*/tests/**` che contengono **sia** classi namespaced autoloadabili **sia** chiamate pest a livello top (`uses()`, `it()`, `beforeEach()`): spaccare in helper + file `*Test.php`
- prima di riprendere una task, leggere questo file e i docs locali per recuperare il motivo della soluzione, non solo l'ultimo diff
- quando compare una utility apparentemente banale, controllare prima Xot: spesso la logica esiste gia' come action condivisa e va solo adattata forward-only
- quando compare una utility apparentemente banale, controllare prima Xot: spesso la logica esiste gia' come action condivisa e va solo adattata forward-only
- per cast/string normalization: `SafeStringCastAction` copre il caso string obbligatoria; `SafeNullableStringCastAction` copre il caso `string|null`
- per bug dashboard/livewire/query: usare URL, payload Livewire e SQL dello stack trace come specifica minima del test di regressione
