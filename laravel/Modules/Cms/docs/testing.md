# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Cms module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Cms/tests/
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
- **Feature/** - Feature tests for Cms functionality
- **Unit/** - Unit tests for Cms components

## Testing Configuration

### TestCase Configuration

The Cms TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Cms module uses the following database connections:
- `cms` - Main Cms module connection
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

Configure Cms-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Cms module
    config(['cms.theme' => 'Zero']);
    config(['cms.locale' => 'it']);
}
```

## Test Examples

### Basic Cms Test

```php
test('cms data can be created', function () {
    $cmsData = \Modules\Cms\Models\CmsData::create([
        'title' => 'Test Page',
        'content' => 'Test content',
    ]);
    
    expect($cmsData)->toBeInstanceOf(\Modules\Cms\Models\CmsData::class);
    expect($cmsData->title)->toBe('Test Page');
});
```

### Configuration Test

```php
test('cms configuration is loaded', function () {
    $cmsConfig = config('cms');
    
    expect($cmsConfig['theme'])->toBe('Zero');
    expect($cmsConfig['locale'])->toBe('it');
});
```

### Service Provider Test

```php
test('cms service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Cms\Providers\CmsServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Cms module tests
./vendor/bin/pest Modules/Cms/tests

# Run tests with coverage
./vendor/bin/pest Modules/Cms/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Cms/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Cms module
./vendor/bin/phpstan analyze Modules/Cms

# Run PHPMD on Cms module
./vendor/bin/phpmd Modules/Cms/src

# Run PHPInsights on Cms module
./vendor/bin/phpinsights analyse Modules/Cms
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Cms configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['cms.theme' => 'Zero']);
    config(['cms.locale' => 'it']);
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
        'database.connections.cms.database' => 'quaeris_data_test',
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
test('cms page can be created', function () {
    $page = \Modules\Cms\Models\Page::create([
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => 'Test content',
        'status' => 'published',
    ]);
    
    expect($page)->toBeInstanceOf(\Modules\Cms\Models\Page::class);
    expect($page->title)->toBe('Test Page');
    expect($page->slug)->toBe('test-page');
    expect($page->status)->toBe('published');
});
```

### Controller Tests

```php
test('cms page can be retrieved', function () {
    $page = \Modules\Cms\Models\Page::create([
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => 'Test content',
        'status' => 'published',
    ]);
    
    $response = $this->get("/pages/{$page->slug}");
    $response->assertStatus(200);
    $response->assertSee($page->title);
});
```

### Service Tests

```php
test('cms service can render content', function () {
    $service = new \Modules\Cms\Services\CmsService();
    $content = $service->renderContent('Test content');
    
    expect($content)->toBeString();
    expect($content)->toContain('Test content');
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

Following these guidelines will ensure your Cms module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*Last updated: January 2025*