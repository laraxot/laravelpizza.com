---
issues: []
discussions: []
title: "Testing Documentation"
module: "Media"
type: concept
tags: [testing]
created: 2026-07-14
updated: 2026-07-14
qmd: "testing"
related:
  - "./webm.md"
---
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
        'database.connections.media.database' => 'healthcare_app_data_test',
        'database.connections.media.database' => 'ptvx_data_test',
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

- [Testing Setup Guide](../../../docs/testing-setup.md)
- [Testing Best Practices](../../../docs/testing-best-practices.md)
- [Troubleshooting Guide](../../../docs/troubleshooting.md)

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

## Baseline coverage e helper di test — 2026-08-19

Comando (la sola variabile `XDEBUG_MODE` non basta: Pest esce
`Unable to get coverage using Xdebug`):

```bash
cd laravel
php -d xdebug.mode=coverage ./vendor/bin/pest -c Modules/Media/phpunit.xml --coverage --min=0
```

| Misura | test passati | test falliti | `Call to undefined function` | coverage |
|---|---:|---:|---:|---:|
| prima | 163 | 62 | 23 | non stampata |
| dopo | **186** | **39** | **0** | non stampata |

Pest stampa la tabella di coverage **solo a exit 0**: finché la suite è rossa il numero non
esiste. I 39 rossi residui sono tutti `SQLSTATE[HY000] … no such table` su SQLite — blocco
d'ambiente, non difetto di codice: il MySQL di progetto `10.100.200.53` è irraggiungibile e
`XotBaseTestCase` ricade su `ptv_data.sqlite`, che non ha lo schema.

### Dove stanno gli helper, e perché non in `tests/Pest.php`

`Pest\Bootstrappers\BootFiles` carica `Helpers.php`, `Pest.php` ed `Expectations.php` da un
solo percorso per run — quello della root. Le funzioni dichiarate in
`Modules/Media/tests/Pest.php` non venivano mai caricate: erano 12, e le due usate dai test
di reflection producevano 23 fallimenti.

Regola attuale:

| Serve | Dove sta |
|---|---|
| assert condiviso fra moduli | `Modules\Xot\Tests\XotBasePest::` (metodo statico, PSR-4) |
| helper di dominio Media | `Modules\Media\Tests\TestCase::` (metodo statico) |
| funzione libera in `tests/Pest.php` | **mai** — `grep -c '^function '` deve dare `0` |

Cancellati perché duplicavano `XotBasePest`: `assertMediaTableHas`, `assertMediaTableMissing`,
`assertMediaListContains`, `assertMediaReflectionFilename`, `mediaReflectionSource`.
Spostati come statici su `TestCase`: `mediaTableColumns`, `mediaPayloadSet`,
`assertMediaUsesQueueableAction`, `assertMediaDeclaresStrictTypes`.

## Story 5.26 — progress verso 100% (2026-08-20)

Gate: `XDEBUG_MODE=coverage ./vendor/bin/pest -c Modules/Media/phpunit.xml --coverage --min=100`.

| Voce | Valore |
|------|--------|
| Baseline clover batch mattina | vedi tabella sotto |
| Skip offline | pattern Activity: Feature/`media-db` skip se schema assente; Unit eseguiti |
| Nuovi test | `*MassExecuteCoverageTest`, `*GapCloserCoverageTest` |
| Esclusioni `<source>` | nessuna (AC-3: perimetro = tutto `app/`) |

### Misura intermedia (pre–gap closer massivo)

| Coverage | Suite | Gate `--min=100` |
|---:|---|---|
| 59.0% | 252 pass / 34 skip / 0 fail (2 risky) | FAIL gate --min=100 (suite verde) |

Interventi 2026-08-20:
- `tests/TestCase.php`: skip offline allineato ad Activity (`$__filename` Pest).
- Unit puri / gap closer su file a 0% (Support, Rules, Columns, Widgets instantiate).
- Vietato `RefreshDatabase`; helper statici su `TestCase` (no funzioni in `tests/Support`).

Prossimo step: coprire Filament Pages/Widgets/Livewire e Actions S3/Video rimanenti con mock; rieseguire gate in **sequenza** (sqlite condiviso si locka in parallelo).

