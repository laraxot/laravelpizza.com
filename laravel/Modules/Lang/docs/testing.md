# Testing Rules Summary

## Regole Fondamentali dei Test

### 1. **Pest Testing Mandatory**
- **MAI** usare PHPUnit class-based (`class Test extends TestCase`)
- **SEMPRE** usare Pest functional syntax (`test()`, `it()`)
- I test devono essere scritti in formato Pest, non PHPUnit

### 2. **NO RefreshDatabase - MAI**
- **MAI** usare `use RefreshDatabase` nei test
- **MAI** usare `RefreshDatabase` trait
- Utilizzare `.env.testing` con SQLite in-memory
- Usare `DatabaseTransactions` se necessario (raro)

### 3. **Configurazione Testing**
- Tutti i test devono leggere `.env.testing`
- PHPStan usa configurazione da `phpstan.neon` (non passare livello come parametro)
- Script di conversione vanno in `bashscripts/`, non nella root di Laravel

### 4. **XotBase/LangBase Extension**
- **MAI** estendere classi Filament direttamente
- **SEMPRE** estendere `XotBase*` o `LangBase*` a seconda del modulo
- Controllare se il modulo è multilingue prima di scegliere

### 5. **property_exists() Prohibition**
- **MAI** usare `property_exists()` con modelli Eloquent
- Usare `isset()` per proprietà magiche

## Struttura dei Test

### File di Configurazione
- `.env.testing` - configurazione ottimizzata per test veloci
- `phpunit.xml` - configurazione principale
- `phpstan.neon` - configurazione PHPStan (livello già impostato)

### Directory dei Test
```
laravel/tests/              # Test principali
laravel/Modules/*/tests/    # Test dei moduli
laravel/Themes/*/tests/     # Test dei temi
```

### File Pest
Ogni modulo può avere il proprio `Pest.php` con:
- Estensioni personalizzate
- Helper functions
- Custom expectations

## Comandi Importanti

### PHPStan
```bash
# ❌ ERRATO - Non passare il livello
./vendor/bin/phpstan analyse --level=8 Modules

# ✅ CORRETTO - Usa configurazione da phpstan.neon
./vendor/bin/phpstan analyse Modules --memory-limit=-1
```

### Testing
```bash
# Run all tests
composer test

# Run Pest tests
./vendor/bin/pest

# Test specific module
cd Modules/ModuleName && ./vendor/bin/pest
```

### Conversione PHPUnit → Pest
```bash
# Script di conversione (in bashscripts/)
php bashscripts/test_conversion/convert_phpunit_to_pest.php
```

## Errori Comuni da Evitare

### ❌ Errori Gravi
1. Usare `RefreshDatabase` in qualsiasi test
2. Scrivere test PHPUnit class-based invece di Pest
3. Passare livello a PHPStan come parametro
4. Mettere script nella root di Laravel invece che in `bashscripts/`
5. Estendere classi Filament direttamente invece di XotBase/LangBase

### ✅ Best Practices
1. Usare `.env.testing` con SQLite in-memory
2. Scrivere test in formato Pest functional
3. Usare `DatabaseTransactions` invece di `RefreshDatabase`
4. Seguire la struttura esistente dei test
5. Documentare le regole nei file `docs/` dei moduli

## Documentazione

Ogni modulo e tema deve documentare:
1. Regole specifiche del modulo
2. Configurazione testing
3. Esempi di test corretti
4. Errori comuni da evitare

I file di documentazione vanno nelle cartelle `docs/` dentro ogni modulo/tema.
# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Lang module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Lang/tests/
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
- **Feature/** - Feature tests for Lang functionality
- **Unit/** - Unit tests for Lang components

## Testing Configuration

### TestCase Configuration

The Lang TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup

### Database Configuration

Lang module uses the following database connections:
- `lang` - Main Lang module connection
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

Configure Lang-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Lang module
    config(['lang.default_locale' => 'it']);
    config(['lang.fallback_locale' => 'en']);
}
```

## Test Examples

### Basic Lang Test

```php
test('translation can be created', function () {
    $translation = \Modules\Lang\Models\Translation::create([
        'key' => 'test.key',
        'value' => 'Test translation',
        'locale' => 'it',
        'group' => 'messages',
    ]);
    
    expect($translation)->toBeInstanceOf(\Modules\Lang\Models\Translation::class);
    expect($translation->key)->toBe('test.key');
});
```

### Configuration Test

```php
test('lang configuration is loaded', function () {
    $langConfig = config('lang');
    
    expect($langConfig['default_locale'])->toBe('it');
    expect($langConfig['fallback_locale'])->toBe('en');
});
```

### Service Provider Test

```php
test('lang service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Lang\Providers\LangServiceProvider::class))->toBeTrue());
});
```

## Testing Commands

### Running Tests

```bash
# Run all Lang module tests
./vendor/bin/pest Modules/Lang/tests

# Run tests with coverage
./vendor/bin/pest Modules/Lang/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Lang/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Lang module
./vendor/bin/phpstan analyze Modules/Lang

# Run PHPMD on Lang module
./vendor/bin/phpmd Modules/Lang/src

# Run PHPInsights on Lang module
./vendor/bin/phpinsights analyse Modules/Lang
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Lang configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['lang.default_locale' => 'it']);
    config(['lang.fallback_locale' => 'en']);
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
        'database.connections.lang.database' => 'quaeris_data_test',
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
test('translation can be created', function () {
    $translation = \Modules\Lang\Models\Translation::create([
        'key' => 'test.key',
        'value' => 'Test translation',
        'locale' => 'it',
        'group' => 'messages',
        'namespace' => 'app',
    ]);
    
    expect($translation)->toBeInstanceOf(\Modules\Lang\Models\Translation::class);
    expect($translation->key)->toBe('test.key');
    expect($translation->value)->toBe('Test translation');
    expect($translation->locale)->toBe('it');
    expect($translation->group)->toBe('messages');
    expect($translation->namespace)->toBe('app');
});
```

### Service Tests

```php
test('lang service can translate text', function () {
    $service = new \Modules\Lang\Services\LangService();
    
    $translation = $service->translate('test.key', 'it');
    
    expect($translation)->toBe('Test translation');
});
```

### API Tests

```php
test('lang api can get translations', function () {
    \Modules\Lang\Models\Translation::create([
        'key' => 'test.key',
        'value' => 'Test translation',
        'locale' => 'it',
        'group' => 'messages',
    ]);
    
    $response = $this->get('/api/lang/translations/it/messages');
    $response->assertStatus(200);
    $response->assertJson([
        'test.key' => 'Test translation',
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

Following these guidelines will ensure your Lang module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

---

*Last updated: January 2025*