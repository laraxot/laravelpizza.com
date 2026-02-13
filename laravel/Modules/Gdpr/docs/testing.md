# Testing Documentation

## Overview

This document provides testing guidelines and examples for the GDPR module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Gdpr/tests/
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
- **Feature/** - Feature tests for GDPR functionality
- **Unit/** - Unit tests for GDPR components

## Testing Configuration

### TestCase Configuration

The GDPR TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

GDPR module uses the following database connections:
- `gdpr` - Main GDPR module connection
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

Configure GDPR-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure GDPR module
    config(['gdpr.default_retention_days' => 30]);
    config(['gdpr.anonymization_enabled' => true]);
}
```

## Test Examples

### Basic GDPR Test

```php
test('gdpr request can be created', function () {
    $request = \Modules\Gdpr\Models\GdprRequest::create([
        'type' => 'data_deletion',
        'email' => 'test@example.com',
        'status' => 'pending',
        'data' => ['key' => 'value'],
    ]);
    
    expect($request)->toBeInstanceOf(\Modules\Gdpr\Models\GdprRequest::class);
    expect($request->type)->toBe('data_deletion');
});
```

### Configuration Test

```php
test('gdpr configuration is loaded', function () {
    $gdprConfig = config('gdpr');
    
    expect($gdprConfig['default_retention_days'])->toBe(30);
    expect($gdprConfig['anonymization_enabled'])->toBe(true);
});
```

### Service Provider Test

```php
test('gdpr service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Gdpr\Providers\GdprServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all GDPR module tests
./vendor/bin/pest Modules/Gdpr/tests

# Run tests with coverage
./vendor/bin/pest Modules/Gdpr/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Gdpr/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on GDPR module
./vendor/bin/phpstan analyze Modules/Gdpr

# Run PHPMD on GDPR module
./vendor/bin/phpmd Modules/Gdpr/src

# Run PHPInsights on GDPR module
./vendor/bin/phpinsights analyse Modules/Gdpr
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: GDPR configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['gdpr.default_retention_days' => 30]);
    config(['gdpr.anonymization_enabled' => true]);
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
        'database.connections.gdpr.database' => 'quaeris_data_test',
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

- [Testing Setup Guide](../../docs/testing-setup.md)
- [Testing Best Practices](../../docs/testing-best-practices.md)
- [Troubleshooting Guide](../../docs/troubleshooting.md)

## Testing Examples

### Model Tests

```php
test('gdpr request can be created', function () {
    $request = \Modules\Gdpr\Models\GdprRequest::create([
        'type' => 'data_deletion',
        'email' => 'test@example.com',
        'status' => 'pending',
        'data' => ['key' => 'value', 'request_id' => 'test123'],
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'created_at' => now(),
    ]);
    
    expect($request)->toBeInstanceOf(\Modules\Gdpr\Models\GdprRequest::class);
    expect($request->type)->toBe('data_deletion');
    expect($request->email)->toBe('test@example.com');
    expect($request->status)->toBe('pending');
    expect($request->data)->toBe(['key' => 'value', 'request_id' => 'test123']);
    expect($request->ip_address)->toBe('127.0.0.1');
    expect($request->user_agent)->toBe('Test Agent');
});
```

### Service Tests

```php
test('gdpr service can process data deletion request', function () {
    $service = new \Modules\Gdpr\Services\GdprService();
    
    $request = $service->processDataDeletion([
        'email' => 'test@example.com',
        'data' => ['key' => 'value'],
    ]);
    
    expect($request)->toBeInstanceOf(\Modules\dpr\Models\GdprRequest::class);
    expect($request->type)->toBe('data_deletion');
    expect($request->status)->toBe('processed');
});
```

### API Tests

```php
test('gdpr api can create data deletion request', function () {
    $requestData = [
        'email' => 'test@example.com',
        'data' => ['key' => 'value'],
    ];
    
    $response = $this->post('/api/gdpr/data-deletion', $requestData);
    $response->assertStatus(201);
    $response->assertJson([
        'type' => 'data_deletion',
        'email' => 'test@example.com',
        'status' => 'pending',
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

Following these guidelines will ensure your GDPR module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*