# Pest Coverage Guide

## Overview

This guide documents Pest PHP's code coverage and type coverage features, as implemented in <nome progetto>. Coverage is measured using XDebug 3.0+ or PCOV, and must reach **100% for all modules and themes**.

## Code Coverage

### Running Coverage Reports

**Generate coverage report for all tests:**
```bash
cd laravel
php artisan test --coverage
```

**Generate coverage with minimum threshold enforcement:**
```bash
php artisan test --coverage --min=100
```

**Generate coverage with exact threshold:**
```bash
php artisan test --coverage --exactly=100
```

**Generate specific format reports:**
```bash
# HTML report (viewable in browser)
php artisan test --coverage-html=coverage-report/

# Clover XML (for CI/CD)
php artisan test --coverage-clover=coverage.xml

# Text file
php artisan test --coverage-text=coverage.txt

# Cobertura XML
php artisan test --coverage-cobertura=cobertura.xml
```

### Interpreting Coverage Reports

The coverage report lists all source files included in `phpunit.xml` `<source><include>`:
- **% coverage percentage** - Lines of code executed during tests
- **Red lines** - Uncovered code that was not executed
- **Multiple uncovered lines** - Displayed as ranges (e.g., `52..60`)

### Configuration (phpunit.xml)

The project's `phpunit.xml` is pre-configured:

```xml
<source>
    <include>
        <directory>app</directory>
        <directory>Modules/*/app</directory>
        <directory>Themes/*/app</directory>
    </include>
</source>
```

**Excluded from coverage:**
- `config/` - Configuration files (not testable)
- `database/` - Migrations (database schema, not business logic)
- `resources/` - Views, assets (tested via feature tests)
- `routes/` - Route definitions (tested via feature tests)
- `tests/` - Test files themselves

## Type Coverage

### What is Type Coverage?

Type Coverage measures the percentage of code with complete type declarations. This complements code coverage by ensuring:
- All parameters have declared types
- All return types are declared
- No use of `mixed` type (except as last resort)
- Complete strictness via `declare(strict_types=1)`

### Installation

The Type Coverage plugin is **already installed** in composer.json:

```bash
composer require pestphp/pest-plugin-type-coverage --dev
```

### Running Type Coverage

**Generate type coverage report:**
```bash
cd laravel
php artisan test --type-coverage
```

**Show only files with incomplete coverage (compact output):**
```bash
php artisan test --type-coverage --compact
```

**Enforce minimum type coverage threshold:**
```bash
php artisan test --type-coverage --min=100
```

**Generate JSON report:**
```bash
php artisan test --type-coverage --type-coverage-json=type-coverage.json
```

### Interpreting Type Coverage Reports

The report shows missing type declarations:
- `rt31` - Missing return type on line 31
- `pa31` - Missing parameter type on line 31
- `pt31` - Missing property type on line 31
- Yellow highlight - Indicates missing or incomplete type declaration

### Ignoring Type Coverage Issues

If a type declaration cannot be added (rare), use the `@pest-ignore-type` annotation:

```php
protected $except = [ // @pest-ignore-type
    // ...
];
```

**Important**: This should be used only as a **last resort** and requires documentation of why it was necessary.

## Configuration in phpunit.xml

No additional configuration is required for type coverage—it analyzes all PHP files directly.

## Laravel Modules Integration

The project uses `nwidart/laravel-modules`. Test discovery is configured with wildcards:

```xml
<testsuites>
    <testsuite name="Unit">
        <directory>tests/Unit</directory>
        <directory>Modules/*/tests/Unit</directory>
        <directory>Themes/*/tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory>tests/Feature</directory>
        <directory>Modules/*/tests/Feature</directory>
        <directory>Modules/*/tests/Integration</directory>
        <directory>Modules/*/tests/Performance</directory>
        <directory>Themes/*/tests/Feature</directory>
    </testsuite>
</testsuites>
```

### Running Coverage for a Single Module

```bash
# Coverage for Meetup module
php artisan test Modules/Meetup --coverage --min=100

# Coverage for User module
php artisan test Modules/User --coverage --min=100
```

### Running Coverage for a Single Test File

```bash
php artisan test tests/Feature/YourTest.php --coverage
```

## 100% Coverage Requirements

### For <nome progetto>

- **Code Coverage**: 100% across all modular app code (`app/`, `Modules/*/app`, `Themes/*/app`)
- **Type Coverage**: 100% for all source files (all parameters, returns, and properties typed)
- **Minimum Thresholds**: Enforced via CI/CD (both `--min=100` and `--type-coverage --min=100`)

### Coverage Targets by Module

Each module MUST achieve:
1. **All business logic in `app/Actions/`** - 100% coverage via unit tests
2. **All Eloquent models in `app/Models/`** - 100% coverage
3. **All Filament resources in `app/Filament/`** - 100% coverage via feature tests
4. **All custom traits and helpers** - 100% coverage

### What NOT to Test

The following are **excluded** from coverage requirements:
- Framework boilerplate (ServiceProviders, route definitions, config)
- Database migrations (structure is tested via schema verification)
- View rendering (tested via feature test assertions on HTML/content)
- Blade components (functional integration via feature tests, not direct component unit tests)

## Best Practices

### 1. Test-Driven Development (TDD)

Write tests BEFORE code:
1. Red: Write failing test
2. Green: Write minimum code to pass
3. Refactor: Improve code, verify test still passes

### 2. Use DatabaseTransactions

Never use `RefreshDatabase` trait. Use `DatabaseTransactions` for test isolation:

```php
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class YourTest extends TestCase
{
    use DatabaseTransactions;
    
    #[Test]
    public function it_does_something(): void
    {
        // Test code
    }
}
```

### 3. Test One Thing

Each test should verify a single behavior:

```php
// ✅ Good
#[Test]
public function it_creates_event(): void { ... }

#[Test]
public function it_validates_event_title(): void { ... }

// ❌ Bad
#[Test]
public function it_handles_events(): void {
    // Tests create, validate, delete all in one
}
```

### 4. Arrange-Act-Assert

Follow the AAA pattern:

```php
#[Test]
public function it_deletes_event(): void
{
    // Arrange
    $event = Event::factory()->create();
    
    // Act
    app(DeleteEventAction::class)->execute($event);
    
    // Assert
    $this->assertDatabaseMissing('events', ['id' => $event->id]);
}
```

### 5. Use Factories and Seeders

Never hardcode test data:

```php
// ✅ Good
$user = User::factory()->create(['name' => 'John']);

// ❌ Bad
$user = User::create(['id' => 1, 'name' => 'John', 'email' => '...']);
```

## Monitoring and Reporting

### GitHub Actions Integration

Coverage reports are generated in CI/CD. View via:
1. GitHub Actions workflow runs
2. Download artifacts (coverage-report/)
3. View HTML coverage dashboard

### Local Coverage Dashboard

Generate HTML coverage for local review:

```bash
php artisan test --coverage-html=coverage-report/
open coverage-report/index.html
```

## Troubleshooting

### Coverage Not Increasing

1. Verify XDebug is installed: `php -v`
2. Check `XDEBUG_MODE=coverage` is set
3. Run `php artisan test --coverage` (not just `php artisan test`)
4. Verify test actually exercises the code (add `dd()` temporarily)

### Type Coverage Not Detected

1. Ensure file has `declare(strict_types=1);`
2. Run `php artisan test --type-coverage --compact` to see which files are missing types
3. Add type declarations to all parameters and returns
4. Re-run type coverage check

### Tests Pass But Coverage Low

1. Tests exist but don't execute the target code
2. Add assertions that actually verify behavior
3. Use debugger to trace code path: add `xdebug_break();` and run with debugger

## References

- [Pest Documentation - Test Coverage](https://pestphp.com/docs/test-coverage)
- [Pest Documentation - Type Coverage](https://pestphp.com/docs/type-coverage)
- [Laravel Modules - Testing](https://laravelmodules.com/docs/12/advanced/tests)
- [XDebug Installation](https://xdebug.org/docs/install/)
