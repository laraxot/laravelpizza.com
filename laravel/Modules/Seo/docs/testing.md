# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Seo module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Seo/tests/
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
- **Feature/** - Feature tests for Seo functionality
- **Unit/** - Unit tests for Seo components

## Testing Configuration

### TestCase Configuration

The Seo TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Seo module uses the following database connections:
- `seo` - Main Seo module connection
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

Configure Seo-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Seo module
    config(['seo.default_title' => 'Test Site']);
    config(['seo.default_description' => 'Test description']);
    config(['seo.cache_enabled' => false]);
}
```

## Test Examples

### Basic Seo Test

```php
test('seo metadata can be created', function () {
    $metadata = \Modules\Seo\Models\SeoMetadata::create([
        'url' => '/test-page',
        'title' => 'Test Page',
        'description' => 'Test description',
        'keywords' => 'test,seo',
        'locale' => 'it',
    ]);
    
    expect($metadata)->toBeInstanceOf(\Modules\Seo\Models\SeoMetadata::class);
    expect($metadata->title)->toBe('Test Page');
});
```

### Configuration Test

```php
test('seo configuration is loaded', function () {
    $seoConfig = config('seo');
    
    expect($seoConfig['default_title'])->toBe('Test Site');
    expect($seoConfig['default_description'])->toBe('Test description');
    expect($seoConfig['cache_enabled'])->toBe(false);
});
```

### Service Provider Test

```php
test('seo service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Seo\Providers\SeoServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Seo module tests
./vendor/bin/pest Modules/Seo/tests

# Run tests with coverage
./vendor/bin/pest Modules/Seo/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Seo/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Seo module
./vendor/bin/phpstan analyze Modules/Seo

# Run PHPMD on Seo module
./vendor/bin/phpmd Modules/Seo/src

# Run PHPInsights on Seo module
./vendor/bin/phpinsights analyse Modules/Seo
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Seo configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['seo.default_title' => 'Test Site']);
    config(['seo.default_description' => 'Test description']);
    config(['seo.cache_enabled' => false]);
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
        'database.connections.seo.database' => 'quaeris_data_test',
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

- [Testing Setup Guide](../../../../../docs/testing-setup.md)
- [Testing Best Practices](../../../../../docs/testing-best-practices.md)
- [Troubleshooting Guide](../../../../../docs/troubleshooting.md)

## Testing Examples

### Model Tests

```php
test('seo metadata can be created', function () {
    $metadata = \Modules\Seo\Models\SeoMetadata::create([
        'url' => '/test-page',
        'title' => 'Test Page',
        'description' => 'Test description',
        'keywords' => 'test,seo',
        'locale' => 'it',
        'og_title' => 'Test Page',
        'og_description' => 'Test description',
        'og_image' => '/images/test-image.jpg',
        'canonical_url' => 'https://example.com/test-page',
        'robots' => 'index,follow',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    expect($metadata)->toBeInstanceOf(\Modules\Seo\Models\SeoMetadata::class);
    expect($metadata->url)->toBe('/test-page');
    expect($metadata->title)->toBe('Test Page');
    expect($metadata->description)->toBe('Test description');
    expect($metadata->keywords)->toBe('test,seo');
    expect($metadata->locale)->toBe('it');
    expect($metadata->og_title)->toBe('Test Page');
    expect($metadata->og_description)->toBe('Test description');
    expect($metadata->og_image')->toBe('/images/test-image.jpg');
    expect($metadata->canonical_url)->toBe('https://example.com/test-page');
    expect($metadata->robots)->toBe('index,follow');
});
```

### Service Tests

```php
use Modules\Seo\Services\MetatagService;

it('can set title', function () {
    $service = new MetatagService();
    $service->setTitle('Test Title');
    expect($service->get()->getTitle())->toBe('Test Title');
});

it('can set description', function () {
    $service = new MetatagService();
    $service->setDescription('Test Description');
    expect($service->get()->getDescription())->toBe('Test Description');
});
```


### API Tests

```php
test('seo api can get metadata', function () {
    \Modules\Seo\Models\SeoMetadata::create([
        'url' => '/test-page',
        'title' => 'Test Page',
        'description' => 'Test description',
        'keywords' => 'test,seo',
    ]);
    
    $response = $this->get('/api/seo/metadata/test-page');
    $response->assertStatus(200);
    $response->assertJson([
        'url' => '/test-page',
        'title' => 'Test Page',
        'description' => 'Test description',
        'keywords' => 'test,seo',
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

Following these guidelines will ensure your Seo module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

