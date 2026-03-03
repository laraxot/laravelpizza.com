# Testing Architecture and Pest Setup

## Overview
This document describes the testing architecture in the Laraxot framework using Pest PHP testing framework.

## XotBaseTestCase — Regola fondamentale (CRITICAL)

**MAI estendere `Illuminate\Foundation\Testing\TestCase` direttamente in qualsiasi modulo.**

Ogni `Modules/*/tests/TestCase.php` DEVE estendere `Modules\Xot\Tests\XotBaseTestCase`.

### Gerarchia

```
Illuminate\Foundation\Testing\TestCase
    ↓
XotBaseTestCase  (Modules/Xot/tests/XotBaseTestCase.php)
    ├── use CreatesApplication
    ├── getPackageProviders() → [XotServiceProvider]
    ├── setUp() → bind translator
    └── helpers: generateUniqueEmail(), getUserClass(), createTestUser()
        ↓
    Module TestCase  (Modules/{Name}/tests/TestCase.php)
        ├── [opzionale] use DatabaseTransactions
        ├── [opzionale] $connectionsToTransact
        └── getPackageProviders() → [...parent, ModuleServiceProvider]
            ↓
        Test file (Pest)
```

### Pattern corretto per ogni modulo

```php
// Modules/Gdpr/tests/TestCase.php
declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

abstract class TestCase extends XotBaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            GdprServiceProvider::class,
        ];
    }
}
```

### Perche' (filosofia Zen)

- **DRY**: un unico punto di bootstrap → nessuna duplicazione
- **KISS**: ogni modulo aggiunge SOLO i propri ServiceProvider
- **Laraxot**: coerenza → tutti i test usano la stessa infrastruttura
- **Manutenibilita'**: cambio in XotBaseTestCase si propaga a tutti automaticamente

### Quando aggiungere DatabaseTransactions

Solo se il modulo interagisce con database reale durante i test:

```php
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    protected array $connectionsToTransact = ['mysql', 'user'];
    // ...
}
```

## Testing Philosophy

### DRY + KISS + SOLID + Robust Principles
- **DRY (Don't Repeat Yourself)**: Avoid duplicate test code by creating reusable test helpers
- **KISS (Keep It Simple, Stupid)**: Write simple, clear tests that are easy to understand
- **SOLID**: Follow SOLID principles even in test code
- **Robust**: Write tests that are resilient to changes and provide reliable feedback

## Pest Testing Framework

### Why Pest?
- More expressive and concise than traditional PHPUnit
- Functional testing style reduces boilerplate
- Better integration with modern PHP features
- Excellent for BDD (Behavior Driven Development)

### Setup and Configuration
The project uses the Wikimedia/composer-merge-plugin to merge module-specific composer.json files. The main composer.json is configured properly with:
```json
"autoload-dev": {
    "psr-4": {
       "Tests\\": "tests/"
    }
}
```

### Test Structure
```
Modules/
├── {Module}/
│   ├── tests/
│   │   ├── Unit/
│   │   ├── Feature/
│   │   └── Pest.php (module-specific bootstrap)
```

## Database Testing Considerations

### Critical Rule: No RefreshDatabase Trait
**NEVER use `Illuminate\Foundation\Testing\RefreshDatabase`**

**Reasoning:**
1. **Performance**: `RefreshDatabase` recreates the database schema for each test class, which is extremely slow in a modular architecture with many migrations
2. **Reliability**: In a multi-module system, the schema recreation process may not properly handle cross-module relationships
3. **Consistency**: Can cause issues when running tests in parallel or with different module load orders

### Alternative Approaches:
1. **DatabaseTransactions**: Wraps each test in a database transaction that gets rolled back
2. **Custom Setup/Teardown**: Manual setup and cleanup methods for specific test requirements
3. **DatabaseMigrations**: Runs migrations once before tests (faster than RefreshDatabase)

## Environment Configuration

### .env.testing
- Should use the same database type as .env to avoid dialect differences
- Configure appropriate test database credentials
- Ensure cache and queue settings are suitable for testing

## Test Conversion from PHPUnit to Pest

### Before (PHPUnit):
```php
<?php

namespace Modules\User\Tests\Unit;

use Tests\TestCase;
use Modules\User\Models\User;

class UserTest extends TestCase
{
    public function test_user_creation(): void
    {
        $user = User::factory()->create();
        $this->assertNotNull($user->id);
    }
}
```

### After (Pest):
```php
<?php

use Modules\User\Models\User;

test('user creation', function () {
    $user = User::factory()->create();
    expect($user->id)->not->toBeNull();
});
```

## Coverage Goals

### Module-Level Coverage
- **Target**: 100% coverage for each module
- **Approach**: Focus on testing the module's specific functionality
- **Integration**: Test module interactions but don't duplicate tests across modules

### Testing Tools Integration
Each test modification should be validated with:
- PHPStan (type safety)
- PHPMD (code quality)
- PHPInsights (architecture quality)

## Module-Specific Testing Patterns

### XotBase Classes Testing
Since Xot provides base classes for the entire system, its tests are critical:
- Test base functionality thoroughly
- Ensure backward compatibility
- Test abstract method implementations

### Filament Resource Testing
- Test form schemas
- Test table columns
- Test page functionality
- Test authorization

## Best Practices

1. **Use Descriptive Test Names**: Make test names clearly describe the behavior being tested
2. **One Assertion Per Test**: When possible, keep tests focused on a single behavior
3. **Factories Over Manual Creation**: Use Laravel factories for test data
4. **Group Related Tests**: Use `describe()` blocks for logical grouping
5. **Avoid Test Dependencies**: Each test should be independent

## Running Tests

### All Tests
```bash
./vendor/bin/pest
```

### Module-Specific Tests
```bash
./vendor/bin/pest Modules/User/
```

### With Coverage
```bash
./vendor/bin/pest --coverage
```

### With Parallel Execution
```bash
./vendor/bin/pest --parallel
```

## Troubleshooting

### Common Issues:
1. **Class Not Found**: Verify composer autoload configuration
2. **Database Issues**: Check that you're not using RefreshDatabase trait
3. **Module Loading**: Ensure module is enabled in modules_statuses.json
4. **Configuration Cache**: Clear with `php artisan config:clear`

### Performance Tips:
1. Use `--parallel` flag for faster execution
2. Avoid RefreshDatabase trait
3. Use `DatabaseTransactions` for database tests
4. Organize tests efficiently with `beforeEach`/`afterEach` hooks