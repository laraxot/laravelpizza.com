# Database Testing Pattern

## Overview

This document explains the database setup pattern used in module tests and why migrations are run generically without specifying a module.

## Why Generic `php artisan migrate`?

### The Reason

Tests use **generic migration commands** instead of module-specific migrations because:

1. **Cross-module relationships**: Models often have relationships spanning multiple modules (e.g., `User` module relates to `Activity`, `Media`, `Tenant`)
2. **Full schema required**: Tests need the complete database schema to function properly
3. **Test isolation**: Using `DatabaseTransactions` provides isolation between tests while sharing the same migrated schema

### What Runs (Corrected)

Migrations are run ONCE externally before running tests:

```bash
php artisan migrate --env=testing
```

- This applies all migrations (app and modules) to the _test databases.
- NEVER run migrations inside setUp() - it runs before EVERY test, making tests slow.
- `DatabaseTransactions` handles rollback between tests automatically.


## DatabaseTransactions vs RefreshDatabase

### Why We Use DatabaseTransactions

| Aspect | RefreshDatabase | DatabaseTransactions |
|--------|-----------------|---------------------|
| Migration runs | **Before EACH test** | **Once per test suite** |
| Performance | Slower | Faster |
| Isolation | Drop & recreate | Transaction rollback |
| Use case | Isolated tests | Related test suites |

### Implementation (Corrected)

```php
// Modules/*/tests/TestCase.php
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    use CreatesApplication;

    /**
     * OBBLIGATORIO - $connectionsToTransact.
     *
     * ATTENZIONE: "stessa base dati" NON significa "stessa transazione".
     * Laravel crea un handle PDO SEPARATO per ogni connessione nominata.
     * BEGIN TRANSACTION su 'mysql' NON copre 'activity' o 'gdpr'.
     * Senza elencare la connessione del modulo, i dati NON vengono rollbackati.
     *
     * Vedere: vendor/laravel/framework/src/Illuminate/Foundation/Testing/DatabaseTransactions.php
     * Il metodo connectionsToTransact() ritorna [null] se non definito = solo default connection.
     */
    protected $connectionsToTransact = [
        'mysql',
        '{module_snake}',  // DEVE corrispondere a $connection nei Model del modulo
        'user',
    ];

    // NO setUp() override - NON NECESSARIO
    // Esegui manualmente: php artisan migrate --env=testing
}
```

### Key Points (Updated)

1.  **No Static `$migrated` flag**: NEVER use - creates shared state between tests.
2.  **No migrations in setUp()**: Run externally ONCE: `php artisan migrate --env=testing`.
3.  **Transaction rollback**: Each test runs in a transaction that rolls back automatically.
4.  **$connectionsToTransact is MANDATORY**: Must list the module's own connection. "Same database" does NOT mean "same PDO handle" - each named connection is a separate PDO with independent transactions.
5.  **No config overrides**: No `config(['xra.pub_theme' => ...])`, no `XotData::make()->update()`.

```php
// Example for Activity module:
protected $connectionsToTransact = [
    'mysql',
    'activity',  // Activity models use $connection = 'activity'
    'user',
];
```

## Multi-Database Connections

The project uses multiple logical connections which all resolve to the main `DB_DATABASE` (with `_test` suffix for testing). This is handled dynamically by `TenantServiceProvider`.

**CRITICAL**: NEVER define separate database connections for each module (e.g., `NOTIFY_DB_DATABASE`, `GEO_DB_DATABASE`) in `config/database.php` or `.env.testing`. All modules share the same underlying database instance for tests.

**$connectionsToTransact is MANDATORY**: Even though all connections point to the same database, they are SEPARATE PDO handles. `DatabaseTransactions::connectionsToTransact()` returns `[null]` (only default connection) if the property is not set. Each module's TestCase MUST list `'mysql'`, the module's own connection, and `'user'` if User models are used in tests.

## Benefits of This Pattern

1. **Performance**: Migrations run once instead of before each test
2. **Reliability**: Full schema ensures foreign key constraints work
3. **Speed**: Transaction rollback is faster than migration
4. **Consistency**: All tests start from the same known state
