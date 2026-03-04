# Critical Rule: Never Use RefreshDatabase Trait

## Overview
This document explains the critical rule against using `Illuminate\Foundation\Testing\RefreshDatabase` trait in the Laraxot framework.

## The Rule
**NEVER use `use Illuminate\Foundation\Testing\RefreshDatabase;` in any test class**

## Why This Rule Exists

### 1. Performance Issues
- `RefreshDatabase` recreates the entire database schema for each test class
- In a modular architecture with many modules and migrations, this becomes extremely slow
- Each module may have its own migrations, making the refresh process exponentially complex

### 2. Architecture Compatibility
- The Laraxot framework uses a modular architecture where modules may have cross-dependencies
- RefreshDatabase may not properly handle complex relationships between modules
- Can cause issues with custom database configurations per module

### 3. Resource Intensity
- Creates unnecessary load on the database server
- Consumes more memory and processing power
- Makes parallel test execution less efficient

## Recommended Alternatives

### 1. DatabaseTransactions Trait
```php
<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('example test', function () {
    // Your test code here
    // Database changes will be rolled back after each test
});
```

### 2. DatabaseMigrations Trait
```php
<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

test('example test', function () {
    // Your test code here
    // Migrations will run once before tests
});
```

### 3. Manual Setup and Teardown
```php
<?php

test('example test', function () {
    // Manual setup
    $user = User::factory()->create();
    
    // Your test code here
    
    // Manual cleanup (if needed)
    $user->delete();
});
```

### 4. Custom Database Transaction Helper
```php
<?php

function withDatabaseTransaction(callable $callback) {
    \DB::beginTransaction();
    try {
        return $callback();
    } finally {
        \DB::rollBack();
    }
}

test('example test', function () {
    withDatabaseTransaction(function () {
        // Your test code here
    });
});
```

## Migration from Existing Code

### Before (Forbidden):
```php
<?php

namespace Modules\User\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase; // ❌ FORBIDDEN
    
    // Test methods...
}
```

### After (Correct):
```php
<?php

namespace Modules\User\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions; // ✅ ACCEPTABLE
    
    // Test methods...
}
```

### Or with Pest:
```php
<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class)->in('Feature', 'Unit');

test('example', function () {
    // Your test code here
});
```

## Testing Different Database Types

### Database Consistency
- Ensure `.env.testing` uses the same database type as `.env` (MySQL, PostgreSQL, SQLite, etc.)
- Different database dialects can cause unexpected issues
- Test with the same database engine used in development/production

## Performance Benefits

### Using DatabaseTransactions vs RefreshDatabase
- **DatabaseTransactions**: Wraps each test in a transaction that gets rolled back (fast)
- **RefreshDatabase**: Recreates the entire database schema for each test class (slow)

### Parallel Execution
- Tests using DatabaseTransactions can run more efficiently in parallel
- Reduced database contention between parallel test processes

## Common Scenarios and Solutions

### 1. Feature Tests with Database
```php
<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('user can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});
```

### 2. Unit Tests with Model Factories
```php
<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('user has posts relationship', function () {
    $user = User::factory()->hasPosts(3)->create();
    
    expect($user->posts)->toHaveCount(3);
});
```

## Verification and Quality Assurance

### After modifying any test file:
1. Run PHPStan: `./vendor/bin/phpstan analyse path/to/test/file.php`
2. Run PHPMD: `./vendor/bin/phpmd path/to/test/file.php text cleancode,codesize,design`
3. Run PHPInsights: `./vendor/bin/phpinsights analyse path/to/test/directory`

### Before committing:
1. Run the specific test: `./vendor/bin/pest path/to/test/file.php`
2. Run the module's tests: `./vendor/bin/pest Modules/ModuleName/`
3. Run all tests: `./vendor/bin/pest`

## Troubleshooting

### If you encounter database-related test failures:
1. Check if you're accidentally using RefreshDatabase
2. Verify your test database connection settings
3. Ensure modules are properly enabled for testing
4. Clear test database: `php artisan migrate:refresh --env=testing`

## Impact on Code Quality

### Following this rule contributes to:
- **Performance**: Faster test execution
- **Reliability**: Consistent test results
- **Maintainability**: Clearer test isolation patterns
- **Scalability**: Better performance as the codebase grows

## Compliance Checking

To verify compliance across the codebase:
```bash
grep -r "RefreshDatabase" Modules/ --include="*.php"
```

This should return no results (except this documentation file).

---

**Remember**: This rule is fundamental to the performance and reliability of the test suite in the Laraxot framework. Always use DatabaseTransactions or other alternatives instead of RefreshDatabase.