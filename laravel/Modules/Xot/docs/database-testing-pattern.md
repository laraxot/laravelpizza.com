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

Tests should use a single `php artisan migrate` command to apply all migrations (app and modules).

```php
// From TestCase::setUp() - CORRECTED
$this->artisan('migrate');
```

- `migrate` - Runs migrations from `database/migrations/` and all registered module migrations.


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

    // The $migrated flag is no longer needed
    // protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Migrations should run only once per test execution
        // and Laravel's default 'migrate' command is sufficient.
        $this->artisan('migrate');
    }
}
```

### Key Points (Updated)

1.  **No Static `$migrated` flag**: The static `$migrated` flag is no longer used, ensuring `setUp()` method is clean.
2.  **Single `migrate` command**: `php artisan migrate` is called once per test suite, applying all necessary migrations.
3.  **Transaction rollback**: Each test runs in a transaction that rolls back automatically.
4.  **Multi-connection support**: Tests can specify multiple connections to transaction (this part is still valid).

```php
protected $connectionsToTransact = [
    'mysql',
    'user',
    'tenant',
    // ... all module connections
];
```

## Multi-Database Connections

The project uses multiple logical connections which all resolve to the main `DB_DATABASE` (with `_test` suffix for testing). This is handled dynamically by `TenantServiceProvider`.

**CRITICAL**: NEVER define separate database connections for each module (e.g., `NOTIFY_DB_DATABASE`, `GEO_DB_DATABASE`) in `config/database.php` or `.env.testing`. All modules share the same underlying database instance for tests.

Tests must include all connections that utilize `DatabaseTransactions` to ensure proper rollback:

```php
// From Modules/User/tests/TestCase.php
protected $connectionsToTransact = [
    'mysql',      // Main connection
    'user',       // User module
    'tenant',     // Tenant module
    'activity',   // Activity module
    'cms',        // CMS module
    // ... all module connections
];
```

## Benefits of This Pattern

1. **Performance**: Migrations run once instead of before each test
2. **Reliability**: Full schema ensures foreign key constraints work
3. **Speed**: Transaction rollback is faster than migration
4. **Consistency**: All tests start from the same known state
