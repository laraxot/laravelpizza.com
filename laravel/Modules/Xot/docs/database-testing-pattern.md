# Database Testing Pattern

## Overview

This document explains the database setup pattern used in module tests and why migrations are run generically without specifying a module.

## Why Generic `php artisan migrate`?

### The Reason

Tests use **generic migration commands** instead of module-specific migrations because:

1. **Cross-module relationships**: Models often have relationships spanning multiple modules (e.g., `User` module relates to `Activity`, `Media`, `Tenant`)
2. **Full schema required**: Tests need the complete database schema to function properly
3. **Test isolation**: Using `DatabaseTransactions` provides isolation between tests while sharing the same migrated schema

### What Runs

```php
// From TestCase::setUp()
$this->artisan('migrate:fresh', ['--force' => true]);      // Main app migrations
$this->artisan('module:migrate', ['--force' => true]);       // ALL module migrations
```

- `migrate:fresh` - Runs migrations from `database/migrations/`
- `module:migrate` - Runs migrations from ALL modules (`Modules/*/database/migrations/`)

## DatabaseTransactions vs RefreshDatabase

### Why We Use DatabaseTransactions

| Aspect | RefreshDatabase | DatabaseTransactions |
|--------|-----------------|---------------------|
| Migration runs | **Before EACH test** | **Once per test suite** |
| Performance | Slower | Faster |
| Isolation | Drop & recreate | Transaction rollback |
| Use case | Isolated tests | Related test suites |

### Implementation

```php
// Modules/*/tests/TestCase.php
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    use CreatesApplication;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate:fresh', ['--force' => true]);
            $this->artisan('module:migrate', ['--force' => true]);
            self::$migrated = true;
        }
    }
}
```

### Key Points

1. **Static `$migrated` flag**: Ensures migrations run only once per test execution
2. **Transaction rollback**: Each test runs in a transaction that rolls back automatically
3. **Multi-connection support**: Tests can specify multiple connections to transaction:

```php
protected $connectionsToTransact = [
    'mysql',
    'user',
    'tenant',
    // ... all module connections
];
```

## Multi-Database Connections

The project uses multiple database connections for different modules. Tests must include all connections:

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
