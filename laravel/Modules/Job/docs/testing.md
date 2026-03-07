# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Job module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Job/tests/
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
- **Feature/** - Feature tests for Job functionality
- **Unit/** - Unit tests for Job components

## Testing Configuration

### TestCase Configuration

The Job TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Job module uses the following database connections:
- `job` - Main Job module connection
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

Configure Job-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Job module
    config(['job.default_queue' => 'default']);
    config(['job.max_attempts' => 3]);
    config(['job.timeout' => 60]);
}
```

## Test Examples

### Basic Job Test

```php
test('job can be created', function () {
    $job = \Modules\Job\Models\Job::create([
        'title' => 'Test Job',
        'description' => 'Test job description',
        'queue' => 'default',
        'payload' => ['key' => 'value'],
        'attempts' => 0,
        'status' => 'pending',
    ]);
    
    expect($job)->toBeInstanceOf(\Modules\Job\Models\Job::class);
    expect($job->title)->toBe('Test Job');
});
```

### Configuration Test

```php
test('job configuration is loaded', function () {
    $jobConfig = config('job');
    
    expect($jobConfig['default_queue'])->toBe('default');
    expect($jobConfig['max_attempts'])->toBe(3);
    expect($jobConfig['timeout'])->toBe(60);
});
```

### Service Provider Test

```php
test('job service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Job\Providers\JobServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Job module tests
./vendor/bin/pest Modules/Job/tests

# Run tests with coverage
./vendor/bin/pest Modules/Job/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Job/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Job module
./vendor/bin/phpstan analyze Modules/Job

# Run PHPMD on Job module
./vendor/bin/phpmd Modules/Job/src

# Run PHPInsights on Job module
./vendor/bin/phpinsights analyse Modules/Job
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Job configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['job.default_queue' => 'default']);
    config(['job.max_attempts' => 3]);
    config(['job.timeout' => 60]);
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
        'database.connections.job.database' => 'healthcare_app_data_test',
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
test('job can be created', function () {
    $job = \Modules\Job\Models\Job::create([
        'title' => 'Test Job',
        'description' => 'Test job description',
        'queue' => 'default',
        'payload' => ['key' => 'value', 'data' => 'test'],
        'attempts' => 0,
        'status' => 'pending',
        'priority' => 1,
        'timeout' => 60,
    ]);
    
    expect($job)->toBeInstanceOf(\Modules\Job\Models\Job::class);
    expect($job->title)->toBe('Test Job');
    expect($job->description)->toBe('Test job description');
    expect($job->queue)->toBe('default');
    expect($job->payload)->toBe(['key' => 'value', 'data' => 'test']);
    expect($job->attempts)->toBe(0);
    expect($job->status)->toBe('pending');
    expect($job->priority)->toBe(1);
    expect($job->timeout)->toBe(60);
});
```

### Service Tests

```php
test('job service can dispatch job', function () {
    $service = new \Modules\Job\Services\JobService();
    
    $job = $service->dispatchJob([
        'title' => 'Test Job',
        'description' => 'Test job description',
        'queue' => 'default',
        'payload' => ['key' => 'value'],
    ]);
    
    expect($job)->toBeInstanceOf(\Modules\Job\Models\Job::class);
    expect($job->status)->toBe('pending');
});
```

### Queue Tests

```php
test('job can be processed', function () {
    $job = \Modules\Job\Models\Job::create([
        'title' => 'Test Job',
        'description' => 'Test job description',
        'queue' => 'default',
        'payload' => ['key' => 'value'],
        'status' => 'pending',
    ]);
    
    // Simulate job processing
    $job->status = 'completed';
    $job->save();
    
    expect($job->status)->toBe('completed');
});
```

### API Tests

```php
test('job api can create job', function () {
    $jobData = [
        'title' => 'Test Job',
        'description' => 'Test job description',
        'queue' => 'default',
        'payload' => ['key' => 'value'],
    ];
    
    $response = $this->post('/api/jobs', $jobData);
    $response->assertStatus(201);
    $response->assertJson([
        'title' => 'Test Job',
        'description' => 'Test job description',
        'queue' => 'default',
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

Following these guidelines will ensure your Job module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*