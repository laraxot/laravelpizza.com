---
title: "Test: Pest, difese del database, architettura"
type: rule
status: active
module: Xot
qmd: "testing pest TestCase uses TestDatabaseGuard RefreshDatabase DatabaseTransactions env.testing arch debt test structure coverage"
updated: 2026-11-25
---

# Test: Pest, difese del database, architettura

## Regole

1. **Solo Pest**, mai PHPUnit diretto ([ADR 0003](adr/0003-pest-as-test-runner.md)). I test stanno nel modulo che possiede il codice: `laravel/Modules/<Modulo>/tests/{Unit,Feature,Arch}`;
   non si aggiungono test in `laravel/tests/`. I test dell'applicazione e del tema stanno in `Modules/Meetup/tests` (suite `Project`, quella che blocca la CI:
   `vendor/bin/pest --testsuite=Project`); la suite `Modules` copre `Modules/*/tests/Unit` e `Modules/*/tests/Feature` (`laravel/phpunit.xml`).
2. **TestCase legato nel file**: ogni file di test dichiara `uses(TestCase::class);` (e non un `uses()->in()` nel `Pest.php` del modulo, che il runner root non
   carica). Cosi' i runner di radice e di modulo si comportano allo stesso modo e PHPStan tipizza `$this` ([ADR 0007](adr/0007-module-local-pest-testcase-binding.md)).
3. **Gerarchia**: `Modules\Xot\Tests\TestCase` (usa il MySQL/MariaDB di `.env.testing`; connessioni dei moduli mappate da `TenantServiceProvider`; migrazioni lanciate
   una volta, fuori dai test, con `php artisan migrate --env=testing`; rollback fra test con `DatabaseTransactions`) deriva da `XotBaseTestCase` (bootstrap condiviso;
   la transazione va nel `TestCase` del modulo che la richiede). `Nwidart\Modules\Tests\BaseTestCase` non e' disponibile nel pacchetto installato: si usa `XotBaseTestCase`.
4. **I dati sono sacri**: mai `RefreshDatabase`, mai `migrate:fresh|refresh|reset|rollback`, mai `--force` deciso dall'agente ([ADR 0013](adr/0013-dati-sacri-migrazioni-e-test.md)).
   Pest non si esegue sull'host di produzione: i test si scrivono e si lanciano in sviluppo, e la story lo dichiara.
5. Struttura Arrange-Act-Assert, nomi che descrivono il comportamento ("returns empty array when no markets match query"), copertura minima 80%; un test per un bug
   nasce prima del fix. Per i comportamenti di una classe base esistono i bootstrap di copertura in `tests/ModuleExecuteCoverage.php`, `ModuleBusinessCoverage.php`,
   `ModuleDeepCoverage.php`, `ModuleRemainingCoverage.php` e `FilamentSchemaCoverage.php`.
6. Le guardie che leggono il **sorgente** (non la Reflection) sono la norma per le regole di struttura: i trait sono appiattiti nella classe che li compone, quindi
   `getDeclaringClass()` darebbe falsi positivi (vedi `NoMethodShadowsComposedTraitTest`).

## Difese del database

Un `DB_URL` nel `.env` o una connessione sbagliata non devono mai portare un test su un database vero. Livelli:

| Difesa | Dove | Cosa ferma |
|---|---|---|
| `APP_ENV=testing` forzato | `laravel/phpunit.xml` | avvio dei test con ambiente diverso |
| `TestDatabaseGuard` | `Modules/Xot/tests/Support/TestDatabaseGuard.php`, chiamata da `CreatesApplication` | prima del primo test: ogni connessione non sqlite deve avere database `*_test` (o `claude_scratch_pest_*` di `pest-scratch-db.sh`) **e** host locale (`localhost`, `127.0.0.1`, `::1`, socket, nomi di servizio docker); host extra solo con `TEST_DB_ALLOWED_HOSTS` (mai staging/produzione) |
| `DB::prohibitDestructiveCommands()` | `XotServiceProvider::prohibitDestructiveDatabaseCommands()` | in produzione blocca `db:wipe`, `migrate:fresh|refresh|reset|rollback` |
| ruolo DB senza DDL | infrastruttura | l'utente di sviluppo non puo' fare CREATE/DROP/ALTER su staging e produzione |
| `.env`/`.env.testing` locali | agenti AI | gli agenti lanciano i test ma il loro `.env` non punta a server remoti |

Il DB reale e quello di test stanno sullo stesso server con lo stesso account (che ha DROP): li separa solo il **nome**, per questo il controllo sul suffisso `_test` e' obbligatorio.
`liveuser_general` e' l'unica connessione esclusa dalla guardia (nessun `.env.testing` la definisce): nessun test deve usarla.
Guardie sulla guardia: `tests/Unit/Support/TestDatabaseGuardTest.php`; per i test che richiedono il database dei moduli si imposta `DB_DATABASE_USER=` vuoto, altrimenti `setUp` fallisce con "Unknown database".

## Test di architettura

Pest `arch()` (`tests/Arch/ArchitectureTest.php`): ambito esplicito `production_namespaces()` (mai `Modules`, che con nwidart non e' un prefisso PSR-4 e farebbe passare
la regola su un insieme vuoto), regole `php`, `security`, `strict`, `services`, `xotbase`; il debito di ogni pacchetto sta in `tests/Arch/debt.php` e puo' solo scendere
([ADR 0020](adr/0020-architecture-tests-pest-arch.md); lancio: `vendor/bin/pest --testsuite=Arch`). Le guardie di documentazione sono in `tests/Unit/Docs/` (vedi [docs-conventions.md](docs-conventions.md)),
quelle di struttura in `tests/Unit/Architecture/` e `tests/Unit/Harness/` (marcatori di merge nel codice: `NoConflictMarkersInCodeTest`).

## Vedi anche

- [code-quality-2.md](code-quality-2.md), [module-structure.md](module-structure.md)
- [adr/0003-pest-as-test-runner.md](adr/0003-pest-as-test-runner.md), [adr/0007-module-local-pest-testcase-binding.md](adr/0007-module-local-pest-testcase-binding.md)
