# 2. Build / Lint / Test Commands

### Running Tests
```bash
# All tests
php artisan test

# Single test file
php artisan test tests/Feature/UserTest.php

# Single test method
php artisan test --filter=TestMethodName

# With coverage
php artisan test --coverage

# Parallel testing
php artisan test --parallel

# Compact output
php artisan test --compact
```

### PHPStan (Static Analysis - Level 10)
```bash
# Full analysis
./vendor/bin/phpstan analyze

# Analyze specific module
./vendor/bin/phpstan analyze Modules/User --level=10

# Analyze single file
./vendor/bin/phpstan analyze Modules/User/Models/User.php --level=10

# Clear cache
./vendor/bin/phpstan clear-result-cache
```

### Laravel Pint (Code Formatting - PSR-12)
```bash
# Format all
./vendor/bin/pint

# Format specific module
./vendor/bin/pint Modules/User/

# Check without fixing
./vendor/bin/pint --test
```

### PHP Insights (Code Quality)
```bash
# Full analysis
./vendor/bin/phpinsights analyze

# Specific module
./vendor/bin/phpinsights analyze Modules/User
```

### Development Server
```bash
# Full dev (serve + queue + logs + vite)
composer dev

# Individual
php artisan serve
npm run dev
```

### Composer & Modules (IMPORTANT!)
```bash
# From laravel/ directory - MUST run after adding new packages
composer go

# This merges all Modules/*/composer.json dependencies
# NEVER add dependencies to laravel/composer.json directly!
# Always add to the specific module's composer.json
```

### Theme Development
```bash
cd laravel/Themes/Meetup
npm install
npm run dev      # Development
npm run build    # Production
npm run copy    # Copy to public_html (REQUIRED after build)
```

### Cache Clearing
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan filament:optimize-clear
```

---

