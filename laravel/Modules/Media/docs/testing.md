# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Media module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Media/tests/
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
- **Feature/** - Feature tests for Media functionality
- **Unit/** - Unit tests for Media components

## Testing Configuration

### TestCase Configuration

The Media TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Media module uses the following database connections:
- `media` - Main Media module connection
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

Configure Media-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Media module
    config(['media.default_disk' => 'local']);
    config(['media.max_file_size' => 10240);
    config(['media.allowed_extensions' => ['jpg', 'png', 'gif']);
}
```

## Test Examples

### Basic Media Test

```php
test('media file can be uploaded', function () {
    $media = \Modules\Media\Models\Media::create([
        'filename' => 'test.jpg',
        'original_name' => 'Test Image',
        'mime_type' => 'image/jpeg',
        'size' => 1024,
        'disk' => 'local',
        'path' => 'media/test.jpg',
    ]);
    
    expect($media)->toBeInstanceOf(\Modules\Media\Models\Media::class);
    expect($media->filename)->toBe('test.jpg');
});
```

### Configuration Test

```php
test('media configuration is loaded', function () {
    $mediaConfig = config('media');
    
    expect($mediaConfig['default_disk'])->toBe('local');
    expect($mediaConfig['max_file_size'])->toBe(10240);
    expect($mediaConfig['allowed_extensions'])->toBe(['jpg', 'png', 'gif']);
});
```

### Service Provider Test

```php
test('media service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Media\Providers\MediaServiceProvider::class))->toBeTrue();
});
```

## Testing Commands

### Running Tests

```bash
# Run all Media module tests
./vendor/bin/pest Modules/Media/tests

# Run tests with coverage
./vendor/bin/pest Modules/Media/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Media/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Media module
./vendor/bin/phpstan analyze Modules/Media

# Run PHPMD on Media module
./vendor/bin/phpmd Modules/Media/src

# Run PHPInsights on Media module
./vendor/bin/phpinsights analyse Modules/Media
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Media configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['media.default_disk' => 'local']);
    config(['media.max_file_size' => 10240);
    config(['media.allowed_extensions' => ['jpg', 'png', 'gif']);
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
<<<<<<< .merge_file_5ESUsX
        'database.connections.media.database' => 'healthcare_app_data_test',
=======
        'database.connections.media.database' => 'ptvx_data_test',
>>>>>>> .merge_file_Tlc2vv
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
test('media file can be created', function () {
    $media = \Modules\Media\Models\Media::create([
        'filename' => 'test.jpg',
        'original_name' => 'Test Image',
        'mime_type' => 'image/jpeg',
        'size' => 1024,
        'disk' => 'local',
        'path' => 'media/test.jpg',
        'alt_text' => 'Test image description',
        'caption' => 'Test caption',
    ]);
    
    expect($media)->toBeInstanceOf(\Modules\Media\Models\Media::class);
    expect($media->filename)->toBe('test.jpg');
    expect($media->original_name)->toBe('Test Image');
    expect($media->mime_type)->toBe('image/jpeg');
    expect($media->size)->toBe(1024);
    expect($media->disk)->toBe('local');
    expect($media->path)->toBe('media/test.jpg');
    expect($media->alt_text)->toBe('Test image description');
    expect($media->caption)->toBe('Test caption');
});
```

### Service Tests

```php
test('media service can upload file', function () {
    $service = new \Modules\Media\Services\MediaService();
    
    $file = UploadedFile::fake('image.jpg', 1024);
    $media = $service->uploadFile($file, 'test.jpg', 'Test Image');
    
    expect($media)->toBeInstanceOf(\Modules\Media\Models\Media::class);
    expect($media->filename)->toBe('test.jpg');
    expect($media->original_name)->toBe('Test Image');
    expect($media->mime_type)->toBe('image/jpeg');
});
```

### API Tests

```php
test('media api can upload file', function () {
    $file = UploadedFile::fake('image.jpg', 1024);
    
    $response = $this->post('/api/media/upload', [
        'file' => $file,
        'filename' => 'test.jpg',
        'alt_text' => 'Test image description',
    ]);
    
    $response->assertStatus(201);
    $response->assertJson([
        'filename' => 'test.jpg',
        'original_name' => 'image.jpg',
        'mime_type' => 'image/jpeg',
        'size' => 1024,
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

Following these guidelines will ensure your Media module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*