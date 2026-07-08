# Incentivi Module - Test Suite

This directory contains the Incentivi module test suite, including unit, Filament smoke, and integration workflow tests.

## Quick Start

### Mandatory DB Safety Rule
Never use:
- `RefreshDatabase`
- `migrate:fresh`
- `migrate --force`

### Run All Tests
```bash
cd laravel
./vendor/bin/pest Modules/Incentivi/tests
```

### Run Tests by Category
```bash
# Unit tests only
./vendor/bin/pest Modules/Incentivi/tests/Unit

# Feature tests only
./vendor/bin/pest Modules/Incentivi/tests/Feature

# Filament resource tests
./vendor/bin/pest Modules/Incentivi/tests/Feature/Filament

# Integration tests
./vendor/bin/pest Modules/Incentivi/tests/Feature/Integration
```

### Run Single Test
```bash
./vendor/bin/pest --filter="test name"
./vendor/bin/pest Modules/Incentivi/tests/Unit/Models/ActivityTest.pest.php
```

### With Coverage Report
```bash
./vendor/bin/pest Modules/Incentivi/tests --coverage --coverage-html=coverage
```

## Test Structure

```text
tests/
├── Unit/
│   ├── ProjectTest.php
│   ├── Models/
│   │   └── IncentiviModelsTest.php
│   └── Actions/
│       ├── SpareImportoTotaleActionTest.php
│       ├── UpdateActivitiesEmployeesActionTest.php
│       └── UpdateProjectActivitiesActionTest.php
├── Feature/
│   ├── Filament/
│   │   └── IncentiviFilamentResourcesTest.php
│   └── Integration/
│       └── IncentiviWorkflowIntegrationTest.php
├── Pest.php
├── TestCase.php
└── README.md
```

## Test Patterns & Best Practices

### 1. Unit Test (Model Example)
```php
// tests/Unit/Models/ActivityTest.pest.php

it('creates activity with valid data', function () {
    // ARRANGE: Set up test data
    $data = Activity::factory()->make();
    
    // ACT: Execute the action
    $activity = Activity::create($data->toArray());
    
    // ASSERT: Verify results
    expect($activity)->toBeInstanceOf(Activity::class);
    expect($activity->id)->toBeTruthy();
    expect(Activity::count())->toBe(1);
});
```

### 2. Action Test Example
```php
// tests/Unit/Actions/SpareImportoTotaleActionTest.pest.php

it('calculates spare importo totale correctly', function () {
    // ARRANGE
    $employee = Employee::factory()->create();
    $settlement = Settlement::factory()
        ->for($employee)
        ->create(['importo_totale' => 1000]);
    
    // ACT
    $result = app(SpareImportoTotaleAction::class)->execute($employee);
    
    // ASSERT
    expect($result)->toBeNumeric();
    expect($result)->toBeGreaterThanOrEqual(0);
});
```

### 3. Filament Resource Smoke Test
```php
// tests/Feature/Filament/IncentiviFilamentResourcesTest.php

it('all key incentive resources extend xot base resource', function () {
    expect(is_subclass_of(ActivityResource::class, XotBaseResource::class))->toBeTrue();
});
```

### 4. Integration Test
```php
// tests/Feature/Integration/IncentiviWorkflowIntegrationTest.php

it('completes full incentive calculation workflow', function () {
    // Create test data
    $employee = Employee::factory()->create();
    $project = Project::factory()->create();
    
    // Execute workflow
    app(CalculateIncentiveAction::class)->execute($employee, $project);
    
    // Verify results across multiple models
    expect(Settlement::where('employee_id', $employee->id)->exists())->toBeTrue();
    expect(Activity::where('project_id', $project->id)->count())->toBeGreaterThan(0);
});
```

## AAA Pattern

All tests follow the **AAA (Arrange-Act-Assert)** pattern:

1. **ARRANGE**: Set up test data and conditions
2. **ACT**: Execute the code being tested
3. **ASSERT**: Verify the results

This makes tests easy to read and understand.

## Test Data: Factories & Fixtures

### Using Model Factories
```php
// Create single instance
$activity = Activity::factory()->create();

// Create multiple instances
$activities = Activity::factory()->count(5)->create();

// Create with specific attributes
$activity = Activity::factory()->create([
    'name' => 'Custom Activity',
    'status' => 'active',
]);

// Create without persisting
$activity = Activity::factory()->make();
```

Factories are defined in:
- `database/factories/` (global Laravel factories)
- Module-specific factories follow naming: `{ModelName}Factory`

## Mocking Strategy

### When to Mock
- ✓ External API calls
- ✓ Mailers and Notifications
- ✓ Events (use `Event::fake()` or spy)
- ✓ Cache operations

### When to Use Real Objects
- ✓ Database interactions (use transactions for isolation)
- ✓ Model relationships and scopes
- ✓ Business logic and calculations
- ✓ Eloquent methods and accessors

### Mock Examples
```php
// Mock an external API
Http::fake([
    'api.example.com/*' => Http::response(['data' => []]),
]);

// Mock events
Event::fake();
$action->execute();
Event::assertDispatched(IncentiveCalculated::class);

// Mock mailer
Mail::fake();
$action->execute();
Mail::assertSent(IncentiveNotification::class);
```

## Coverage Requirements

### Minimum Coverage
- Overall: **80%**
- Models: **90%**
- Actions: **95%**
- Filament Resources: **80%**

### Generate Coverage Report
```bash
# HTML report
./vendor/bin/pest Modules/Incentivi/tests --coverage --coverage-html=coverage

# Open report
open coverage/index.html
```

### Check Coverage for Specific File
```bash
./vendor/bin/pest --coverage Modules/Incentivi/app/Models/Activity.php
```

## Common Assertions

### Pest v4 Assertions
```php
// Instance checks
expect($model)->toBeInstanceOf(Activity::class);

// Numeric comparisons
expect($count)->toBe(5);
expect($amount)->toBeGreaterThan(0);
expect($percentage)->toBeLessThanOrEqual(100);

// Array checks
expect($array)->toContain('value');
expect($array)->toHaveCount(3);
expect($array)->toHaveKey('name');

// String checks
expect($string)->toContain('substring');
expect($string)->toEqual('exact match');

// Boolean checks
expect($exists)->toBeTrue();
expect($deleted)->toBeFalse();

// Exception handling
expect(fn() => $action->execute())->toThrow(InvalidArgumentException::class);

// Database assertions
expect(Activity::count())->toBe(1);
expect(Activity::where('name', 'Test')->exists())->toBeTrue();

// Custom expectations
expect($user)->toHaveEmail('user@example.com');
```

## Debugging Tests

### Run With Verbose Output
```bash
./vendor/bin/pest -v
```

### Stop on First Failure
```bash
./vendor/bin/pest --bail
```

### Run Single Test File
```bash
./vendor/bin/pest tests/Unit/Models/ActivityTest.pest.php
```

### Use dd() for Debugging
```php
it('debugs test execution', function () {
    $activity = Activity::factory()->create();
    dd($activity->toArray()); // Dump and die
});
```

### Use Ray for Interactive Debugging
```php
it('uses ray for debugging', function () {
    $activity = Activity::factory()->create();
    ray($activity)->showQueries(); // Send to Ray app
});
```

## Performance & Best Practices

### 1. Keep Tests Fast
- Total suite should complete in < 30 seconds
- Avoid unnecessary database queries
- Use mocking for external services
- Transaction rollback cleans up database automatically

### 2. Test Independence
- Tests must not depend on other tests
- Use factories to create fresh data for each test
- Database transactions ensure isolation

### 3. Meaningful Assertions
- One logical assertion per test (when possible)
- Use descriptive test names that explain what's being tested
- Avoid testing implementation details

### 4. DRY (Don't Repeat Yourself)
- Extract common setup into shared functions in `Pest.php`
- Use factories for consistent test data
- Create custom assertions for repeated checks

### 5. Realistic Test Data
- Use factories that generate realistic data
- Test with edge cases and boundary values
- Consider various states and scenarios

## Continuous Integration

Tests run automatically on:

| Trigger | Scope |
|---------|-------|
| Pull Request | Full suite + coverage report |
| Merge to main | Coverage badge generation |
| Manual trigger | Full suite + detailed report |

See `.github/workflows/test.yml` for CI configuration.

## Troubleshooting

### Tests Pass Locally But Fail in CI
- Check database configuration
- Verify environment variables
- Look for timezone or locale issues
- Check for hardcoded paths

### Database Integrity Errors
- Ensure transactions are properly rolled back
- Check for missing factories
- Verify foreign key constraints in tests
- Look for leftover test data

### Flaky Tests
- Avoid time-dependent assertions
- Don't rely on execution order
- Mock external services
- Use deterministic factories

### Memory Issues
- Run tests in smaller groups
- Clear cached data between test runs
- Avoid storing large datasets in memory
- Use streaming for big file operations

## Resources

- [Pest Documentation](https://pestphp.com)
- [Laravel Testing Docs](https://laravel.com/docs/testing)
- [Filament Testing Guide](https://filamentphp.com/docs/testing)
- [Module Test Plan](./docs/test-plan.md)
- [PRD](./docs/prd.md)

## Contributing

When adding new tests:

1. Follow AAA pattern
2. Use descriptive test names
3. Target minimum 80% coverage
4. Ensure PHPStan Level 10 compliance
5. Run all tests locally before submitting PR
6. Update this README if test structure changes

## Questions?

Refer to:
- Test plan: `docs/test-plan.md`
- Module PRD: `docs/prd.md`
- Team wiki: GitHub Wiki
- GitHub Issues: #58-#62

---

**Last Updated**: 2026-03-06
**Test Framework**: Pest v4
**PHP Version**: 8.3+
