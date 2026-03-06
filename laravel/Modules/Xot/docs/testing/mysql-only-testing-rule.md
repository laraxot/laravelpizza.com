# REGOLA CRITICA: MySQL Only per Testing - Nessun SQLite

**Status**: ✅ REGOLA ASSOLUTA - NESSUNA ECCEZIONE  
**Priorità**: MASSIMA

## 🚨 Principio Fondamentale

> **Il file `.env.testing` è la fonte unica di verità per la configurazione dei test.**
> 
> **SQLite è VIETATO per i test. SEMPRE e SOLO MySQL con suffisso "_test".**

## 🚨 REGOLA FONDAMENTALE: .env.testing è COPIA CARBONE del .env

### Principio
Il file `.env.testing` deve essere una copia esatta del `.env` con **una sola modifica**: il suffisso `_test` aggiunto ai nomi dei database definiti nel `.env`.

### Esempio Corretto
```bash
# .env (produzione/sviluppo)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_data
DB_USERNAME=marco
DB_PASSWORD=marco

DB_DATABASE_USER=<nome progetto>_user
DB_USERNAME_USER=marco
DB_PASSWORD_USER=marco
```

```bash
# .env.testing (test) - SOLO suffisso _test ai database del .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_data_test
DB_USERNAME=marco
DB_PASSWORD=marco

DB_DATABASE_USER=<nome progetto>_user_test
DB_USERNAME_USER=marco
DB_PASSWORD_USER=marco
```

### ❌ MAI FARE QUESTO (ERRORI GRAVI)
```bash
# ❌ SBAGLIATO - Inventare database che NON esistono nel .env
NOTIFY_DB_DATABASE=<nome progetto>_data_test
GEO_DB_DATABASE=<nome progetto>_data_test
MEDIA_DB_DATABASE=<nome progetto>_data_test

# ❌ SBAGLIATO - Cambiare struttura connessioni
DB_CONNECTION=user

# ❌ SBAGLIATO - Usare database diversi da quelli nel .env
DB_DATABASE=<nome progetto>_notify_test
```

### ❌ REGOLA CRITICA: config/database.php

**NON aggiungere mai connessioni separate per modulo nel database.php principale!**

Le connessioni per i moduli (notify, geo, media, etc.) vengono create **automaticamente** dal `TenantServiceProvider`.

```php
// ❌ SBAGLIATO - Non fare mai questo nel database.php
'notify' => [
    'driver' => 'mysql',
    'database' => env('NOTIFY_DB_DATABASE', '<nome progetto>_notify_test'),
    ...
],
'geo' => [
    'driver' => 'mysql',
    'database' => env('GEO_DB_DATABASE', '<nome progetto>_geo_test'),
    ...
],

// ✅ CORRETTO - Solo connessioni base + user
// Le connessioni modulo sono create automaticamente da TenantServiceProvider
```

## Regole Assolute

### 1. ❌ VIETATO: SQLite per Test
```php
// ❌ ASSOLUTAMENTE VIETATO - MAI FARE QUESTO
config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.driver' => 'sqlite']);
config(['database.connections.sqlite.database' => ':memory:']);
$this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
$dbName = 'file:memdb_test_'.Str::random(10).'?mode=memory&cache=shared';
```

### 2. ✅ OBBLIGATORIO: MySQL con Suffisso "_test"
```php
// ✅ CORRETTO - Usa sempre MySQL da .env.testing
// Il file .env.testing definisce:
// DB_CONNECTION=mysql
// DB_DATABASE=<nome progetto>_data_test  (suffisso "_test" obbligatorio)
// DB_HOST=127.0.0.1
// DB_PORT=3306

// I test DEVONO rispettare .env.testing - NON forzare configurazioni
// NON sovrascrivere mai la configurazione database nei TestCase
```

### 3. Pattern Database Test
```bash
# Schema: {nome_database_produzione}_test
PRODUZIONE: <nome progetto>_data    → TEST: <nome progetto>_data_test
PRODUZIONE: <nome progetto>_user    → TEST: <nome progetto>_user_test

# Pattern: {nome}_test - SEMPRE e SOLO _test
```

### 4. ❌ Vietato: Logica di connessione dentro i Model

```php
// ❌ SBAGLIATO - Non mettere mai env() / app()->environment() nei Model
class Activity extends SpatieActivity
{
    // ❌ Cambiare connessione in base all'ambiente rompe TenantServiceProvider
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (app()->environment('testing')) {
            $this->connection = config('database.default');
        }
    }
}

// ✅ CORRETTO - La connessione si configura nei file di config/env
// config/activitylog.php + ACTIVITY_LOGGER_DB_CONNECTION in phpunit.xml / .env(.testing)
```

## Configurazione .env.testing

```env
# ✅ CORRETTO - MySQL con suffisso "_test"
APP_ENV=testing
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>_data_test          # Suffisso "_test" obbligatorio
DB_USERNAME=marco
DB_PASSWORD=marco

# ❌ VIETATO - Commentato per evitare tentazione
# DB_CONNECTION=sqlite
# DB_DATABASE=:memory:
```

## TestCase Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for ModuleName module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped dynamically by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * MUST include every connection used by this module's models.
     * Even though module connections point to the same MySQL server,
     * they are SEPARATE PDO handles with INDEPENDENT transaction scopes.
     * Without listing the module's connection, writes are NEVER rolled back.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = [
        'mysql',
        '{module_snake}',  // MUST match $connection in module's models
        'user',            // Include if tests use User models
    ];

    // NO setUp() with migrations - NOT NEEDED
    // Run migrations manually BEFORE running tests:
    // php artisan migrate --env=testing
}
```

> **NOTA**: Prima di lanciare i test, eseguire manualmente:
> ```bash
> php artisan migrate --env=testing
> ```
> Questo crea tutte le tabelle una volta sola. `DatabaseTransactions` gestisce il rollback tra i test.

## CreatesApplication - Caricamento .env.testing Obbligatorio

**Problema**: Laravel può caricare `.env` invece di `.env.testing` a seconda dell'ordine di bootstrap. Se `env('DB_DATABASE')` restituisce il valore di produzione, `TenantServiceProvider` crea le connessioni modulo (activity, user, ecc.) puntando al DB di produzione. I test falliscono con `Table '<nome progetto>_data.activity_log' doesn't exist` perché cercano nel DB sbagliato.

**Soluzione**: Il trait `CreatesApplication` (Modules/Xot/tests/CreatesApplication.php) carica esplicitamente `.env.testing` PRIMA del bootstrap dell'app:

```php
// CRITICAL: Load .env.testing BEFORE app bootstrap
$envTesting = $basePath.'/.env.testing';
if (file_exists($envTesting)) {
    $dotenv = \Dotenv\Dotenv::createImmutable($basePath, '.env.testing', true);
    $dotenv->safeLoad();
}
```

**Backup**: `phpunit.xml` include anche `DB_DATABASE` e `DB_DATABASE_USER` come fallback.

Vedi [memoria env-testing-creates-application](../../../../../.cursor/memories/env-testing-creates-application.md).

## ❌ TestCase Pattern VIETATO

```php
// ❌ ASSOLUTAMENTE VIETATO - MAI FARE QUESTO
protected function setUp(): void
{
    parent::setUp();

    // ❌ VIETATO: migrate:fresh - ridondante
    $this->artisan('migrate:fresh', ['--force' => true]);

    // ❌ VIETATO: --force non necessario nei test
    $this->artisan('module:migrate', ['--force' => true]);

    // ❌ VIETATO: Controllo if ridondante
    if (! self::$migrated) {
        $this->artisan('module:migrate');
        self::$migrated = true;
    }

    // ❌ VIETATO: Forzare SQLite
    config(['database.default' => 'sqlite']);
    config(['database.connections.sqlite.driver' => 'sqlite']);
    config(['database.connections.sqlite.database' => ':memory:']);

    // ❌ VIETATO: Sovrascrivere connessioni con SQLite
    foreach ($connections as $conn) {
        $this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
        $this->app['config']->set("database.connections.{$conn}.database", ':memory:');
    }
}
```

## Motivazione

1. **Semplicità**: Una sola chiamata a `module:migrate`
2. **No force**: Laravel gestisce automaticamente i test
3. **No if**: Ogni test esegue le migrations - DatabaseTransactions gestisce il rollback
4. **Coerenza**: Stesso dialetto SQL in test e produzione
5. **Affidabilità**: Test realistici che predicono comportamento produzione
6. **Fonte Unica di Verità**: `.env.testing` definisce tutto, non sovrascrivere

## Checklist per TestCase

- [ ] TestCase NON usa `migrate:fresh`
- [ ] TestCase NON usa `--force`
- [ ] TestCase NON usa `if (! self::$migrated)`
- [ ] TestCase NON usa `$this->artisan('module:migrate')` nel setUp()
- [ ] TestCase usa `$connectionsToTransact` con la connessione del modulo (OBBLIGATORIO)
- [ ] TestCase NON forza SQLite
- [ ] TestCase NON sovrascrive configurazione database
- [ ] TestCase rispetta `.env.testing`
- [ ] TestCase ha solo `CreatesApplication` e `DatabaseTransactions` come trait
- [ ] Migrazioni eseguite manualmente PRIMA di lanciare i test: `php artisan migrate --env=testing`

## Riferimenti

- [Database Testing Consistency Rule](../../../../docs/operational-rules/database-testing-consistency-rule.md)
- [Testing Strategy](./testing-strategy.md)
- [MySQL Testing Only Rule](../../../../.cursor/rules/mysql-testing-only.mdc)

**Versione**: 1.0  
**
**Status**: REGOLA ASSOLUTA - NESSUNA ECCEZIONE
