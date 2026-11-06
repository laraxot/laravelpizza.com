---
issues: []
discussions: []
title: "Testing Documentation"
module: "Tenant"
type: concept
tags: [testing]
created: 2026-07-14
updated: 2026-10-20
qmd: "testing"
related:
  - "./phpstan-corrections-january.md"
status: draft
---
# Testing Documentation

## Stories PHPStan attive

- [TENANT-7.1: boundary Sushi](./stories/7.1.phpstan-sushi-boundaries.story.md) possiede
  trait, Action e consumer domain.
- [TENANT-7.2: contratti dei test harness](./stories/7.2.phpstan-test-harness-contracts.story.md)
  possiede i 40 findings residui nei test di configurazione, Sushi e coverage.

- [Regressione dei test dopo il pull, 2026-10-20](./stories/phpstan-test-wave-tenant.story.md):
  `tests/TestCase.php` e 9 file di test erano tornati a una generazione senza helper e
  senza tipi (733 errori); ripristinata la generazione tipizzata, 0 errori sul modulo.

### Esito TENANT-7.2

La baseline cold di 40 findings è stata portata a zero. Config e resolver vengono ristretti
prima degli offset, le fixture Sushi dichiarano value types reali, le funzioni fallibili
usano `Safe\` e gli attributi Eloquent passano da `setAttribute()`/`getAttribute()`.

Disposition: **75 test mantenuti, 0 file test cancellati**. La tautologia sull'ID Sushi è
diventata un'asserzione sull'ID realmente assegnato; input impossibili (`domain = null`,
row JSON scalare passata a `saveToJson`) sono stati rimossi dai test senza allargare i
contratti applicativi. Il gate mirato produce **75 pass e 311 asserzioni**.

Famiglia A (story 4.26): le fixture e le classi anonime **estendono l'host reale del trait**,
non `Model` nudo: `SushiToCsv` → `Sigma\Models\WebService`, `SushiToPhpArray` →
`User\Models\SocialProvider`, `SushiToJsons` → `Tenant\Models\BaseModelJsons`. I test
restano in memoria (`forceFill` / file tmp + mock di `GetTenantFilePathAction`).
`setAttribute()` nel trait resta il contratto Eloquent delle colonne dinamiche.

### Helper di `Modules\Tenant\Tests\TestCase`

I test Pest del modulo chiamano metodi statici di `TestCase`, non funzioni libere
(`tests/Pest.php` e' solo un commento: Pest legge un solo `Pest.php`, quello della root).
I principali: `mockAppService($classe, $callback)` (mock Mockery registrato nel container
con `app()->instance`), `expectMockery($mock, $metodo)` (espettativa tipizzata),
`sushiModel()` / `sushiJsonPath()` / `sushiTestData()` / `sushiRowById()` (fixture del modello
Sushi di test), `createTenant()` / `tenantModel()`, `setServerNameForTenantTest()`,
`tenantDbUnavailable()` (oggi `true`: i test che scrivono sul DB tenant si saltano) e
`skipCurrentTest()`. Un helper nuovo va qui, tipizzato, non in un file `Support`.

## Overview

This document provides testing guidelines and examples for the Tenant module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Tenant/tests/
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
- **Feature/** - Feature tests for Tenant functionality
- **Unit/** - Unit tests for Tenant components

## Testing Configuration

### TestCase Configuration

The Tenant TestCase extends the base testing configuration and provides:
- Database connection setup
- Module-specific configuration
- Test environment setup
- Database cleanup

### Database Configuration

Tenant module uses the following database connections:
- `tenant` - Main Tenant module connection
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

Configure Tenant-specific settings:

```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configure Tenant module
    config(['tenant.default_tenant_id' => 1]);
    config(['tenant.cache_enabled' => false]);
}
```

## Test Examples

### Basic Tenant Test

```php
test('tenant can be created', function () {
    $tenant = \Modules\Tenant\Models\Tenant::create([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
        'status' => 'active',
        'settings' => ['key' => 'value'],
    ]);
    
    expect($tenant)->toBeInstanceOf(\Modules\Tenant\Models\Tenant::class));
    expect($tenant->name)->toBe('Test Tenant');
});
```

### Configuration Test

```php
test('tenant configuration is loaded', function () {
    $tenantConfig = config('tenant');
    
    expect($tenantConfig['default_tenant_id'])->toBe(1);
    expect($tenantConfig['cache_enabled'])->toBe(false);
});
```

### Service Provider Test

```php
test('tenant service provider is registered', function () {
    $app = app();
    
    expect($app->bound(\Modules\Tenant\Providers\TenantServiceProvider::class))->toBeTrue());
});
```

## Testing Commands

### Running Tests

```bash
# Run all Tenant module tests
./vendor/bin/pest Modules/Tenant/tests

# Run tests with coverage
./vendor/bin/pest Modules/Tenant/tests --coverage

# Run tests with verbose output
./vendor/bin/pest Modules/Tenant/tests --verbose
```

### Quality Checks

```bash
# Run PHPStan on Tenant module
./vendor/bin/phpstan analyze Modules/Tenant

# Run PHPMD on Tenant module
./vendor/bin/phpmd Modules/Tenant/src

# Run PHPInsights on Tenant module
./vendor/bin/phpinsights analyse Modules/Tenant
```

## Testing Issues and Solutions

### 1. Configuration Issues

**Problem**: Tenant configuration not loaded

**Solution**: Ensure proper configuration in TestCase:

```php
protected function setUp(): void
{
    parent::setUp();
    
    config(['tenant.default_tenant_id' => 1]);
    config(['tenant.cache_enabled' => false]);
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
        'database.connections.tenant.database' => '<nome progetto>_data_test',
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

- [Laravel 13.x Testing Documentation](https://laravel.com/docs/12.x/testing)
- [Pest Installation Guide](https://pestphp.com/docs/installation)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)

### Internal Resources

- [Testing Setup Guide](../../../docs/testing-setup.md)
- [Testing Best Practices](../../../docs/testing-best-practices.md)
- [Troubleshooting Guide](../../../docs/troubleshooting.md)
- [Troubleshooting Guide](../../../../docs/troubleshooting.md)

## Testing Examples

### Model Tests

```php
test('tenant can be created', function () {
    $tenant = \Modules\Tenant\Models\Tenant::create([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
        'status' => 'active',
        'settings' => ['key' => 'value'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    expect($tenant)->toBeInstanceOf(\Modules\Tenant\Models\Tenant::class));
    expect($tenant->name)->toBe('Test Tenant'));
    expect($tenant->domain)->toBe('test.example.com');
    expect($tenant->status)->toBe('active');
    expect($tenant->settings)->toBe(['key' => 'value']);
});
});
```

### Service Tests

```php
test('tenant service can create tenant', function () {
    $service = new \Modules\Tenant\Services\TenantService();
    
    $tenant = $service->createTenant([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
        'status' => 'active',
        'settings' => ['key' => 'value'],
    ]);
    
    expect($tenant)->toBeInstanceOf(\Modules\Tenant\Models\Tenant::class));
    expect($tenant->name)->toBe('Test Tenant'));
});
```

### API Tests

```php
test('tenant api can create tenant', function () {
    $tenantData = [
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
        'status' => 'active',
        'settings' => ['key' => 'value'],
    ];
    
    $response = $this->post('/api/tenants', $tenantData);
    $response->assertStatus(201);
    $response->assertJson([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
        'status' => 'active',
        'settings' => ['key' => 'value'],
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

Following these guidelines will ensure your Tenant module tests are:
- Fast and reliable
- Maintainable and scalable
- Comprehensive and thorough
- Consistent and robust

Remember: Good tests are the foundation of reliable software development.

## Coverage: gate 100%

**Perché:** il tenant risolve path, config, morph map e persistenza Sushi per-tenant.
Senza coverage completa sui resolver/action/trait, un tenant sbagliato può leggere
config di un altro dominio o scrivere JSON nel path sbagliato.

| Perimetro | Coverage | Gate `--min=100` | Suite |
|-----------|---------:|:----------------:|-------|
| `./app` completo, nessun exclude | **100,0 %** | ✅ PASS | 138 pass, 32 skip, 2 risky |

```bash
cd laravel
XDEBUG_MODE=coverage ./vendor/bin/pest -c Modules/Tenant/phpunit.xml --coverage --min=100
```

### Strategia

1. Pest only, `uses(TestCase::class)`: **no** `RefreshDatabase` (sqlite tenant condiviso → skip su lock).
2. Unit: Actions, Resolvers, Providers, Policy, trait Sushi via **named subclasses** in `tests/Unit/Fixtures/`.
3. Assertion reali; niente `@codeCoverageIgnore`.
4. Feature/Integration/Performance: skip condizionato se DB/fixture indisponibili.

Riferimenti: [Xot coverage.md](../../Xot/docs/coverage.md).

---

*Last updated: August 2026*
