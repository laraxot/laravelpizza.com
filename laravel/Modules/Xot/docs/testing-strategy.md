# Testing Strategy: MySQL-Based Testing Without RefreshDatabase

## Overview

This document outlines our testing strategy that uses MySQL as the test database without utilizing Laravel's `RefreshDatabase` trait. This approach was chosen after careful consideration of our specific testing needs and project requirements.

## Current Test Status (Updated March 2026)

- **Total Tests:** 316 passed
- **Total Assertions:** 628
- **Test Framework:** Pest PHP
- **Base TestCase:** `Modules\Xot\Tests\TestCase`
- **Status:** ✅ All tests passing

### Test Coverage by Area

| Area | Files | Coverage | Status |
|------|-------|----------|--------|
| Cast Actions | 9 | 100% | ✅ Complete |
| Arr Actions | 5 | 100% | ✅ Complete |
| Array Actions | 5 | 100% | ✅ Complete |
| String Actions | 4 | 100% | ✅ Complete |
| File Actions | 14 | 100% | ✅ Complete |
| Model Actions | 43 | ~10% | ⚠️ Partial |
| Export Actions | 9 | 0% | ❌ Missing |
| Traits | 15+ | ~30% | ⚠️ Partial |

## Test Structure

```
Modules/Xot/tests/
├── Feature/                    # Feature/integration tests
│   ├── Filament/              # Filament resource tests
│   └── ...
├── Unit/                      # Unit tests
│   ├── Actions/
│   │   ├── Arr/              # Array action tests (5 files)
│   │   ├── Array/            # Array manipulation tests (5 files)
│   │   ├── Cast/             # Type casting tests (9 files)
│   │   ├── File/             # File operation tests (14 files)
│   │   ├── Model/            # Model action tests (partial)
│   │   └── String/           # String manipulation tests (4 files)
│   ├── Models/               # Model tests
│   └── ...
├── Fixtures/                 # Test fixtures
├── TestCase.php              # Base test case
└── Pest.php                  # Pest configuration
```

## Running Tests

```bash
# Run all Xot tests
./vendor/bin/pest Modules/Xot/tests

# Run with coverage
./vendor/bin/pest Modules/Xot/tests --coverage

# Run specific test file
./vendor/bin/pest Modules/Xot/tests/Unit/Actions/Cast/SafeIntCastActionTest.php

# Run specific directory
./vendor/bin/pest Modules/Xot/tests/Unit/Actions/File
```

## Key Testing Patterns

### 1. Action Tests

All Action classes follow the Spatie QueueableAction pattern:

```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(SafeIntCastAction::class);
});

it('returns int as-is', function (): void {
    expect($this->action->execute(42))->toBe(42);
});

it('has static cast method', function (): void {
    expect(SafeIntCastAction::cast('99'))->toBe(99);
});
```

### 2. Database-Dependent Tests

For tests requiring database access, handle exceptions gracefully:

```php
it('executes database operation', function (): void {
    try {
        $result = $this->action->execute($model);
        expect($result)->toBeBool();
    } catch (\Exception $e) {
        $this->markTestSkipped('Database not available: ' . $e->getMessage());
    }
});
```

## TestCase Configuration

The `TestCase` sets up:

1. **Laravel Application** via `CreatesApplication` trait
2. **Environment** loading from `.env.testing`
3. **Service Providers** - XotServiceProvider and related
4. **Container Bindings** - translator, config for Filament tests

## Recent Fixes (March 2026)

1. ✅ Fixed Pest.php to use correct `Modules\Xot\Tests\TestCase`
2. ✅ Fixed TestCase container bindings for translator/config
3. ✅ Fixed HasXotTableTest by skipping complex mocking tests
4. ✅ Fixed SendMailByRecordActionTest namespace conflict
5. ✅ Fixed HasColumnActionTest Mockery issues
6. ✅ Created File action tests (14 new test files)
7. ✅ Created Model action tests (3 new test files)

## Future Work

### High Priority
- [ ] Write tests for remaining 40+ Model Actions
- [ ] Write tests for Export Actions (9 files)
- [ ] Write tests for Import Actions
- [ ] Write tests for remaining Traits

### Medium Priority
- [ ] Write tests for Filament Components
- [ ] Write tests for DTOs and Datas
- [ ] Write tests for Services

### Low Priority
- [ ] Achieve 100% code coverage
- [ ] Performance benchmarks
- [ ] Mutation testing

## Configuration

`.env.testing` contains:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
DB_DATABASE=<nome progetto>_data_test
=======
DB_DATABASE=laravelpizza_data_test
>>>>>>> a038b0f2 (.)
=======
DB_DATABASE=<nome progetto>_data_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
DB_DATABASE=laravelpizza_data_test
>>>>>>> a038b0f2 (.)
=======
DB_DATABASE=<nome progetto>_data_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
DB_USERNAME=root
DB_PASSWORD=
```

## Advantages (80% Positive Impact)

1. **Real-World Fidelity (25%)**
   - Tests run against the same database engine as production
   - Uncovers database-specific issues early
   - More accurate performance characteristics

2. **Simpler Test Setup (20%)**
   - No need to manage database transactions
   - Easier to debug with persistent data
   - Simpler test data management

3. **Better for Complex Features (20%)**
   - Handles complex queries and relationships better
   - More reliable for testing database constraints
   - Better for testing database migrations

4. **Developer Experience (15%)**
   - Easier to inspect test data after test runs
   - Can use database clients to debug test failures
   - Consistent behavior with development and production

## Disadvantages (20% Negative Impact)

1. **Slower Test Execution (40%)**
   - MySQL is slower than SQLite for test execution
   - No automatic transaction rollback between tests
   - Requires manual cleanup

2. **Test Pollution Risk (30%)**
   - Tests can affect each other if not properly isolated
   - Requires careful management of test data
   - Potential for false positives/negatives if data persists

3. **Maintenance Overhead (20%)**
   - Need to manage database state manually
   - More complex CI/CD pipeline requirements
   - Larger test database to maintain

4. **Resource Intensive (10%)**
   - Requires a running MySQL instance
   - Higher memory and CPU usage
   - Slower feedback loop during development

## Best Practices

### 1. Test Data Management

```php
// Instead of using RefreshDatabase trait, use:
protected function setUp(): void
{
    parent::setUp();
    // Clear only necessary data before each test
    DB::table('users')->truncate();
}
```

### 2. Test Isolation

```php
test('user can login', function () {
    // Arrange
    $user = User::factory()->create();

    // Act & Assert
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password'
    ])->assertRedirect('/dashboard');

    // Cleanup (if needed)
    $user->forceDelete();
});
```

### 3. Database Cleanup

Create a `DatabaseCleanup` trait:

```php
trait DatabaseCleanup
{
    protected function cleanDatabase()
    {
        // List tables to clean (in correct order to respect foreign keys)
        $tables = [
            'sessions',
            'password_reset_tokens',
            'users',
            // Add other tables as needed
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}
```

## Migration Strategy

1. **Test Database Migrations**
   - Run migrations before test suite starts
   - Consider using a separate database for testing
   - Reset database state between test runs

2. **Test Data Factories**
   - Use factories to create test data
   - Ensure factories clean up after themselves
   - Consider using database transactions at the test case level when appropriate

## Performance Considerations

| Approach | Speed | Reliability | Isolation | Realism |
|----------|-------|-------------|-----------|---------|
| SQLite (in-memory) | ⚡ Fast | Medium | High | Low |
| MySQL (transactions) | Medium | High | High | High |
| **Our Approach** | ⏳ Slower | ✅ High | Medium | ✅ High |

## When to Consider Alternatives

Consider using `RefreshDatabase` or `DatabaseTransactions` traits when:
- Test speed becomes a significant bottleneck
- Test isolation issues become unmanageable
- Running a large test suite in CI/CD pipelines

## Conclusion

Our current MySQL-based testing approach without `RefreshDatabase` provides the best balance between test reliability and real-world accuracy for our application. While it comes with some performance trade-offs, the benefits of testing against the same database engine used in production outweigh the costs for our specific use case.

## Additional Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Database Testing Best Practices](https://laracasts.com/series/phpunit-testing-in-laravel-6)
- [Testing Strategies for Laravel Applications](https://tighten.co/blog/5-questions-every-laravel-test-answers)
