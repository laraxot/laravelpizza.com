# Development Workflow

## Essential Commands

### Working Directory
```bash
# Working directory
cd /var/www/html/ptvx/laravel
```

### Complete Setup and Serve
```bash
# Complete setup (install, optimize, serve)
composer go

# Optimize Filament and Laravel
composer optimize

# Start development server
php artisan serve
```

### Code Quality Checks
```bash
# Static analysis (Level 10)
./vendor/bin/phpstan analyze

# Code formatting
./vendor/bin/pint

# Code upgrades
./vendor/bin/rector process
```

### Testing
```bash
# Run all tests
php artisan test

# Run specific module
php artisan test --filter=User

# Run single test file
php artisan test tests/Feature/UserTest.php

# Run with coverage
php artisan test --coverage

# Pest testing
./vendor/bin/pest
./vendor/bin/pest --filter=UserTest
```

### Module Management
```bash
# List all modules
php artisan module:list

# Enable/disable modules
php artisan module:enable ModuleName
php artisan module:disable ModuleName
```

### Caching
```bash
# Config cache
php artisan config:cache

# Route cache
php artisan route:cache

# View cache
php artisan view:cache

# Filament cache
php artisan filament:optimize
```

## Pre-Commit Checklist

Before every commit, verify:

- [ ] Code extends Xot base classes (not Filament directly)
- [ ] No hardcoded labels, placeholders, or helper text
- [ ] No `property_exists()` with Eloquent models
- [ ] All files have `declare(strict_types=1);`
- [ ] All methods have explicit return types
- [ ] Namespaces don't include 'app' segment
- [ ] Models extend module-specific `BaseModel`
- [ ] Migrations extend `XotBaseMigration` and have no `down()` method
- [ ] DTOs use `readonly` properties
- [ ] PHPStan Level 10 passes: `./vendor/bin/phpstan analyze`
- [ ] Code formatted: `./vendor/bin/pint`
- [ ] Tests pass: `php artisan test`

## Additional Notes

### Multi-Database Support
Some modules use separate database connections. Check model `$connection` property.

### Queue System
Actions using `QueueableAction` can be queued:
```php
app(CreateUserAction::class)->onQueue()->execute($userData);
```