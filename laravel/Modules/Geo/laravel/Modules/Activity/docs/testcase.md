# TestCase Configuration

## Overview

Activity module TestCase extends `XotBaseTestCase` which provides:
- Database transactions for test isolation
- Automatic database creation before tests
- Automatic migrations before tests
- Configurable database connections

## Database Connections

```php
protected $connectionsToTransact = ['mysql', 'activity', 'user'];
```

This ensures all connections used by Activity models are rolled back after each test.

## How It Works

XotBaseTestCase handles everything automatically:

1. **Database Creation** (`ensureTestDatabasesExist()`):
   - Called in `createApplication()` BEFORE Laravel bootstrap
   - Creates databases from env variables: DB_DATABASE, DB_DATABASE_USER, DB_DATABASE_ACTIVITY
   - Uses raw PDO to avoid Laravel dependencies at this stage

2. **Migrations**:
   - Called in `createApplication()` AFTER database creation
   - Uses `module:migrate` to run migrations for Xot, User, Activity modules
   - Uses `--env=testing` to use .env.testing configuration
   - Runs ONLY ONCE per test process (static $migrated flag)

3. **Test Isolation**:
   - Uses `DatabaseTransactions` trait for automatic rollback
   - Each test is independent and idempotent

## Providers

```php
protected function getPackageProviders($app): array
{
    return [
        \Modules\Xot\Providers\XotServiceProvider::class,
        \Modules\User\Providers\UserServiceProvider::class,
        \Modules\Activity\Providers\ActivityServiceProvider::class,
    ];
}
```

## Running Tests

```bash
# Just run tests - everything is automatic!
./vendor/bin/pest --testsuite=Activity

# Or with coverage
./vendor/bin/pest --testsuite=Activity --coverage
```

## Migration Issues

If you encounter migration issues:
1. Drop and recreate the test database manually:
   ```bash
   mysql -u user -p -e "DROP DATABASE IF EXISTS <nome progetto>_data_test; CREATE DATABASE <nome progetto>_data_test;"
   ```
2. Run migrations manually to see errors:
   ```bash
   php artisan module:migrate Activity --env=testing
   ```
