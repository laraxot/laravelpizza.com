# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Meetup module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Meetup/tests/
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
- **Feature/** - Feature tests for Meetup functionality
- **Unit/** - Unit tests for Meetup components

## Testing Configuration

### TestCase Configuration

The Meetup TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Meetup module uses the following database connections:
- `meetup` - Main Meetup module connection
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

Configure Meetup-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Meetup module
    config(['meetup.default_theme' => 'default']);
    config(['meetup.cache_enabled' => false]);
}
```

## Test Examples

### Basic Meetup Test

```php
test('meetup event can be created', function () {
    $event = \Modules\Meetup\Models\MeetupEvent::create([
        'title' => 'Test Event',
        'description' => 'Test event description',
        'location' => 'Test Location',
        'date' => '[DATE]',
        'time' => '10:00:00',
        'capacity' => 100,
        'status' => 'active',
    ]);
    
    expect($event)->toBeInstanceOf(\Modules\Meetup\Models\MeetupEvent::class);
    expect($event->title)->toBe('Test Event');
});
```

### Configuration Test

```php
test('meetup configuration is loaded', function () {
    $meetupConfig = config('meetup');
    
    expect($meetupConfig['default_theme'])->toBe('default');
    expect($meetupConfig['cache_enabled'])->toBe(false);
});
```

### Service Provider Test

```php
test('meetup service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Meetup\Providers\MeetupServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Meetup module tests
./vendor/bin/pest Modules/Meetup/tests

# Run tests with coverage
./vendor/bin/pest Modules/Meetup/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Meetup/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Meetup module
./vendor/bin/phpstan analyze Modules/Meetup

# Run PHPMD on Meetup module
./vendor/bin/phpmd Modules/Meetup/src

# Run PHPInsights on Meetup module
./vendor/bin/phpinsights analyse Modules/Meetup
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Meetup configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['meetup.default_theme' => 'default']);
    config(['meetup.cache_enabled' => false]);
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
        'database.connections.meetup.database' => 'quaeris_data_test',
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

- [Testing Setup Guide](../../../../docs/testing-setup.md)
- [Testing Best Practices](../../../../docs/testing-best-practices.md)
- [Troubleshooting Guide](../../../../docs/troubleshooting.md)

## Testing Examples

### Model Tests

```php
test('meetup event can be created', function () {
    $event = \Modules\Meetup\Models\MeetupEvent::create([
        'title' => 'Test Event',
        'description' => 'Test event description',
        'location' => 'Test Location',
        'date' => '[DATE]',
        'time' => '10:00:00',
        'capacity' => 100,
        'status' => 'active',
        'organizer_id' => 1,
        'created_at' => now(),
    ]);
    
    expect($event)->toBeInstanceOf(\Modules\Meetup\Models\MeetupEvent::class);
    expect($event->title)->toBe('Test Event');
    expect($event->description)->toBe('Test event description');
    expect($event->location)->toBe('Test Location');
    expect($event->date)->toBe('[DATE]');
    expect($event->time)->toBe('10:00:00');
    expect($event->capacity)->toBe(100);
    expect($event->status)->toBe('active');
    expect($event->organizer_id)->toBe(1);
});
```

### Service Tests

```php
test('meetup service can create event', function () {
    $service = new \Modules\Meetup\Services\MeetupService();
    
    $event = $service->createEvent([
        'title' => 'Test Event',
        'description' => 'Test event description',
        'location' => 'Test Location',
        'date' => '[DATE]',
        'time' => '10:00:00',
        'capacity' => 100,
    ]);
    
    expect($event)->toBeInstanceOf(\Modules\Meetup\Models\MeetupEvent::class);
    expect($event->title)->toBe('Test Event');
});
```

### API Tests

```php
test('meetup api can create event', function () {
    $eventData = [
        'title' => 'Test Event',
        'description' => 'Test event description',
        'location' => 'Test Location',
        'date' => '[DATE]',
        'time' => '10:00:00',
        'capacity' => 100,
    ];
    
    $response = $this->post('/api/meetup/events', $eventData);
    $response->assertStatus(201);
    $response->assertJson([
        'title' => 'Test Event',
        'description' => 'Test event description',
        'location' => 'Test Location',
        'date' => '[DATE]',
        'time' => '10:00:00',
        'capacity' => 100,
        'status' => 'active',
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

Following these guidelines will ensure your Meetup module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

