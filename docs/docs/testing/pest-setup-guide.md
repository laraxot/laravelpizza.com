# Pest Testing Setup Guide

## Overview

This guide documents how to run Pest tests from the `laravel/` directory and achieve 100% test coverage across all modules following the Laraxot methodology.

## Key Resources Studied

- [Laravel 12.x Testing Documentation](https://laravel.com/docs/12.x/testing)
- [Pest PHP Installation](https://pestphp.com/docs/installation)
- [Composer Merge Plugin](https://github.com/wikimedia/composer-merge-plugin)
- [Laravel Modules Testing](https://laravelmodules.com/docs/12/advanced/tests)

## Critical Rules

### 1. NEVER Use `RefreshDatabase` Trait

**WHY**: The `RefreshDatabase` trait drops and recreates the entire database schema for each test, which:
- Breaks module isolation (modules have separate databases)
- Causes data loss in multi-database setups
- Violates the principle of test independence
- Is incompatible with the Laraxot multi-database architecture

**INSTEAD**: Use transactions, factories, and proper test cleanup in `setUp()` and `tearDown()` methods.

### 2. Composer Autoload-Dev Configuration

According to [Laravel Modules documentation](https://laravelmodules.com/docs/12/getting-started/installation-and-setup), the `composer.json` autoload-dev section **MUST NOT** include `Modules/` namespace.

**WRONG**:
```json
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/",
        "Modules\\": "Modules/"
    }
}
```

**CORRECT**:
```json
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
    }
}
```

**WHY**: The `wikimedia/composer-merge-plugin` handles module autoloading by merging each module's `composer.json`. Adding `Modules/` to autoload-dev creates conflicts and duplicate class loading.

### 3. Environment Configuration

All tests **MUST** use `laravel/.env.testing` for configuration.

**Key Requirements**:
- Database type in `.env.testing` MUST match `.env` (avoid dialect issues)
- Each module should have its own test database (e.g., `laravelpizza_user_test`)
- Use `array` driver for cache and sessions in testing
- Use `sync` queue connection for immediate execution

### 4. Test Format: Pest Only

All tests **MUST** be written in Pest format. If PHPUnit tests are found, they **MUST** be converted to Pest.

**Example Pest Test**:
```php
<?php

use Modules\User\Models\User;

uses(Tests\TestCase::class);

test('can create user', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->email)->not->toBeNull();
});
```

### 5. Test Philosophy

**The Site Works**: If a test fails, it's because the test is wrong, NOT the application code.

When a test fails:
1. Verify the application behavior manually
2. If the application works correctly, fix the test
3. Do NOT modify application code to make tests pass
4. Update test expectations to match actual working behavior

## Running Tests

### Run All Tests
```bash
cd laravel
./vendor/bin/pest
```

### Run Tests for Specific Module
```bash
./vendor/bin/pest --filter='User'
```

### Run Single Test File
```bash
./vendor/bin/pest Modules/User/tests/Feature/UserAuthenticationTest.php
```

### Run with Coverage
```bash
./vendor/bin/pest --coverage
```

### Run with Coverage Minimum Threshold
```bash
./vendor/bin/pest --coverage --min=100
```

## Configuration Files

### phpunit.xml

Located at `laravel/phpunit.xml`, this file configures:
- Test suites (Unit, Feature, Modules)
- Coverage paths and exclusions
- Environment variables for testing

**Key Configuration**:
```xml
<testsuites>
    <testsuite name="Modules">
        <directory suffix="Test.php">./Modules/*/tests/Feature</directory>
        <directory suffix="Test.php">./Modules/*/tests/Unit</directory>
    </testsuite>
</testsuites>
```

### Pest.php Files

Each module should have its own `Pest.php` configuration file at `Modules/{ModuleName}/tests/Pest.php`:

```php
<?php

use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');
```

## Composer Merge Plugin

The project uses `wikimedia/composer-merge-plugin` to merge module `composer.json` files.

**Configuration in main `composer.json`**:
```json
"extra": {
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"
        ]
    }
}
```

This allows each module to define its own dependencies, autoloading, and test configuration.

## Test Structure

### Module Test Organization
```
Modules/{ModuleName}/
├── tests/
│   ├── Pest.php
│   ├── Feature/
│   │   └── *Test.php
│   └── Unit/
│       └── *Test.php
```

### Test Naming Conventions
- Feature tests: Test full user workflows and integrations
- Unit tests: Test individual classes and methods in isolation
- File naming: `{ClassName}Test.php` or `{Feature}Test.php`
- Test naming: Use descriptive test names with `test()` function

## Quality Assurance

After modifying any test file, **ALWAYS** run:

```bash
# PHPStan Level 10
./vendor/bin/phpstan analyse Modules/{ModuleName}/tests

# PHPMD
./vendor/bin/phpmd Modules/{ModuleName}/tests text cleancode,codesize,controversial,design,naming,unusedcode

# PHPInsights
./vendor/bin/phpinsights analyse Modules/{ModuleName}/tests
```

## Achieving 100% Coverage

### Strategy
1. Work module by module
2. Identify untested code paths
3. Write tests for missing coverage
4. Verify with `--coverage` flag
5. Ensure all tests pass static analysis

### Coverage Report
```bash
./vendor/bin/pest --coverage --min=100
```

This will fail if coverage is below 100%, ensuring quality standards.

## Common Patterns

### Using Factories
```php
test('can create user with factory', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);
    
    expect($user->email)->toBe('test@example.com');
});
```

### Testing Relationships
```php
test('user has teams', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    expect($user->teams)->toHaveCount(1)
        ->and($user->teams->first()->id)->toBe($team->id);
});
```

### Testing Filament Resources
```php
test('can render user resource list', function () {
    $this->actingAs(User::factory()->create());
    
    Livewire::test(ListUsers::class)
        ->assertSuccessful();
});
```

## Troubleshooting

### Issue: Tests not found
**Solution**: Run `composer dump-autoload` and ensure `Pest.php` exists in module tests directory.

### Issue: Database errors
**Solution**: Verify `.env.testing` has correct database configuration and databases exist.

### Issue: Class not found
**Solution**: Ensure module `composer.json` has correct autoloading and run `composer dump-autoload`.

### Issue: RefreshDatabase errors
**Solution**: Remove `RefreshDatabase` trait and use transactions or manual cleanup.

## Git Workflow

After making changes:
```bash
# Run tests
./vendor/bin/pest

# Run static analysis
./vendor/bin/phpstan analyse Modules

# Commit changes
git add .
git commit -m "test: improve coverage for {module}"
git push
```

## Next Steps

1. Fix `composer.json` autoload-dev section
2. Run `./vendor/bin/pest` to identify failing tests
3. Convert PHPUnit tests to Pest
4. Fix failing tests (modify tests, not app code)
5. Achieve 100% coverage module by module
6. Document findings in module-specific docs

## References

- [Pest Documentation](https://pestphp.com/docs)
- [Laravel Testing](https://laravel.com/docs/12.x/testing)
- [Laravel Modules](https://laravelmodules.com/docs/12/advanced/tests)
- [Composer Merge Plugin](https://github.com/wikimedia/composer-merge-plugin)
