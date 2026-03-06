# Pest Testing Setup for Laraxot Modular Architecture

This document describes how to configure and run tests using Pest PHP in the Laraxot modular Laravel 12 architecture.

## Prerequisites

- PHP 8.3+
- Pest PHP 3.x
- Laravel 12
- MySQL (same database type as production)

## Quick Start

```bash
cd laravel
./vendor/bin/pest
```

## Configuration

### Environment Setup

Use `.env.testing` for test configuration. It should mirror your production database type (MySQL) to avoid compatibility issues.

```env
APP_ENV=testing
APP_KEY=base64:Rf86qwCSdM9dffF9QKNWPjc9GoLUiUksLsaiCba8n6M=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
<<<<<<< .merge_file_N748rE
DB_DATABASE=healthcare_app_data_test
=======
DB_DATABASE=ptvx_data_test
>>>>>>> .merge_file_u4Ych8
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_DRIVER=array
QUEUE_CONNECTION=sync
MAIL_MAILER=log
SESSION_DRIVER=array
```

### phpunit.xml Configuration

The `phpunit.xml` includes module tests automatically:

```xml
<testsuites>
    <testsuite name="Application">
        <directory suffix="Test.php">tests</directory>
        <directory suffix="Test.php">Modules/*/tests</directory>
    </testsuite>
</testsuites>
```

### composer.json autoload-dev

Root `composer.json` should have:

```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    }
}
```

**Note:** Do NOT add `"Modules\\": "Modules/"` to autoload-dev. The composer-merge-plugin handles module autoloading automatically.

## Module Test Structure

Each module should have:

```
Modules/{ModuleName}/
├── tests/
│   ├── Pest.php          # Module-specific Pest configuration
│   ├── TestCase.php      # Module TestCase extending base
│   ├── Feature/          # Integration tests
│   └── Unit/             # Unit tests
```

### Module Pest.php

```php
<?php

declare(strict_types=1);

use Modules\{ModuleName}\Tests\TestCase;

pest()->extend(TestCase::class)->in('Feature', 'Unit');

// Custom expectations
expect()->extend('toBe{ModelName}', fn () => $this->toBeInstanceOf({Model}::class));

// Helper functions
function create{Model}(array $attributes = []): {Model}
{
    return {Model}::factory()->create($attributes);
}
```

### Module TestCase.php

```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure module connection is configured
        if (! config()->has('database.connections.{module}')) {
            config(['database.connections.{module}' => config('database.connections.mysql')]);
        }
    }
}
```

## Important Rules

### Never Use `migrate:fresh` in Tests (CRITICAL)

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
`migrate:fresh` **drops ALL tables** in the target database. In a shared test database (like `<nome progetto>_data_test`) this destroys data for ALL modules and causes cascading failures across the entire test suite.
=======
`migrate:fresh` **drops ALL tables** in the target database. In a shared test database (like `laravelpizza_data_test`) this destroys data for ALL modules and causes cascading failures across the entire test suite.
>>>>>>> a038b0f2 (.)
=======
`migrate:fresh` **drops ALL tables** in the target database. In a shared test database (like `<nome progetto>_data_test`) this destroys data for ALL modules and causes cascading failures across the entire test suite.
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
`migrate:fresh` **drops ALL tables** in the target database. In a shared test database (like `laravelpizza_data_test`) this destroys data for ALL modules and causes cascading failures across the entire test suite.
>>>>>>> a038b0f2 (.)
=======
`migrate:fresh` **drops ALL tables** in the target database. In a shared test database (like `<nome progetto>_data_test`) this destroys data for ALL modules and causes cascading failures across the entire test suite.
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)

**Rule**: Never call `artisan('migrate:fresh', ...)` inside a test. If a test does this, mark it with `$this->markTestSkipped(...)`.

**To set up test DB**: Run once externally before the suite:
```bash
php artisan migrate --env=testing --force
```

**If the DB is corrupted** (as a one-time emergency fix only):
```bash
php artisan migrate:fresh --env=testing --force
```
Then never repeat it again in the suite.

### Never Use RefreshDatabase

The project uses `DatabaseTransactions` instead of `RefreshDatabase` because:

1. **Performance**: 17 modules with hundreds of migrations make RefreshDatabase very slow
2. **Architecture**: XotBaseMigration has complex logic that RefreshDatabase bypasses
3. **Solution**: Use `DatabaseTransactions` trait and a dedicated test database

### Never Add Modules to Root autoload-dev

The composer-merge-plugin handles module autoloading from individual `Modules/*/composer.json` files.

### Test Fixes vs Code Fixes

When tests fail:

1. **If the site works**: The test is wrong - fix the test
2. **If the test references non-existent classes**: Skip or remove the test
3. **If the test has wrong assertions**: Fix the assertions to match actual behavior

## Running Tests

```bash
# All tests
./vendor/bin/pest

# Specific module
./vendor/bin/pest Modules/Activity/tests

# Specific test file
./vendor/bin/pest Modules/Activity/tests/Feature/ActivityTest.php

# Filter by test name
./vendor/bin/pest --filter "can create activity"

# With coverage
./vendor/bin/pest --coverage

# Parallel execution
./vendor/bin/pest --parallel
```

## Code Quality Checks

Run these before committing:

```bash
# Format code
./vendor/bin/pint --dirty

# Static analysis
./vendor/bin/phpstan analyse --level=10

# Code insights
./vendor/bin/phpinsights

# Code quality
./vendor/bin/phpmd Modules/{ModuleName} text cleancode,codesize,controversial,design,naming,unusedcode
```

## CreatesApplication Trait

Located in `Modules/Xot/tests/CreatesApplication.php`:

```php
trait CreatesApplication
{
    public function createApplication(): Application
    {
        $basePath = realpath(__DIR__.'/../../../');
        $_ENV['APP_BASE_PATH'] = $basePath;

        $app = require $basePath.'/bootstrap/app.php';
        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn () => $basePath.'/public_html');
        $app->bind('path.storage', fn () => $basePath.'/storage');

        $app->make(Kernel::class)->bootstrap();
        $app->boot();

        return $app;
    }
}
```

## Common Issues and Solutions

### BindingResolutionException: Target class [config] does not exist

**Cause**: TestCase is not properly bootstrapping the Laravel application.

**Solution**: Ensure the TestCase uses `CreatesApplication` trait and doesn't override `createApplication()` incorrectly.

### Class "X" not found

**Cause**: Test references a class that doesn't exist in the codebase.

**Solution**: Skip the test or remove it. The site works, so the test is testing non-existent functionality.

### QueryException: Base table or view not found

**Cause**: Database table doesn't exist in test database.

**Solution**:
1. Run migrations: `php artisan module:migrate {Module} --force --env=testing`
2. Or skip the test if it tests database-specific behavior not needed

### Tests Running Too Slow

**Solutions**:
1. Use in-memory SQLite for unit tests
2. Use `DatabaseTransactions` instead of `RefreshDatabase`
3. Run tests in parallel: `./vendor/bin/pest --parallel`

## References

- [Laravel 12 Testing](https://laravel.com/docs/12.x/testing)
- [Pest PHP Documentation](https://pestphp.com/docs)
- [Laravel Modules Testing](https://laravelmodules.com/docs/12/advanced/tests)
- [Composer Merge Plugin](https://github.com/wikimedia/composer-merge-plugin)
