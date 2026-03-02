# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Activity module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Activity/tests/
├── Feature/
│   ├── (feature tests)
├── Unit/
│   └── (unit tests)
├── TestCase.php
└── Pest.php
```

### Test Files

- **TestCase.php** - Base test case with database configuration
- **Pest.php** - Pest configuration and extensions
- **Feature/** - Feature tests for Activity functionality
- **Unit/** - Unit tests for Activity components

## Testing Configuration

### TestCase Configuration

The Activity TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Activity module uses the following database connections:
- `activity` - Main Activity module connection
- `mysql` - Default connection
- All connections configured to use test database

## Testing Best Practices

### 1. Database Transactions

Use database transactions for test isolation:

```php
use Illuminate\Foundation\Testing\DatabaseTransactions;
```

### 2. Test Isolation

Each test should be independent:

```php
protected function tearDown(): void
{
    parent::tearDown();
    // Clean up test data
}
```

### 3. Module Configuration

Configure Activity-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Activity module
    config(['activity.default_log_level' => 'info']);
    config(['activity.cache_enabled' => false]);
}
```

## Test Examples

### Basic Activity Test

```php
test('activity can be created', function () {
    $activity = \Modules\Activity\Models\Activity::create([
        'type' => 'user_action',
        'description' => 'Test activity',
        'user_id' => 1,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'data' => ['key' => 'value'],
    ]);
    
    expect($activity)->toBeInstanceOf(\Modules\Activity\Models\Activity::class);
    expect($activity->type)->toBe('user_action');
});
```

### Configuration Test

```php
test('activity configuration is loaded', function () {
    $activityConfig = config('activity');
    
    expect($activityConfig['default_log_level'])->toBe('info');
    expect($activityConfig['cache_enabled'])->toBe(false);
});
```

### Service Provider Test

```php
test('activity service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Activity\Providers\ActivityServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Activity module tests
./vendor/bin/pest Modules/Activity/tests

# Run tests with coverage
./vendor/bin/pest Modules/Activity/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Activity/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Activity module
./vendor/bin/phpstan analyze Modules/Activity

# Run PHPMD on Activity module
./vendor/bin/phpmd Modules/Activity/src

# Run PHPInsights on Activity module
./vendor/bin/phpinsights analyse Modules/Activity
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Activity configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['activity.default_log_level' => 'info']);
    config(['activity.cache_enabled' => false]);
}
```

### 2. Database Issues

**Problem**: Database connection issues

**Solution**: Configure database connections properly:

```php
protected function createApplication()
{
    $app = parent::createApplication();
    
    $app['config']->set([
<<<<<<< .merge_file_UNxw7Q
        'database.connections.activity.database' => 'healthcare_app_data_test',
=======
        'database.connections.activity.database' => 'ptvx_data_test',
>>>>>>> .merge_file_4XPfM4
    ]);
    
    return $app;
}
```

## Testing Goals

### Coverage Requirements

- Aim for 100% code coverage
- Test all public methods
- Test all edge cases
- Test all error scenarios

### Performance Requirements

- Tests should run in <200ms each
- Use database transactions for isolation
- Optimize database queries
- Minimize test data

### Quality Requirements

- All tests must pass PHPStan level 9+
- All tests must follow DRY, KISS, SOLID principles
- All tests must be maintainable
- All tests must be robust

## Testing Workflow

### 1. Setup Phase

1. Configure testing environment
2. Set up database connections
3. Install testing dependencies
4. Verify configuration

### 2. Development Phase

1. Write tests for new features
2. Update existing tests
3. Add regression tests
4. Maintain test coverage

### 3. Quality Assurance

1. Run tests
2. Run quality checks
3. Fix any issues
4. Update documentation

### 4. Deployment Phase

1. Ensure all tests pass
2. Verify coverage requirements
3. Update documentation
4. Commit changes

## Testing Documentation

### Module Documentation

- Update this file when adding new tests
- Document any special testing requirements
- Add examples for new test types
- Keep documentation current

### Root Documentation

- Update root documentation when module testing changes
- Add backlinks to this file
- Keep documentation consistent
- Update troubleshooting guides

## Testing Resources

### External Resources

- [Laravel 12.x Testing Documentation](https://laravel.com/docs/12.x/testing)
- [Pest Installation Guide](https://pestphp.com/docs/installation)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)

### Internal Resources

- [Testing Setup Guide](../../../../../../../docs/testing-setup.md)
- [Testing Best Practices](../../../../../../../docs/testing-best-practices.md)
- [Troubleshooting Guide](../../../../../../../docs/troubleshooting.md)

## Testing Examples

### Model Tests

```php
test('activity can be created', function () {
    $activity = \Modules\Activity\Models\Activity::create([
        'type' => 'user_action',
        'description' => 'Test activity',
        'user_id' => 1,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'data' => ['key' => 'value', 'action' => 'test'],
        'level' => 'info',
        'created_at' => now(),
    ]);
    
    expect($activity)->toBeInstanceOf(\Modules\Activity\Models\Activity::class);
    expect($activity->type)->toBe('user_action');
    expect($activity->description)->toBe('Test activity');
    expect($activity->user_id)->toBe(1);
    expect($activity->ip_address)->toBe('127.0.0.1');
    expect($activity->user_agent)->toBe('Test Agent');
    expect($activity->data)->toBe(['key' => 'value', 'action' => 'test']);
    expect($activity->level)->toBe('info');
});
```

### Service Tests

```php
test('activity service can log activity', function () {
    $service = new \Modules\Activity\Services\ActivityService();
    
    $activity = $service->logActivity([
        'type' => 'user_action',
        'description' => 'Test activity',
        'user_id' => 1,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'data' => ['key' => 'value'],
    ]);
    
    expect($activity)->toBeInstanceOf(\Modules\Activity\Models\Activity::class);
    expect($activity->type)->toBe('user_action');
});
```

### API Tests

```php
test('activity api can log activity', function () {
    $activityData = [
        'type' => 'user_action',
        'description' => 'Test activity',
        'user_id' => 1,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'data' => ['key' => 'value'],
    ];
    
    $response = $this->post('/api/activity/log', $activityData);
    $response->assertStatus(201);
    $response->assertJson([
        'type' => 'user_action',
        'description' => 'Test activity',
        'user_id' => 1,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
    ]);
});
```

## Testing Checklist

### Before Writing Tests

- [ ] Understand the feature to test
- [ ] Review existing tests
- [ ] Plan test scenarios
- [ ] Prepare test data

### While Writing Tests

- [ ] Use descriptive test names
- [ ] Use proper assertions
- [ ] Clean up test data
- [ ] Document tests

### After Writing Tests

- [ ] Run tests
- [ ] Check coverage
- [ ] Run quality checks
- [ ] Update documentation

### Before Committing

- [ ] All tests pass
- [ ] Coverage requirements met
- [ ] Quality checks pass
- [ ] Documentation updated

## Testing Conclusion

Following these guidelines will ensure your Activity module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*