---
title: "Activity Module - Testing Coverage Policy"
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity]
qmd: "activity module - testing coverage policy activity"
---
# Activity Module - Testing Coverage Policy

## Obiettivo

Raggiungere e mantenere **100% coverage** con Pest sul modulo Activity.

## Regole Critiche

### 1. NO RefreshDatabase - MAI

- **MAI** usare `RefreshDatabase` o `RefreshDatabase` trait
- **MAI** usare `migrate:fresh` nei test
- I dati non devono mai essere persi tra esecuzioni

### 2. .env.testing

- `.env.testing` è uguale a `.env` tranne per i nomi database
<<<<<<< .merge_file_00x9rz
<<<<<<< HEAD
<<<<<<< HEAD
- I database di test hanno suffisso `_test` (es. `<nome progetto>_data_test`)
=======
- I database di test hanno suffisso `_test` (es. `techplanner_data_test`)
>>>>>>> 0a02158a (.)
=======
- I database di test hanno suffisso `_test` (es. `techplanner_data_test`)
>>>>>>> 35d8cf69 (Initial commit)
=======
- I database di test hanno suffisso `_test` (es. `techplanner_data_test`)
>>>>>>> .merge_file_P5CyQf
- Le variabili `DB_CONNECTION`, `DB_DATABASE` **NON** devono essere sovrascritte in phpunit.xml
- Laravel carica `.env.testing` quando `APP_ENV=testing`

### 3. DatabaseTransactions

- Il TestCase usa `DatabaseTransactions` per rollback automatico tra test
- `$connectionsToTransact = ['mysql', 'activity', 'user']` per coprire tutte le connessioni
- **CRITICO**: La connessione `activity` DEVE essere inclusa. Senza di essa, ActivityLoggerTest getRecent fallisce per inquinamento dati.
<<<<<<< .merge_file_00x9rz
<<<<<<< HEAD
<<<<<<< HEAD
- Nessuna migrazione nel setUp: le migrazioni vanno eseguite nel base testcase (`Modules/Xot/tests/XotBaseTestCase::createApplication()`)
=======
- Nessuna migrazione nel setUp: le migrazioni vanno eseguite una volta: `php artisan migrate --env=testing`
>>>>>>> 0a02158a (.)
=======
- Nessuna migrazione nel setUp: le migrazioni vanno eseguite una volta: `php artisan migrate --env=testing`
>>>>>>> 35d8cf69 (Initial commit)
=======
- Nessuna migrazione nel setUp: le migrazioni vanno eseguite nel base testcase (`Modules/Xot/tests/XotBaseTestCase::createApplication()`) oppure una volta a mano con `php artisan migrate --env=testing` (vedi commento in `Modules/Xot/tests/TestCase.php`)
>>>>>>> .merge_file_P5CyQf

### 4. Connessioni Database

- **mysql**: connessione default
- **activity**: modelli Activity, Snapshot, StoredEvent (creata da TenantServiceProvider a runtime)
- **user**: modelli User

**Regola**: database.php NON deve contenere 'activity'. I modelli Activity DEVONO avere `$connection = 'activity'`. Vedi [fix01](prompts/fix01.md).

**Setup minimo .env.testing:**
```env
<<<<<<< .merge_file_00x9rz
<<<<<<< HEAD
<<<<<<< HEAD
DB_DATABASE=<nome progetto>_data_test
DB_DATABASE_USER=<nome progetto>_data_test
=======
DB_DATABASE=techplanner_data_test
DB_DATABASE_USER=techplanner_data_test
>>>>>>> .merge_file_P5CyQf
```
NON aggiungere DB_DATABASE_ACTIVITY: TenantServiceProvider usa il fallback dal default (stesso DB). Vedi [fix03](prompts/fix03.md).

**Migrazioni pre-test (regola corrente):**
```bash
# automatizzate nel base testcase, senza --force e senza migrate:fresh
php artisan migrate --env=testing --path=Modules/Xot/database/migrations
php artisan migrate --env=testing --path=Modules/User/database/migrations
php artisan migrate --env=testing --path=Modules/Activity/database/migrations
```

### 5. Coverage Scope (CRITICO)

- Con comando root `./vendor/bin/pest --testsuite=Activity --coverage`, il filtro coverage deve essere modulare.
- Se `source` include `Modules/*/app`, il report può includere moduli non target e produrre un totale fuorviante.
- Per sprint Activity, usare filtro source mirato almeno a:
  - `Modules/Activity/app`
  - `Modules/Xot/app`
  - `Modules/User/app`

=======
=======
>>>>>>> 35d8cf69 (Initial commit)
DB_DATABASE=techplanner_data_test
DB_DATABASE_USER=techplanner_data_test
```
NON aggiungere DB_DATABASE_ACTIVITY: TenantServiceProvider usa il fallback dal default (stesso DB). Vedi [fix03](prompts/fix03.txt).

**Migrazioni pre-test:**
```bash
php artisan migrate --env=testing --force
php artisan migrate --database=activity --env=testing --force
php artisan config:clear
```

<<<<<<< HEAD
>>>>>>> 0a02158a (.)
=======
>>>>>>> 35d8cf69 (Initial commit)
## Workflow Coverage

### Comandi

```bash
# Test modulo Activity
cd laravel && php artisan test Modules/Activity/tests --compact

# Coverage
cd laravel && php artisan test Modules/Activity/tests --coverage --min=100

# Singolo file
php artisan test Modules/Activity/tests/Unit/Actions/LogActivityActionTest.php --compact
```

### Struttura Test

```
tests/
├── Feature/          # Test integrazione, Filament, business logic
├── Unit/              # Test unitari Actions, Models, Listeners
├── Pest.php           # Estensioni, helper, expectations
└── TestCase.php       # Base con DatabaseTransactions
```

## Checklist Pre-Commit

- [ ] Nessun RefreshDatabase
- [ ] Nessun migrate nel setUp
- [ ] .env.testing con DB _test
- [ ] DatabaseTransactions attivo
- [ ] Coverage 100% su app/
- [ ] PHPStan livello 10 passa

## Riferimenti Documentazione

- [Laravel Modules Testing](https://laravelmodules.com/docs/12/advanced/tests)
- [Pest Coverage](https://pestphp.com/docs/test-coverage)
- [Laravel Testing](https://laravel.com/docs/12.x/testing)
- [testing-errors-fixes](testing-errors-fixes.md) - Errori risolti e correzioni
- [testing-rules](testing-rules.md)
- [testing-strategy-implementation](testing-strategy-implementation.md)
<<<<<<< HEAD
<<<<<<< HEAD
- [testing-testcase-database-connection-fix](testing-testcase-database-connection-fix.md)
=======
- [testing-testcase-database-connection-fix](testing-testcase-database-connection-fix.md)
>>>>>>> 0a02158a (.)
=======
- [testing-testcase-database-connection-fix](testing-testcase-database-connection-fix.md)
>>>>>>> 35d8cf69 (Initial commit)
