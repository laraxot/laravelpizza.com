# Copilot Instructions for LaravelPizza

This file helps Copilot sessions understand the architecture and conventions of this Laravel project.

## Project Overview

**LaravelPizza** is an enhanced version of https://laravelpizza.com/, a platform for Laravel meetups and tech communities. It emphasizes extreme architectural discipline with a modular architecture (Laraxot), strict type safety (PHPStan Level 10), and modern Laravel technologies (Folio + Volt for frontend, Filament for admin).

**Key characteristics:**
- **14 modular components** (Modules/) with 0 PHPStan Level 10 errors
- **Folio + Volt only** for frontend (NO traditional controllers/routes for public pages)
- **CMS-driven content** using JSON files and block-based components
- **XotBase pattern** for all Filament extensions
- **100% Pest test coverage** required for all modules

## Build, Lint, and Test Commands

### Tests
```bash
# All tests (from laravel/ directory)
php artisan test

# Single file
php artisan test tests/Feature/UserTest.php

# Filter by test name
php artisan test --filter=TestMethodName

# With coverage report
php artisan test --coverage

# Generate coverage reports for all modules (outputs to Modules/<Module>/docs/coverage.md)
bash bashscripts/testing/generate-coverage.sh

# Parallel (faster)
php artisan test --parallel
```

**Critical:** Tests must use `.env.testing` and point to test database (e.g., `laravelpizza_data_test`). `RefreshDatabase` trait is forbidden; use `DatabaseTransactions` instead. Do NOT use `migrate:fresh`.

### Code Quality
```bash
# PHPStan Level 10 (0 errors required)
./vendor/bin/phpstan analyze

# Specific module
./vendor/bin/phpstan analyze Modules/Meetup

# Format code (PSR-12)
./vendor/bin/pint
./vendor/bin/pint Modules/Meetup/  # Single module

# Check formatting without fixing
./vendor/bin/pint --test

# Quality metrics
./vendor/bin/phpinsights analyze
./vendor/bin/phpinsights analyze Modules/Meetup
```

### Development
```bash
# Full dev environment (Laravel server + queue + logs + Vite)
composer dev

# Individual services
php artisan serve
npm run dev

# From laravel/Themes/Meetup (REQUIRED after CSS/JS changes!)
npm install
npm run build
npm run copy    # Copies to public_html/themes/Meetup
```

### Dependency Management
```bash
# From laravel/ directory (MUST run after adding packages to module composer.json)
composer go
# This merges all Modules/*/composer.json dependencies via wikimedia/composer-merge-plugin

# NEVER add dependencies to laravel/composer.json directly
# ALWAYS add to the specific module's composer.json instead
```

## High-Level Architecture

### Directory Structure
```
laravel/
├── Modules/                          # 14 business logic modules
│   ├── Activity/                    # Event sourcing & audit logging
│   ├── Cms/                         # Content management with block system
│   ├── Geo/                         # Geographic & location features
│   ├── Job/                         # Job scheduling & monitoring
│   ├── Lang/                        # Internationalization (mcamara/laravel-localization)
│   ├── Meetup/                      # Core meetup business logic
│   ├── Media/                       # Media upload & processing
│   ├── Notify/                      # Multi-channel notifications
│   ├── Tenant/                      # Multi-tenancy & config resolution
│   ├── UI/                          # Shared Blade components & widgets
│   ├── User/                        # Auth, RBAC, OAuth
│   ├── Xot/                         # Laraxot framework core (XotBase, traits, services)
│   ├── Gdpr/                        # GDPR compliance
│   └── Seo/                         # SEO optimization & metadata
├── Themes/
│   └── Meetup/                      # Frontend theme (Tailwind + Alpine)
├── config/local/{tenant}/           # Tenant-specific config
├── tests/                           # Root-level tests
└── Modules/{Module}/
    ├── app/Actions/                 # Spatie QueueableActions (business logic)
    ├── app/Datas/                   # Spatie Data DTOs
    ├── app/Filament/                # MUST extend XotBase* classes
    ├── app/Models/                  # Eloquent models (extend XotBaseModel)
    ├── database/migrations/         # One table = one migration (Laraxot philosophy)
    ├── docs/                        # Module documentation
    ├── lang/                        # Translation files
    ├── resources/views/             # Blade views for this module
    └── tests/                       # Pest tests (100% coverage required)
```

### Frontend Architecture (Folio + Volt)
```
Themes/Meetup/
├── resources/views/pages/[slug].blade.php     # Catch-all Folio route for dynamic content
├── resources/views/components/blocks/         # Block components (hero, events, etc.)
├── resources/views/layouts/                   # Page layouts (main, app, guest)
├── resources/css/app.css                      # Tailwind styles
├── resources/js/app.js                        # Alpine.js app
└── npm run build && npm run copy              # REQUIRED after changes
```

**Flow:** JSON page config → Folio `[slug].blade.php` → `<x-page />` component → block components → Volt/Alpine rendering

## Key Conventions

### Critical Rule: XotBase Inheritance
- **NEVER** extend Filament classes directly
- **ALWAYS** extend XotBase equivalents:
  - `Filament\Resources\Resource` → `Modules\Xot\Filament\Resources\XotBaseResource`
  - `Filament\Pages\Page` → `Modules\Xot\Filament\Pages\XotBasePage`
  - `Filament\Widgets\Widget` → `Modules\Xot\Filament\Widgets\XotBaseWidget`

### Critical Rule: Many-to-Many Relations
- **NEVER** use `$this->belongsToMany()`
- **ALWAYS** use `$this->belongsToManyX()` (trait in XotBaseModel)
  - Enables: auto-pivot, cross-database support, timestamps, pivot methods
  - Syntax: `$this->belongsToManyX(Related::class)` or `$this->belongsToManyX(Related::class, 'pivot_table_name')`

### Critical Rule: Database Configuration
- `config/database.php` follows Laravel 12 standard
- NO per-module connections hardcoded (notify, geo, media, job, xot, activity, cms, gdpr, lang, meetup, seo, tenant)
- Module connections added dynamically by `TenantServiceProvider::registerDB()` as copies of default
- Allowed tenant config connections: driver connections (sqlite, mysql, mariadb, pgsql, sqlsrv) and `user_sqlite`, `user_mysql`, `user_mariadb`

### Critical Rule: SVG Icons (Meetup Theme)
- Create `.svg` files in `Modules/Meetup/resources/svg/` (NOT inline in Blade)
- Reference with: `<x-filament::icon icon="meetup-{name}" class="..." />`
- Prefix: `meetup` (registered by XotBaseServiceProvider)
- Examples: `logo.svg` → `icon="meetup-logo"`, `facebook.svg` → `icon="meetup-facebook"`

### Critical Rule: URL Localization (mcamara/laravel-localization)
- All links to localized pages: `LaravelLocalization::localizeUrl($path)` (path without locale prefix)
- Form actions: Must be localized (e.g., `LaravelLocalization::localizeUrl('/login')`) or POST becomes GET after redirect
- Current locale: `LaravelLocalization::getCurrentLocale()` (prefer over `app()->getLocale()`)
- Language selector: `LaravelLocalization::getLocalizedURL($code, null, [], true)`
- Public routes: Under `/{locale}/...`; Folio/Cms registers `->uri($locale)` per language
- Testing: Use `refreshApplicationWithLocale($locale)` and request with prefix (e.g., `$this->get('/en/')`)

### Critical Rule: Spatie QueueableAction Pattern
- All business logic in `app/Actions/` extending `Spatie\QueueableAction\QueueableAction`
- **Single entry point:** ALWAYS use `execute()` method (never custom method names)
- **Invocation:** `app(SomeAction::class)->execute($data)`
- **Dependencies:** Max 1-2 in constructor (preferably resolve via `app()` inline)
  - ❌ WRONG: Heavy DI in constructor (4+ params)
  - ✅ RIGHT: Inline resolution `app(OtherAction::class)->execute(...)` for occasional deps

### Critical Rule: No Mixed Type
- Type `mixed` is forbidden (last resort only)
- Use specific types, union types, or generics instead

### Critical Rule: Theme Resolution
1. `.env` → `APP_URL` (e.g., `http://laravelpizza.local`)
2. Tenant config from `APP_URL` (e.g., `config/local/laravelpizza/`)
3. `config/local/laravelpizza/xra.php` → `pub_theme` key (e.g., `'Meetup'`)
4. Theme: `laravel/Themes/Meetup`; view namespace: `pub_theme::`

### Documentation Standards
- ALL `.md` files (except `README.md`, `CHANGELOG.md`) must be **lowercase with hyphens**
- NO dates in filenames or "Last Updated" sections
- Use **relative links** between docs
- Each module/theme MUST have `docs/PRD.md` (requirements & architecture)
- NO `archive/` folders allowed in `docs/`

### Code Style
- Declare strict types: `declare(strict_types=1);` at top of every file
- PSR-12 formatting (enforced by Pint)
- Comments only when clarification needed; no obvious comments
- Model timestamps: use `$timestamps = true;` (explicit, even if default)
- Fillable arrays: always define `$fillable` explicitly

### Testing Patterns
- Base test class: `abstract class TestCase extends XotBaseTestCase`
- Use `DatabaseTransactions` (NOT `RefreshDatabase`)
- 100% Pest coverage required for all modules
- Use `.env.testing` and test database (NOT SQLite for project suite)
- For model queries in tests: static Eloquent calls acceptable (pragmatic exception)
- Model constructor overrides forbidden (breaks `TenantServiceProvider` dynamic mapping)

### Service Provider Pattern
- Extend `XotBaseServiceProvider`
- Required properties: `$name`, `$module_dir`, `$module_ns`
- ❌ WRONG: Empty `boot()` or `register()` methods (remove if only calling parent)
- ✅ RIGHT: Include only methods that do actual work; use `#[Override]` attribute when overriding

### Translation Files
- Filament resources MUST include: `navigation`, `label`, `plural_label`, `fields`, `actions`
- These keys are structural and NEVER empty
- Module prefix pattern: `trans('meetup::events.title')`

## Common Development Patterns

### Creating a New Feature
1. Study module docs: `Modules/{ModuleName}/docs/`
2. Add migration (or update existing if table exists): `database/migrations/`
3. Create model (extend `XotBaseModel`): `app/Models/`
4. Create action: `app/Actions/` (business logic)
5. Create Filament resource (extend `XotBaseResource`): `app/Filament/Resources/`
6. Add tests: `tests/` (100% coverage)
7. Update module docs

### Adding to Frontend (Folio + Volt)
1. Create JSON page config: `config/local/laravelpizza/database/content/pages/{slug}.json`
2. Define `content_blocks` with block type and view reference
3. Create block component: `Themes/Meetup/resources/views/components/blocks/{type}/{name}.blade.php`
4. Use Volt (single-file Livewire): `<x-volt:component-name />`
5. Run `npm run build && npm run copy` in theme directory

### Writing Tests
```php
use Tests\TestCase;

class YourTest extends TestCase
{
    use DatabaseTransactions;  // NOT RefreshDatabase

    #[Test]
    public function it_does_something(): void
    {
        // Arrange
        $model = Model::factory()->create();

        // Act
        $result = app(YourAction::class)->execute($model);

        // Assert
        $this->assertTrue($result->isValid());
    }
}
```

## Git Workflow

Commits should include the trailer: `Co-authored-by: Copilot <223556219+Copilot@users.noreply.github.com>`

## Key Files to Reference

- **Architecture:** `CLAUDE.md`, `AGENTS.md`, `.agents/docs/agents-guide/`
- **Critical rules:** `.agents/docs/agents-guide/04-architecture/critical-architecture-rules.md`
- **Testing:** `.agents/docs/agents-guide/08-testing/testing-guidelines.md`
- **Build/lint/test:** `.agents/docs/agents-guide/02-tooling/build-lint-test-commands.md`
- **Code style:** `.agents/docs/agents-guide/03-code-style/code-style-guidelines.md`
- **Module structure:** `laravel/Modules/Xot/docs/` (framework core)
- **Theme:** `laravel/Themes/Meetup/docs/` & `laravel/Modules/Meetup/docs/`

## Additional Resources

- **Laraxot** (modular framework): https://github.com/laraxot
- **Filament** (admin panel): https://filamentphp.com
- **Laravel Folio** (file-based routing): https://laravel.com/docs/folio
- **Laravel Volt** (single-file components): https://livewire.laravel.com/docs/volt
- **Pest** (testing framework): https://pestphp.com
- **PHPStan** (static analysis): https://phpstan.org
