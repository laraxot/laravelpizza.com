# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Notify module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Notify/tests/
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
- **Feature/** - Feature tests for Notify functionality
- **Unit/** - Unit tests for Notify components

## Testing Configuration

### TestCase Configuration

The Notify TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Notify module uses the following database connections:
- `notify` - Main Notify module connection
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

Configure Notify-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Notify module
    config(['notify.default_channel' => 'email']);
    config(['notify.queue_enabled' => false);
}
```

## Test Examples

### Basic Notify Test

```php
test('notification can be created', function () {
    $notification = \Modules\Notify\Models\Notification::create([
        'title' => 'Test Notification',
        'message' => 'Test message',
        'type' => 'info',
        'channel' => 'email',
    ]);
    
    expect($notification)->toBeInstanceOf(\Modules\Notify\Models\Notification::class);
    expect($notification->title)->toBe('Test Notification');
});
```

### Configuration Test

```php
test('notify configuration is loaded', function () {
    $notifyConfig = config('notify');
    
    expect($notifyConfig['default_channel'])->toBe('email');
    expect($notifyConfig['queue_enabled'])->toBe(false);
});
```

### Service Provider Test

```php
test('notify service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Notify\Providers\NotifyServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Notify module tests
./vendor/bin/pest Modules/Notify/tests

# Run tests with coverage
./vendor/bin/pest Modules/Notify/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Notify/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Notify module
./vendor/bin/phpstan analyze Modules/Notify

# Run PHPMD on Notify module
./vendor/bin/phpmd Modules/Notify/src

# Run PHPInsights on Notify module
./vendor/bin/phpinsights analyse Modules/Notify
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Notify configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['notify.default_channel' => 'email']);
    config(['notify.queue_enabled' => false);
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
        'database.connections.notify.database' => 'quaeris_data_test',
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
test('notification can be created', function () {
    $notification = \Modules\Notify\Models\Notification::create([
        'title' => 'Test Notification',
        'message' => 'Test message',
        'type' => 'info',
        'channel' => 'email',
        'recipient' => 'test@example.com',
        'status' => 'pending',
    ]);
    
    expect($notification)->toBeInstanceOf(\Modules\Notify\Models\Notification::class);
    expect($notification->title)->toBe('Test Notification');
    expect($notification->message)->toBe('Test message');
    expect($notification->type)->toBe('info');
    expect($notification->channel)->toBe('email');
    expect($notification->recipient)->toBe('test@example.com');
    expect($notification->status)->toBe('pending');
});
```

### Service Tests

```php
test('notify service can send notification', function () {
    $service = new \Modules\Notify\Services\NotifyService();
    
    $notification = $service->sendNotification([
        'title' => 'Test Notification',
        'message' => 'Test message',
        'type' => 'info',
        'channel' => 'email',
        'recipient' => 'test@example.com',
    ]);
    
    expect($notification)->toBeInstanceOf(\Modules\Notify\Models\Notification::class);
    expect($notification->status)->toBe('sent');
});
```

### API Tests

```php
test('notify api can create notification', function () {
    $notificationData = [
        'title' => 'Test Notification',
        'message' => 'Test message',
        'type' => 'info',
        'channel' => 'email',
        'recipient' => 'test@example.com',
    ];
    
    $response = $this->post('/api/notify/notifications', $notificationData);
    $response->assertStatus(201);
    $response->assertJson([
        'title' => 'Test Notification',
        'message' => 'Test message',
        'type' => 'info',
        'channel' => 'email',
        'recipient' => 'test@example.com',
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

Following these guidelines will ensure your Notify module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*Last updated: January 2025*