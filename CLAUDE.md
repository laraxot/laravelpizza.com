# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**LaravelPizza** is a conversion and ENHANCEMENT of https://laravelpizza.com/ - making it **MORE COOL, MORE CLICKBAIT, MORE ENGAGING**. This is NOT just a replica - it's an improved, modernized version of the original site using cutting-edge Laravel architecture.

🎯 **Mission**: Take laravelpizza.com and make it BETTER - cooler design, more engaging UX, clickbait-worthy content, viral-ready features.

This is NOT a pizza e-commerce project - it's a platform for Laravel developer meetups and tech communities, built to be share-worthy and conversion-optimized.

The project follows extreme architectural discipline with:
- **Folio + Volt** for all front-office pages (NO traditional controllers/routes)
- **CMS-driven content** using JSON files and block components
- **Filament** for admin/backend only
- **Modular architecture** via nwidart/laravel-modules
- **PHPStan level 10** strict type safety
- **XotBase pattern** for all Filament extensions

## Repository Structure

```
/var/www/_bases/base_laravelpizza/
├── laravel/                         # Main Laravel application
│   ├── Modules/                     # Business logic modules
│   │   ├── Activity/                # Event sourcing & activity logs
│   │   ├── Cms/                     # Content management system
│   │   ├── Geo/                     # Geographic/location features
│   │   ├── Job/                     # Background job monitoring
│   │   ├── Lang/                    # Internationalization
│   │   ├── Meetup/                  # Core meetup functionality
│   │   ├── Notify/                  # Notifications system
│   │   ├── Tenant/                  # Multi-tenancy support
│   │   ├── UI/                      # UI components & widgets
│   │   ├── User/                    # Authentication & users
│   │   └── Xot/                     # Laraxot core framework
│   ├── Themes/                      # Frontend themes
│   │   └── Meetup/                  # LaravelPizza.com theme
│   └── composer.json
├── .cursor/rules/                   # 400+ AI coding rules
└── bashscripts/                     # Utility scripts
```

Each module follows the structure:
```
Modules/{ModuleName}/
├── app/
│   ├── Actions/                     # Spatie actions (business logic)
│   ├── Datas/                       # Spatie data DTOs
│   ├── Filament/                    # Admin resources (MUST extend XotBase)
│   ├── Models/
│   └── Services/
├── docs/                            # Module documentation
├── database/migrations/
└── composer.json
```

## Critical Architecture Rules

### 0. Theme Resolution (CRITICAL – separazione tema)

Il **tema pubblico** non è hardcodato: si ricava dalla configurazione tenant.

1. **`.env`** → `APP_URL` (es. `http://laravelpizza.local`)
2. **Cartella config** → da `APP_URL` il modulo Tenant ricava il nome tenant (es. `local/laravelpizza`) → **`laravel/config/local/laravelpizza`**
3. **`config/local/laravelpizza/xra.php`** → chiave **`pub_theme`** (es. `'Meetup'`)
4. **Tema** → **`laravel/Themes/Meetup`**; view namespace **`pub_theme::`**

**Workflow dalla cartella del tema** (`laravel/Themes/Meetup`): `composer update -W`, `npm install`, `npm run build`, `npm run copy`. Build e copy sono obbligatori per vedere modifiche CSS/JS.

Regola: `.cursor/rules/theme-resolution-critical.md`. Memoria: `.cursor/memories/theme-resolution.md`.

### 0b. Relazioni many-to-many: belongsToManyX (CRITICAL)

**NEVER use `$this->belongsToMany()` for many-to-many. ALWAYS use `$this->belongsToManyX()`.**

- `belongsToManyX` è nel trait `RelationX` (XotBaseModel); auto-pivot, cross-database, withPivot, timestamps.
- Sintassi: `$this->belongsToManyX(Related::class)` oppure `$this->belongsToManyX(Related::class, 'pivot_table_name')` se la pivot ha nome tabella esplicito (la classe pivot deve esistere nello stesso namespace, es. `event_performer` → `EventPerformer`).

Regola: `.cursor/rules/belongstomanyx-critical.md`. Memoria: `.cursor/memories/belongstomanyx-laraxot.md`. Doc: `laravel/Modules/Xot/docs/traits/relation-x.md`.

### 0c. Database config Laravel 12 (CRITICAL)

**`config/database.php`** (base) e **`config/local/{tenant}/database.php`** devono seguire lo standard Laravel 12. **Nessuna** connessione per-modulo hardcoded (no `notify`, `geo`, `media`, `job`, `xot`, `activity`, `cms`, `gdpr`, `lang`, `meetup`, `seo`, `tenant`). Le connessioni modulari sono aggiunte da `TenantServiceProvider::registerDB()` come copia della default (stesso database). Nel file tenant sono ammesse solo connessioni driver (sqlite, mysql, mariadb, pgsql, sqlsrv) e `user_sqlite`, `user_mysql`, `user_mariadb`.

Regola: `.cursor/rules/database-config-standard.mdc`. Memoria: `.cursor/memories/database-config-laravel-12-tenant.md`. Doc: `laravel/Modules/Tenant/docs/database-config-standard.md`.

### 0d. SVG: file .svg, NO inline nelle Blade (CRITICAL)

**Nelle Blade NON mettere SVG hardcoded.** Creare il file `.svg` in `Modules/Meetup/resources/svg/` e richiamare con `<x-filament::icon icon="meetup-{nome}" class="..." />`. Prefisso set = `meetup` (registrato da XotBaseServiceProvider). Esempio: `logo.svg` → `icon="meetup-logo"`, `icon-calendar.svg` → `icon="meetup-icon-calendar"`, `facebook.svg` → `icon="meetup-facebook"`.

Regola: `.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc`. Memoria: `.cursor/memories/svg-icons-meetup-blade.md`. Doc: `laravel/Modules/Meetup/docs/svg-icons-no-hardcoded-blade.md`, `laravel/Themes/Meetup/docs/svg-icons-no-hardcoded-blade.md`.

### 0e. Localizzazione URL: mcamara/laravel-localization (CRITICAL)

**Tutti i link** verso pagine localizzate devono usare **`LaravelLocalization::localizeUrl($path)`** (path senza prefisso). **Form action** (login, register, submit) devono essere localizzati (es. `LaravelLocalization::localizeUrl('/login')`), altrimenti POST diventa GET dopo redirect. **Locale corrente**: **`LaravelLocalization::getCurrentLocale()`** (preferire a `app()->getLocale()`). **Language selector**: **`LaravelLocalization::getLocalizedURL($code, null, [], true)`**. Rotte pubbliche sotto `/{locale}/...`; Folio+Volt (Cms) registra `->uri($locale)` per ogni lingua. Test: usare **refreshApplicationWithLocale($locale)** e request con prefisso (es. `$this->get('/en/')`).

Regola: `.cursor/rules/laravel-localization-mcamara.mdc`. Memoria: `.cursor/memories/laravel-localization-mcamara.md`. Doc: `laravel/Modules/Lang/docs/laravel-localization-mcamara-reference.md`, `laravel/Modules/Cms/docs/folio-routing-locale.md`, `laravel/Modules/Meetup/docs/localization-standard.md`, `laravel/Themes/Meetup/docs/localization-standard.md`.

### 1. Front Office: Folio + Volt + CMS-Driven Pages ONLY

**NEVER use traditional controllers or routes in web.php/api.php for front office.**

**Correct pattern:**
```
1. Create JSON content file:
   config/local/laravelpizza/database/content/pages/{slug}.json

2. Define content_blocks in JSON with view references

3. Folio catch-all route ([slug].blade.php) renders the page

4. Block components in:
   Themes/Meetup/resources/views/components/blocks/
```

**Example JSON page:**
```json
{
    "slug": "events",
    "title": {"it": "Eventi", "en": "Events"},
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Laravel Meetups"
                }
            }
        ]
    }
}
```

**Folio routing:** Files in `Themes/Meetup/resources/views/pages/` automatically become routes.

See: `laravel/CLAUDE.md` (existing file with detailed rules)

### 2. XotBase Extension Pattern

**NEVER extend Filament classes directly. ALWAYS extend XotBase abstracts.**

| Filament Class | Extend This Instead |
|----------------|---------------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |

See: `laravel/Modules/Xot/docs/xotbase-extension-rules.md`

### 3. One Table, One Migration, One Module

**NEVER create multiple `create_{table}_table.php` files for the same table.**

- Each table has exactly ONE authoritative migration
- Schema changes use new migration files: `add_{column}_to_{table}.php`
- Use `XotBaseMigration` with `tableCreate()` and `tableUpdate()` methods

See: `laravel/Modules/Xot/docs/laraxot-migration-philosophy-summary.md`

### 4. Documentation Naming

**All .md files MUST be lowercase with hyphens, except:**
- `README.md` (allowed)
- `CHANGELOG.md` (allowed)

**Correct:**
```
docs/folio-pages-json-only-rule.md
docs/architecture-reference.md
```

**Wrong:**
```
docs/FOLIO-PAGES-JSON-ONLY-RULE.md
docs/Architecture-Reference.md
```

## Common Development Commands

### Setup & Installation

```bash
# Initial setup
cd laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# Theme setup (REQUIRED after CSS/JS changes)
cd Themes/Meetup
npm install
npm run build
npm run copy    # Copies to public_html/themes/Meetup
```

### Development Server

```bash
# From laravel/ directory
composer dev
# Runs: php artisan serve + queue listener + pail logs + npm dev

# Or individually:
php artisan serve
npm run dev
```

### Code Quality (MANDATORY before commits)

```bash
# PHPStan analysis (level 10 required)
./vendor/bin/phpstan analyze

# Laravel Pint (PSR-12 formatting)
./vendor/bin/pint

# Fix specific paths
./vendor/bin/pint laravel/Modules/YourModule/

# PHP Insights
./vendor/bin/phpinsights analyze laravel/Modules/YourModule/
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=YourTestName

# With coverage
php artisan test --coverage
```

### Module Commands

```bash
# List modules
php artisan module:list

# Create new module
php artisan module:make ModuleName

# Publish module assets
php artisan module:publish ModuleName
```

### Database

```bash
# Fresh migration
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Create migration in module
php artisan module:make-migration create_table_name Modules/ModuleName
```

### Filament

```bash
# Clear Filament cache
php artisan filament:optimize-clear

# Upgrade Filament
php artisan filament:upgrade

# Create Filament resource in module
php artisan make:filament-resource ResourceName --model=ModelName
```

## Key Architectural Patterns

### 1. Action Pattern (Business Logic)

Use Spatie QueueableAction for all business logic:

```php
// Modules/Meetup/app/Actions/Event/CreateEventAction.php
use Spatie\QueueableAction\QueueableAction;

class CreateEventAction
{
    use QueueableAction;

    public function execute(EventData $data): Event
    {
        return DB::transaction(function () use ($data) {
            $event = Event::create($data->toArray());

            activity('event')
                ->performedOn($event)
                ->causedBy(auth()->user())
                ->log('Event created');

            return $event;
        });
    }
}
```

### 2. Data Transfer Objects

Use Spatie Laravel Data for DTOs:

```php
use Spatie\LaravelData\Data;

class EventData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public ?Carbon $start_datetime = null,
    ) {}
}
```

### 3. Strict Typing

**ALWAYS** declare strict types:

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\...;
```

### 4. Model Conventions

```php
use HasUuids, SoftDeletes, HasFactory;

protected $fillable = [...];
protected $casts = [
    'start_datetime' => 'datetime',
    'is_active' => 'boolean',
];
protected $hidden = ['password'];
```

### 5. Translation Pattern

```php
// Use module-prefixed translation keys
trans('meetup::events.title')

// In Filament components
->label(trans('meetup::fields.title'))
```

### 6. Service Provider Pattern (CRITICAL!)

**ALWAYS follow the minimal structure pattern:**

```php
// ✅ CORRECT - Minimal ServiceProvider
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}

// ❌ WRONG - Unnecessary methods
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';

    public function boot(): void
    {
        parent::boot(); // Only calls parent - REMOVE THIS!
    }
}
```

**Critical Rules:**
- ❌ NEVER add `boot()` or `register()` if you only call parent
- ❌ NEVER duplicate methods already in XotBase (registerViews, registerTranslations, etc.)
- ✅ ALWAYS include all required properties: `$name`, `$module_dir`, `$module_ns`
- ✅ ALWAYS call `parent::boot()` FIRST if you override
- ✅ ALWAYS use `#[Override]` attribute when overriding

See: `laravel/Modules/Xot/docs/serviceprovider-minimal-structure.md`
See: `laravel/Modules/Meetup/docs/provider-errors-lessons-learned.md`

## Theme Development (Meetup Theme)

The Meetup theme is an **IMPROVED VERSION** of laravelpizza.com using Tailwind CSS + Alpine.js.

**Key Enhancement Goals:**
- ✨ More modern, eye-catching design
- 🚀 Better animations and interactions
- 🎯 Clickbait-worthy headlines and CTAs
- 💥 Viral-ready social sharing features
- 🔥 Conversion-optimized user flows

The theme should make visitors say "WOW!" not just "nice."

```bash
cd laravel/Themes/Meetup

# Development
npm run dev

# Production build
npm run build
npm run copy    # MUST run after build to copy to public_html
```

**Key files:**
- `resources/css/app.css` - Tailwind styles
- `resources/js/app.js` - Alpine.js components
- `resources/views/pages/` - Folio routes
- `resources/views/components/blocks/` - Reusable block components
- `resources/views/layouts/` - Page layouts

**Layout hierarchy:**
- `x-layouts.main` - Base HTML shell (no header/footer)
- `x-layouts.app` - Full layout with nav + footer (public pages)
- `x-layouts.guest` - Auth pages (login/register)

## Documentation Organization

Each module and theme has a `docs/` directory containing:
- Architecture decisions
- Implementation guides
- API documentation
- Troubleshooting guides

**Key docs to reference:**
- `Modules/Xot/docs/xotbase-extension-rules.md` - XotBase patterns
- `Modules/Xot/docs/code_quality.md` - Quality standards
- `Modules/Meetup/docs/architecture-reference.md` - Front office architecture
- `Modules/Cms/docs/content-blocks-system.md` - CMS block system
- `.cursor/rules/` - 400+ specific coding rules

## Core Principles (DRY + KISS + SOLID + Robust + Laraxot)

1. **DRY (Don't Repeat Yourself)**
   - Use Actions, Services, Traits for shared logic
   - No code duplication

2. **KISS (Keep It Simple, Stupid)**
   - Simple solutions over complex
   - Avoid over-engineering

3. **SOLID**
   - Single Responsibility
   - Open/Closed
   - Liskov Substitution
   - Interface Segregation
   - Dependency Inversion

4. **Robust**
   - Strict type safety (PHP 8.2+)
   - PHPStan level 10
   - Error handling
   - Input validation

5. **Laraxot**
   - Modular architecture
   - XotBase inheritance
   - Event sourcing
   - CMS-driven content
   - One table, one migration

## Git Workflow

```bash
# Current branch
git status

# Create feature branch
git checkout -b feature/your-feature

# Commit with conventional commits
git add .
git commit -m "feat: add event registration feature"

# Push to remote
git push origin feature/your-feature
```

**Commit prefixes:**
- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation
- `style:` - Formatting
- `refactor:` - Code restructuring
- `test:` - Tests
- `chore:` - Maintenance

## Common Pitfalls to Avoid

1. ❌ Creating traditional controllers for front office
   ✅ Use Folio + Volt + JSON pages

2. ❌ Adding per-module connections (notify, geo, media, job, xot, activity, cms, gdpr, lang, meetup, seo, tenant) in config/database.php or config/local/{tenant}/database.php
   ✅ Follow Laravel 12: only driver connections + user_sqlite/user_mysql/user_mariadb; registerDB() adds module connections dynamically

3. ❌ Putting SVG inline in Blade files
   ✅ Create .svg in Modules/Meetup/resources/svg/ and use <x-filament::icon icon="meetup-{name}" class="..." />

4. ❌ Building localized URLs manually (url(app()->getLocale() . '/path') or url('/path') for front pages)
   ✅ Use LaravelLocalization::localizeUrl('/path') for links and form actions; use getLocalizedURL($code, null, [], true) for language selector

5. ❌ Extending Filament classes directly
   ✅ Always extend XotBase abstracts

6. ❌ Creating duplicate migration files
   ✅ One table, one create migration

7. ❌ Complex ServiceProviders with unnecessary methods
   ✅ Use minimal structure - let XotBase do the work

8. ❌ Missing required properties in Providers (`$module_dir`, `$module_ns`)
   ✅ Always include ALL required properties

9. ❌ Not calling `parent::boot()` or `parent::register()` when overriding
   ✅ ALWAYS call parent FIRST

10. ❌ Hardcoding strings in UI
    ✅ Use translation files

11. ❌ Business logic in Blade/Livewire components
    ✅ Use Actions pattern

12. ❌ Missing `declare(strict_types=1);`
    ✅ Add to every PHP file

13. ❌ UPPERCASE or CamelCase .md filenames
    ✅ Use lowercase-with-hyphens.md

14. ❌ Forgetting `npm run copy` after theme build
    ✅ Always run copy to deploy assets

## PHPStan Configuration

The project uses PHPStan level 10 (maximum strictness):

```bash
# Configuration: laravel/phpstan.neon
# Paths analyzed: laravel/Modules/
# Excluded: vendor, build, docs, tests, blade files

# Run analysis
./vendor/bin/phpstan analyze

# Clear cache
./vendor/bin/phpstan clear-result-cache

# Generate baseline (avoid doing this)
./vendor/bin/phpstan analyze --generate-baseline
```

## Quick Reference Checklist

**Creating a new public page:**
1. ✅ Create JSON in `config/local/laravelpizza/database/content/pages/{slug}.json`
2. ✅ Define `content_blocks` using existing components
3. ✅ Test at `/it/{slug}` or `/en/{slug}`
4. ❌ Do NOT create Blade file in `pages/{slug}.blade.php`
5. ❌ Do NOT create controller
6. ❌ Do NOT add route in web.php

**Creating a new Filament resource:**
1. ✅ Extend `XotBaseResource` not `Resource`
2. ✅ Add `declare(strict_types=1);`
3. ✅ Use module-prefixed translations
4. ✅ Run PHPStan before committing
5. ❌ Do NOT extend Filament classes directly

**Before every commit:**
1. ✅ Run `./vendor/bin/phpstan analyze`
2. ✅ Run `./vendor/bin/pint`
3. ✅ Check docs are lowercase-with-hyphens.md
4. ✅ Verify no duplicate migrations
5. ✅ Test changed functionality

---

**Laravel Version:** 11.x
**PHP Version:** 8.2+
**Filament Version:** 4.x
