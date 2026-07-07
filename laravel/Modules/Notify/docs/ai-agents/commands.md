# Comandi Essenziali

Vedi [index](index.md) per navigazione completa.

Vedi anche:

- [testing-commands](testing-commands.md)
- [code-quality-commands](code-quality-commands.md)
- [build-and-dev-commands](build-and-dev-commands.md)

## Testing
```bash
# Run all tests
cd laravel && php artisan test

# Run specific test file
cd laravel && php artisan test tests/Feature/ExampleTest.php

# Run test by filter/name
cd laravel && php artisan test --filter=testName

# Run tests for specific module
cd laravel && php artisan test Modules/User/tests

# Create new test
cd laravel && php artisan make:test --pest FeatureTestName

# PHPUnit directly
cd laravel && vendor/bin/phpunit
```

## Code Quality Commands
```bash
# Laravel Pint (formatting)
cd laravel && vendor/bin/pint                    # Fix formatting
cd laravel && vendor/bin/pint --dirty             # Fix only changed files

# PHPStan (static analysis)
cd laravel && vendor/bin/phpstan analyse Modules  # Usa SOLO laravel/phpstan.neon (non modificarlo)
# Vietato: --level e --generate-baseline

# PHP Insights (code quality)
cd laravel && php artisan insights               # Run insights
cd laravel && vendor/bin/phpinsights             # Direct run

# Rector (refactoring)
cd laravel && vendor/bin/rector process          # Run refactoring
cd laravel && vendor/bin/rector process --dry-run  # Preview changes
```

## Build & Development Commands
```bash
# Frontend
cd laravel && npm run dev                        # Development build
cd laravel && npm run build                      # Production build
cd laravel && composer run dev                   # Full dev setup

# Laravel optimize
cd laravel && php artisan optimize
cd laravel && php artisan config:clear
cd laravel && php artisan route:clear
cd laravel && php artisan view:clear
```

## Riferimenti

- [index](index.md)
- [workflow](workflow.md)
