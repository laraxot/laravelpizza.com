# AGENTS.md - LaravelPizza Development Guide

This file provides guidance for agentic coding agents operating in the LaravelPizza repository.

---

## 1. Project Overview

**LaravelPizza** is a modernized conversion of laravelpizza.com - a community platform for Laravel developer meetups.
- **Tech Stack**: Laravel 11, Filament 5, Livewire/Volt, Folio, Tailwind CSS, Alpine.js
- **Architecture**: Modular (nwidart/laravel-modules), CMS-driven pages via JSON
- **PHP**: 8.2+ required, strict typing enforced via PHPStan Level 10
- **Database**: Multi-connection (default + user for tenant data)

---

## 2. Build / Lint / Test Commands

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

## 3. Code Style Guidelines

### PHP Strict Types
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;
```

### Import Conventions
- Use FQCN (Fully Qualified Class Names)
- Group imports: internal Laravel → external packages → custom modules
- Sort alphabetically within groups
```php
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Profile;
use Spatie\QueueableAction\QueueableAction;
```

### Naming Conventions
| Element | Convention | Example |
|---------|------------|---------|
| Models | PascalCase | `User`, `EventRegistration` |
| Controllers | PascalCase + Controller suffix | `UserController` |
| Actions | Verb + Action suffix | `CreateEventAction` |
| Migrations | `create_{table}_table.php` | `2024_01_01_000000_create_users_table.php` |
| Blade Components | kebab-case | `language-switcher.blade.php` |
| Routes | kebab-case | `user-profile` |
| Tests | `{Class}Test.php` | `UserTest.php` |
| Variables | camelCase | `$userProfile` |
| Constants | UPPER_SNAKE_CASE | `MAX_RETRY_COUNT` |

### Type Declarations
- Always use return types
- Use union types where appropriate (PHP 8+)
- Nullable types with `?Type`
```php
public function execute(UserData $data): ?User
public function getName(): string|null
public function setConfig(array $config): void
```

### Model Conventions
- Use `casts()` method (NOT `$casts` property)
- Use `HasUuids`, `SoftDeletes`, `HasFactory` traits
- Define `$fillable` as typed array
```php
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```

### Error Handling
- Use exceptions with meaningful messages
- Throw in constructors only if critical
- Catch specific exceptions
- Never suppress errors with `@`

---

## 4. Critical Architecture Rules

### Translation Management - AUTOMATIC ONLY!
**CRITICAL RULE: NEVER use ->label(), ->placeholder(), ->helperText() manually!**

The Laraxot framework handles all translations automatically via:
- `LangServiceProvider` - Automatically configures all Filament components
- `AutoLabelAction` - Generates translation keys automatically

**Translation Key Pattern:**
```
{module}::{widget}.fields.{field}.{type}
```
Examples:
- `gdpr::register.fields.first_name.label`
- `gdpr::register.fields.first_name.placeholder`
- `gdpr::register.fields.first_name.helper_text`

**Translation File Structure:**
```php
// Modules/ModuleName/lang/{locale}/{widget}.php
return [
    'fields' => [
        'field_name' => [
            'label' => 'Field Label',
            'placeholder' => 'Placeholder text',
            'helper_text' => 'Helper text description',
        ],
    ],
];
```

**VIOLATION EXAMPLES (NEVER DO THIS):**
```php
// ❌ WRONG - Manual label()
TextInput::make('name')->label('Name')

// ❌ WRONG - Manual placeholder()
TextInput::make('email')->placeholder('Enter email')

// ❌ WRONG - Manual helperText()
TextInput::make('password')->helperText('Choose a strong password')

// ❌ WRONG - Manual __() translation
TextInput::make('name')->__('module::field.label')
```

**CORRECT PATTERN:**
```php
// ✅ CORRECT - No manual methods
TextInput::make('name')
TextInput::make('email')
TextInput::make('password')
```

The `LangServiceProvider` automatically:
1. Detects the component class from the backtrace
2. Generates the correct translation key
3. Applies the label, placeholder, and helper_text from translation files
4. Falls back to field name if translation is missing

**IMPORTANT: This applies to BOTH Filament Resources AND Livewire Components using Filament Forms!**

When using Filament Form components in Livewire/Volt:
```php
// ✅ CORRECT - Let LangServiceProvider handle translations automatically
TextInput::make('email')->required()

// ❌ WRONG - Manual label/placeholder overrides automatic system
TextInput::make('email')->label(__('Email'))->placeholder(__('Enter email'))
```

**Translation File Naming:**
- For a component `Modules\User\Http\Livewire\Auth\Register`, create:
  - `Modules/User/lang/it/register.php`
  - `Modules/User/lang/en/register.php`

The key generated will be `user::register.fields.email.label`.

### Frontend (Frontoffice) - NO Controllers!
**ALWAYS use:**
- Laravel Folio (file-based routing)
- Livewire Volt (single-file components)
- CMS-Driven Pages (JSON files in `config/local/laravelpizza/database/content/pages/`)

**NEVER use:**
- Traditional controllers for public pages
- Routes in web.php for dynamic content
- Blade files for page templates (use JSON + components)

### Backend (Admin) - Filament Only
- All admin resources extend XotBase classes
- NO raw Filament extensions

### Module Structure
```
Modules/{ModuleName}/
├── app/
│   ├── Actions/       # Spatie QueueableAction
│   ├── Datas/         # Spatie Data DTOs
│   ├── Filament/      # Admin resources (extend XotBase)
│   ├── Models/        # Eloquent models (extend BaseModel)
│   └── Services/      # (AVOID - use Actions instead)
├── database/migrations/
├── docs/
├── tests/
└── composer.json
```

### Service Provider Pattern (MINIMAL!)
```php
// CORRECT - Minimal
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

### Many-to-Many Relationships
**ALWAYS use `belongsToManyX()`** (NOT `belongsToMany()`)
```php
// CORRECT
$this->belongsToManyX(EventPerformer::class);

// WRONG
$this->belongsToMany(EventPerformer::class);
```

### Localization URLs
```php
// CORRECT
LaravelLocalization::localizeUrl('/path')
LaravelLocalization::getLocalizedURL($locale, null, [], true)

// WRONG
url('/en/path')
```

---

## 5. Database & Models

### Database Config (Laravel 12 Standard)
- Base config: `config/database.php`
- Tenant config: `config/local/{tenant}/database.php`
- NO per-module connections hardcoded
- Module connections added dynamically via `TenantServiceProvider::registerDB()`

### Migrations
- One migration per table creation
- Schema changes use new migration files: `add_{column}_to_{table}.php`
- Use `XotBaseMigration` with `tableCreate()` and `tableUpdate()` methods

---

## 6. Filament (Admin) Patterns

- ALWAYS extend XotBase classes (NOT raw Filament classes)
- Use AutoLabelAction (NEVER use `->label()`)
- Translation keys: `module::resource.field.attribute`
- NEVER hardcode labels - use auto-generated translations

| Filament Class | Use Instead |
|----------------|-------------|
| `Resource` | `XotBaseResource` |
| `Page` | `XotBasePage` |
| `Widget` | `XotBaseWidget` |

---

## 7. SVG Icons

- Store SVGs in `Modules/Meetup/resources/svg/`
- Reference via: `<x-filament::icon icon="meetup-{name}" />`
- NO inline SVGs in Blade files

---

## 8. Testing Guidelines

- Use Pest PHP
- Use `DatabaseTransactions` (NOT `RefreshDatabase`)
- Test business logic via Actions
- Feature tests for user flows

---

## 9. Cursor Rules Summary

From `.cursorrules`:
- **PHP**: Enable type checking, code completion, refactoring
- **Frontend**: Enable hot reload, CSS/JS processing
- **Database**: Enable schema exploration, migration tracking
- **Git**: Enable commit/branch/merge assistance
- **Testing**: Enable test discovery, execution, coverage
- **Security**: Enable vulnerability scanning, quality checks
- **Performance**: Enable benchmarking, profiling

---

## 10. File Patterns

### Include
- `**/*.php`
- `**/*.blade.php`
- `**/*.css`
- `**/*.js`
- `**/*.json`
- `**/*.md`

### Exclude
- `**/vendor/**`
- `**/node_modules/**`
- `**/storage/**`
- `**/bootstrap/cache/**`
- `**/.git/**`

---

## 11. Pre-Commit Checklist

Before committing:
- [ ] PHPStan Level 10 passes
- [ ] Pint formatting applied
- [ ] Tests pass
- [ ] No hardcoded strings (use translations)
- [ ] XotBase classes used (not raw Filament)
- [ ] No Controllers for frontoffice
- [ ] JSON pages for dynamic content

---

## Key Documentation References

- `laravel/CLAUDE.md` - Main project rules
- `laravel/Modules/Xot/docs/xotbase-extension-rules.md` - XotBase patterns
- `laravel/Modules/Cms/docs/content-blocks-system.md` - CMS blocks
- `laravel/Modules/Lang/docs/laravel-localization-mcamara-reference.md` - i18n
- `Themes/Meetup/docs/theme-improvement-roadmap.md` - Theme guide
