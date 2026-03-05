# Stack Research

**Domain:** Laravel/PHP Testing and Code Coverage
**Researched:** 2026-03-05
**Confidence:** HIGH

## Recommended Stack

### Code Coverage Driver

| Technology | Version | Purpose | Why Recommended |
|------------|---------|---------|-----------------|
| PCOV | 2.x (latest stable) | Lightweight code coverage driver | 2-5x faster than Xdebug, minimal memory usage (1.36GB vs 3.32GB with phpdbg), focused solely on coverage |
| phpdbg | PHP built-in | Alternative coverage driver | Built into PHP 5.6+ but significantly slower and higher memory consumption |
| Xdebug | 3.x | Full-featured debugging + coverage | Works but 2-5x slower for coverage; useful if you need debugging capabilities |

**Recommendation:** Install PCOV as the primary coverage driver.

**Installation:**
```bash
# Using PECL (recommended)
pecl install pcov

# Or via package manager
# Ubuntu/Debian: sudo apt-get install php-pcov
# macOS: brew install pcov/tap/pcov-extension

# Verify installation
php -m | grep pcov
```

### Testing Framework

| Technology | Version | Purpose | Why Recommended |
|------------|---------|---------|-----------------|
| Pest | 2.x or 3.x | Elegant testing framework | Laravel's preferred testing framework; built on PHPUnit; provides `--coverage` and `--type-coverage` flags |
| PHPUnit | 10.x or 11.x | Underlying test engine | Required by Pest; Laravel's test harness |

**Verification:**
```bash
# Laravel's built-in coverage command
php artisan test --coverage

# Or directly with Pest
./vendor/bin/pest --coverage
```

### Type Coverage Analysis

| Technology | Version | Purpose | Why Recommended |
|------------|---------|---------|-----------------|
| pest-plugin-type-coverage | ^2.0 | Measure type declaration coverage | First-party Pest plugin; analyzes codebase without requiring tests |
| phpstan | 1.12.x or 2.x | Static analysis + type coverage | PHPStan's `--type-coverage` report shows percentage of typed declarations |
| tomasvotruba/type-coverage | ^2.0 | Strict type coverage enforcement | PHPStan extension to require minimum type coverage percentages |

**Why Type Coverage Matters:**
- Type coverage measures **explicit type declarations** (return types, property types, parameter types)
- Does NOT require tests — analyzes code statically
- Complements code coverage (100% code coverage doesn't guarantee type safety)
- PHPStan's type coverage distinguishes between "typed" vs "implicit mixed"

**Installation:**
```bash
# Pest Type Coverage plugin
composer require pestphp/pest-plugin-type-coverage --dev

# Run type coverage report
./vendor/bin/pest --type-coverage

# PHPStan type coverage
./vendor/bin/phpstan analyse --type-coverage --memory-limit=1G
```

### CI/CD Integration

| Tool | Purpose | Why Recommended |
|------|---------|-----------------|
| GitHub Actions | CI pipeline | Native integration with Laravel; free for public repos |
| Codecov | Coverage visualization | Works with Laravel; displays coverage trends; integrates with PR checks |
| phpunit-coverage-check | Enforce thresholds | GitHub Action to fail builds below minimum coverage percentage |

**GitHub Actions Workflow Example:**
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: pcov, mbstring, xml, zip
      
      - name: Install dependencies
        run: composer install --no-interaction
      
      - name: Run tests with coverage
        run: ./vendor/bin/pest --coverage --min=100
      
      - name: Upload coverage
        if: github.event_name == 'pull_request'
        uses: codecov/codecov-action@v4
        with:
          files: ./coverage.xml
          fail_ci_if_error: true
```

### Supporting Tools

| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| pestphp/pest-plugin-laravel | ^2.0 or ^3.0 | Laravel integration for Pest | Default in Laravel 11+ projects |
| infection/infection | ^0.27 or ^1.0 | Mutation testing | When you want to verify test quality beyond just line coverage |
| nunomaduro/collision | ^7 or ^8 | Better error formatting | Already included with Laravel; enhances test output |
| mockery/mockery | ^1.6 | Mocking framework | When tests need to mock external services |

## Installation

```bash
# Core dependencies (if starting fresh)
composer require --dev pestphp/pest pestphp/pest-plugin-laravel pestphp/pest-plugin-type-coverage

# Code coverage driver
pecl install pcov

# Verify installation
php -m | grep -E "pcov|xdebug"

# Run coverage tests
php artisan test --coverage --min=100

# Run type coverage
./vendor/bin/pest --type-coverage

# PHPStan with type coverage
./vendor/bin/phpstan analyse --type-coverage --memory-limit=1G
```

## Alternatives Considered

| Recommended | Alternative | When to Use Alternative |
|-------------|-------------|-------------------------|
| PCOV | Xdebug | When you need debugging capabilities in addition to coverage |
| PCOV | phpdbg | Only if PCOV is unavailable for your PHP version |
| Pest | PHPUnit native | If you prefer not to use Pest; same underlying coverage tools |
| pest-plugin-type-coverage | PHPStan --type-coverage | Both work; Pest plugin integrates better with test workflow |
| TomasVotruba/type-coverage | Built-in thresholds | When you want to enforce strict type coverage percentages in CI |

## What NOT to Use

| Avoid | Why | Use Instead |
|-------|-----|-------------|
| Xdebug for coverage only | 2-5x slower, heavier memory usage | PCOV |
| phpdbg | Slowest option, highest memory (3.32GB vs 1.36GB for PCOV) | PCOV |
| Coverage solely | Doesn't guarantee test quality — just line execution | Add mutation testing with Infection |
| 100% coverage without type safety | Runtime types can still be unsafe | Also measure type coverage |
| Coverage without CI enforcement | Easy to regress | Enforce thresholds in GitHub Actions |
| RefreshDatabase in tests | Slower, recreates DB each test | DatabaseTransactions |

## Type Coverage vs Code Coverage

**Code Coverage (line/branch/function):**
- Measures which lines of code are executed during tests
- Requires writing tests
- 100% coverage means every executable line was run at least once
- Does NOT guarantee tests are meaningful

**Type Coverage:**
- Measures percentage of code with explicit type declarations
- Does NOT require tests — static analysis
- Shows how much code relies on implicit `mixed` types
- Complements code coverage for type safety

**For LaravelPizza 100% Goals:**
- Code coverage: `./vendor/bin/pest --coverage --min=100`
- Type coverage: `./vendor/bin/pest --type-coverage`
- PHPStan level 10: `./vendor/bin/phpstan analyse --memory-limit=1G`

## Stack Patterns by Variant

**If you need debugging + coverage:**
- Use Xdebug with `xdebug.mode=coverage`
- Trade-off: 2-5x slower test runs
- Benefit: Can step-debug when issues arise

**If you only need coverage (CI/CD):**
- Use PCOV exclusively
- Fastest option
- No debugging capability

**If you want mutation testing:**
- Install `infection/infection`
- Requires PCOV or Xdebug for coverage
- Verifies tests actually catch bugs, not just execute code

**If you need 100% type coverage:**
- Use `pest-plugin-type-coverage` for quick feedback
- Use PHPStan `--type-coverage` for detailed reports
- Add `tomasvotruba/type-coverage` to enforce minimums

## Version Compatibility

| Package | PHP Version | PHPUnit/Pest Version | Notes |
|---------|-------------|----------------------|-------|
| PCOV 2.x | 7.1+ | PHPUnit 8+ | Active development |
| Pest 3.x | 8.1+ | PHPUnit 10+ | Current major |
| Pest 2.x | 7.4+ | PHPUnit 9+ | LTS for older projects |
| PHPStan 2.x | 8.1+ | — | Major update with performance improvements (2026) |
| phpunit-coverage-check | — | PHPUnit 9+ | GitHub Action |
| infection | 8.1+ | PHPUnit 10+ | Mutation testing |

**Laravel 12 + Pest 3.x + PHP 8.3:**
- All latest versions fully compatible
- PCOV recommended for coverage
- Type coverage via Pest plugin or PHPStan

## Sources

- Laravel News — "Generate Code Coverage in Laravel With PCOV" (2024-03-28)
- PCOV GitHub — Lightweight coverage driver
- Pest Documentation — Type Coverage guide
- TomasVotruba/type-coverage — Strict type coverage enforcement
- Sebastian Bergmann — "PCOV or Xdebug?" comparison
- Kizu514 — "Pcov Is Better than Phpdbg and Xdebug for Code Coverage" (2024-10-04)
- GitHub Actions Marketplace — phpunit-coverage-check action

---

*Stack research for: Laravel/PHP Testing and Code Coverage*
*Researched: 2026-03-05*
