# TestCase setUpBeforeClass() Rule

## CRITICAL RULE: Use setUpBeforeClass() with ONLY module:migrate

The TestCase `setUp()` method must NOT contain migration commands. Use `setUpBeforeClass()` static method to run migrations ONCE per test class.

## ❌ WRONG PATTERN (NEVER DO THIS!)

```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO - migrate:fresh è INUTILE
    $this->artisan('migrate:fresh', ['--force' => true]);

    // ❌ SBAGLIATO - --force è INUTILE nei test
    $this->artisan('module:migrate', ['--force' => true]);

    // ❌ SBAGLIATO - DUPLICAZIONE! module:migrate fa tutto
    // migrate:fresh + module:migrate = doppio lavoro
}
```

## ❌ ALSO WRONG (with if check)

```php
protected static bool $migrated = false;

protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO - setUp() viene eseguito per OGNI test
    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

**Why this is wrong:**
- `setUp()` runs for EVERY test method in the class
- The `if` check only prevents re-running within the same test run
- `migrate:fresh` is unnecessary - `module:migrate` handles all migrations
- `--force` is unnecessary in testing environment
- Duplicates work that `module:migrate` already does

## ✅ CORRECT PATTERN

```php
protected static bool $migrated = false;

protected function setUp(): void
{
    parent::setUp();

    config(['xra.pub_theme' => 'Meetup']);
    config(['xra.main_module' => 'User']);

    \Modules\Xot\Datas\XotData::make()->update([
        'pub_theme' => 'Meetup',
        'main_module' => 'User',
    ]);
}

public static function setUpBeforeClass(): void
{
    parent::setUpBeforeClass();

    // ✅ CORRETTO - Eseguito SOLO UNA VOLTA per classe di test
    if (! self::$migrated) {
        Artisan::call('module:migrate');
        self::$migrated = true;
    }
}
```

## Why setUpBeforeClass()?

### 1. Runs ONCE per test class
- `setUp()`: Runs BEFORE EVERY test method
- `setUpBeforeClass()`: Runs ONCE before ALL tests in the class

### 2. Performance optimization
- Running migrations once per test class instead of once per test
- Saves significant time for test suites with many tests

### 3. Isolation
- `DatabaseTransactions` trait ensures each test runs in a transaction
- After each test, transaction is rolled back
- Database remains clean for next test

## Why ONLY module:migrate?

### module:migrate handles EVERYTHING

```bash
php artisan module:migrate
```

This command:
1. Runs core Laravel migrations (from database/migrations/)
2. Runs migrations for ALL modules (notify, geo, media, job, etc.)
3. Automatically discovers and runs module migrations
4. No need for separate `migrate:fresh` or `migrate` commands

### migrate:fresh is WRONG in tests

```bash
php artisan migrate:fresh
```

This command:
1. DROPS all tables
2. RECREATES database schema
3. Unnecessary in tests - `module:migrate` already creates tables
4. Dangerous if tests fail midway

### --force is WRONG in tests

```bash
php artisan migrate --force
```

This flag:
1. Forces migration in production
2. Completely unnecessary in testing environment
3. Tests should never be run in production database

## Complete TestCase Example

```php
<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Gdpr module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped to mysql by CreatesApplication trait.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
        'user',
        'gdpr',
    ];

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Configure theme and module
        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Run migrations ONCE per test class
        if (! self::$migrated) {
            Artisan::call('module:migrate');
            self::$migrated = true;
        }
    }

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            GdprServiceProvider::class,
        ];
    }
}
```

## Key Points

### ✅ DO:
- Use `setUpBeforeClass()` static method for migrations
- Use ONLY `module:migrate` command
- Use `DatabaseTransactions` trait for test isolation
- Use `$this->artisan()` in `setUp()` for per-test setup
- Use `Artisan::call()` in `setUpBeforeClass()` for one-time setup

### ❌ DON'T:
- Use `migrate:fresh` in tests
- Use `--force` flag in tests
- Run migrations in `setUp()` (runs for every test)
- Duplicate `migrate` + `module:migrate`
- Use `RefreshDatabase` trait (violates Laraxot rules)

## Test Flow

1. **Test Suite Starts**
2. **First Test Class Loads**
   - `setUpBeforeClass()` runs → migrations execute → `$migrated = true`
   - `setUp()` runs → configure theme/module
   - Test 1 runs → in transaction → commits/rolls back
   - `setUp()` runs → configure theme/module
   - Test 2 runs → in transaction → commits/rolls back
   - ... all tests in class run
3. **Second Test Class Loads**
   - `setUpBeforeClass()` runs → migrations skipped (`$migrated = true`)
   - Tests run...
4. **Test Suite Ends**

## Summary

**ONE SIMPLE RULE:**

> Use `setUpBeforeClass()` static method with ONLY `module:migrate` (no --force, no migrate:fresh). The `$migrated` static variable prevents re-running migrations for the same test class. `DatabaseTransactions` trait ensures test isolation by rolling back after each test.

**Memory Aid:**

> setUpBeforeClass() = module:migrate (ONCE per class)
> setUp() = theme/module config (per test)
> DatabaseTransactions = isolation (roll back after each test)
> NEVER use migrate:fresh or --force in tests!

## References

- [Environment Development vs Testing Rules](./environment-development-vs-testing-rules.md)
- [Database Testing Configuration](./database-testing-configuration.md)
- [Database PHP Connection Rule](./database-php-connection-rule.md)