# Copilot Instructions for FixCity

This file helps Copilot sessions work effectively in this repository. It captures essential commands, architecture, conventions, and critical patterns to maintain code quality and consistency.

---

## 🚀 Quick Commands

### Development
```bash
# Laravel development
cd laravel
php artisan serve

# Frontend dev
npm run dev

# Full stack
composer run dev
```

### Testing
```bash
cd laravel
./vendor/bin/pest                          # Run all tests
./vendor/bin/pest --coverage --min=80      # With coverage (80% minimum)
./vendor/bin/pest tests/Unit/             # Single suite
./vendor/bin/pest --filter=UserTest        # Specific test class
./vendor/bin/pest tests/Feature/SpecificTest.php --filter=testMethod  # Specific method
```

### Code Quality
```bash
# PHP static analysis (PHPStan Level 10 - strict)
cd laravel && ./vendor/bin/phpstan analyse

# PHP formatting (Laravel Pint)
cd laravel && ./vendor/bin/pint

# Frontend quality
npm run quality              # All checks (Biome, ESLint, HTMLHint, Markdownlint)
npm run fix                  # Auto-fix (Biome, ESLint)
npm run quality:biome        # Code formatting only
npm run quality:eslint       # JavaScript/TypeScript only
```

---

## 🏗️ High-Level Architecture

### Project Structure
- **Document Root**: `public_html/` (NOT `public/`)
- **Laravel App**: `laravel/` (Laravel 12, Filament 5, Livewire 3)
- **Modules**: `laravel/Modules/*/` (19 modules using nwidart/laravel-modules)
- **Themes**: `laravel/Themes/*/` (Active: "Sixteen", alt: "TwentyOne")
- **Bash Scripts**: `bashscripts/<category>/` (organized by function)
- **Frontend**: `npm` scripts for Tailwind, ESLint, Biome

### Active Theme Configuration
The theme detection algorithm reads `.env` to determine the active theme:
1. `APP_URL` from `laravel/.env` → `http://fixcity.local`
2. Extract domain → `fixcity.local`
3. Build config path → `local/fixcity`
4. Read config → `laravel/config/local/fixcity/xra.php`
5. Get theme → `pub_theme` key → `'Sixteen'`

**Current**: Theme "Sixteen" at `laravel/Themes/Sixteen/`

### Key Modules
- **Xot**: Core framework module (base classes, helpers, traits)
- **Cms**: Content management
- **Tenant**: Multi-tenancy support
- **Media**: File management
- **Activity**: Activity logging
- **AI**, **Job**, **Notify**, **Lang**, **Geo**, **Gdpr**, **Rating**, **Blog**, **Fixcity**, **Comment**, **Seo**

### Filament + Folio + Volt Architecture
- **Folio**: File-based routing (pages directory)
- **Volt**: Livewire component syntax
- **Filament**: Admin panel with modular resources
- **JSON-Driven Content**: Pages loaded via middleware from JSON config files

---

## 🔐 Critical Conventions

### ✅ MUST DO

#### Class Extension
- **NEVER** extend Laravel/Filament base classes directly
- **ALWAYS** extend XotBase classes from the Xot module:
  - `XotBaseResource` (not `Resource`)
  - `XotBaseListRecords` (not `ListRecords`)
  - `XotBaseServiceProvider` (not `ServiceProvider`)
  - `XotBaseMigration` (not `Migration`)

#### Filament Resources
- Use `getFormSchema()` method, **NEVER** use `form()`
- DO NOT define `table()` method (handled by list resource)
- DO NOT use `->label()` method (handled by LangServiceProvider via translations)
- `getHeaderActions()` MUST return `array<string, Action|ActionGroup>` with string keys:
  ```php
  protected function getHeaderActions(): array
  {
      return [
          'delete' => DeleteAction::make(),
          'edit' => EditAction::make(),
      ];
  }
  ```

#### DRY Principle - Trait Methods
- Trait methods (getJsonFile, loadExistingData, saveToJson) implemented ONCE in trait
- Models using trait inherit automatically
- Never duplicate trait methods in individual models

#### Type Safety (PHPStan Level 10)
- **ALWAYS** declare types for ALL class properties
- **ALWAYS** add return type declarations to ALL methods
- **ALWAYS** use proper type hints for parameters
- **NEVER** use `mixed` types without narrowing
- Use Safe library functions: `json_decode()`, `json_encode()`, `realpath()`
- Traits with public methods need `@method` annotations in using classes

#### No Service Classes
- **NEVER** create Service classes
- **ALWAYS** use Spatie QueueableAction pattern
- Actions extend `Modules\Xot\Actions\BaseAction` or implement `Spatie\QueueableAction\QueueableAction`
- Location: `Modules/ModuleName/app/Actions/ActionName.php`

#### Logging
- **NEVER** use `Log::info()` for routine operations (kills performance, wastes disk)
- Use `Log::error()` only for actual errors
- Use `Log::warning()` only for conditions requiring attention
- Use `Log::debug()` only for development (never in production)
- **INSTEAD**: Use database audit tables or Laravel Telescope/Pulse

#### Bash Scripts
- **ALL .sh files** MUST be in `bashscripts/<category>/` subdirectories
- NEVER in project root or `laravel/`
- Example: ✅ `bashscripts/system/optimization/cache-clear.sh`
- Always document in `bashscripts/docs/<category>/`

#### Migrations
- ALWAYS extend `XotBaseMigration`
- NEVER override the `down()` method (it's final)
- Use `tableCreate()` and `tableUpdate()` methods
- Always use `declare(strict_types=1)`

#### Namespaces (Modules)
- Models: `Modules\*\Models` (NOT `Modules\*\app\Models`)
- Filament: `Modules\*\Filament` (NOT `Modules\*\app\Filament`)
- Resources: `Modules\*\Filament\Resources`
- Actions: `Modules\*\Actions`

#### Coding Standards
- Use strict types: `declare(strict_types=1)`
- Define return types for ALL methods
- Use type hints for ALL parameters
- Use null-safe operator when appropriate
- Use short array syntax `[]`
- Follow PSR-4 autoloading

### ✅ SHOULD DO

#### Translations
- Use expanded structure for fields:
  ```php
  'fields' => [
      'field_name' => [
          'label' => 'Field Label',
          'tooltip' => 'Help text',
          'placeholder' => 'Example input'
      ]
  ]
  ```
- Same for actions with label, icon, color, tooltip

#### Documentation
- **Single Source of Truth**: Document each concept ONCE
- **NO temporal strings**: Never include dates in file content (git tracks history)
- **Bidirectional links**: Link to and from related docs
- **Lowercase kebab-case**: `user-authentication.md` (NOT `UserAuthentication.md`)
- Quality gates: Run `./bashscripts/docs/check-duplicates.sh` weekly
- **Multi-Agent Friendly**: Designed for simultaneous AI agents

#### Multi-Agent Coordination
- **Multiple AI agents work simultaneously** — this is a strength
- **Check** what others are doing before starting
- **Declare** intentions on GitHub issues
- **Communicate** progress every 10-15 minutes
- **Coordinate** via BMAD threads, GSD phases, GitHub issues

---

## 🗂️ Project Organization Patterns

### Modules Structure
```
Modules/ModuleName/
├── app/
│   ├── Actions/              # Spatie QueueableActions (no Services!)
│   ├── Filament/
│   │   ├── Resources/        # Filament resources
│   │   └── Pages/            # Filament pages
│   ├── Models/               # Eloquent models
│   └── Traits/               # Shared traits
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/                      # Module documentation
├── tests/                     # Unit + Feature tests
└── routes/                    # Module routes (if any)
```

### Theme Structure
```
Themes/ThemeName/
├── docs/                      # Theme documentation
├── resources/
│   ├── views/                 # Blade templates
│   └── css/                   # Tailwind CSS
├── public/                    # Public assets
└── config/                    # Theme configuration
```

### Bash Scripts Structure
```
bashscripts/
├── <category>/
│   ├── <script-name>.sh       # Script file
│   └── docs/
│       └── <category>/
│           ├── README.md      # Category index
│           └── <script>.md    # Script documentation
```

---

## 📝 Testing Patterns

### Running Tests
```bash
cd laravel

# All tests
./vendor/bin/pest

# With coverage report
./vendor/bin/pest --coverage --min=80

# Specific test file
./vendor/bin/pest tests/Feature/UserTest.php

# Specific test method
./vendor/bin/pest --filter=testUserCreation
```

### Test Structure (Pest)
- **Unit tests**: `tests/Unit/`
- **Feature tests**: `tests/Feature/`
- **Coverage minimum**: 80%
- Tests use closures and expectations API

### Filament Testing
```php
use function Pest\Livewire\livewire;

livewire(ListUsers::class)
    ->callAction('promote', ['role' => 'admin'])
    ->assertNotified();
```

---

## 🛠️ Common Tasks

### Add New Module
```bash
cd laravel
php artisan module:make ModuleName
php artisan module:make-controller ModuleController --module=ModuleName
php artisan module:make-model Model --module=ModuleName
```

### Create Filament Resource
```bash
cd laravel
php artisan make:filament-resource Post --generate
```

### Create Action (QueueableAction)
```bash
cd laravel
php artisan make:action ProcessOrderAction
```

### Create Migration
```bash
cd laravel
php artisan make:migration CreatePostsTable --module=ModuleName
```

### Create Test
```bash
cd laravel
php artisan make:test UserTest
php artisan make:test UserControllerTest --feature
```

---

## 🔍 PHPStan Static Analysis

**Level**: Max (Level 10 - strictest)

### Key Configurations
- Scans: `./Modules/` and `./Themes/` directories
- Excludes: Blade files, tests, vendor, docs
- Bootstraps: `phpstan_constants.php` for custom constants

### Common Issues & Fixes
| Issue | Solution |
|-------|----------|
| Missing property type | Add `private string $property;` at class top |
| Missing return type | Add `: ReturnType` to method signature |
| Method not found on mixed | Type narrow: `if ($obj instanceof Class)` |
| Array access on mixed | Use `is_array()` check before access |
| Trait method undefined | Add `@method` annotation to class using trait |

### Before Pushing Code
```bash
cd laravel
./vendor/bin/phpstan analyse
```

---

## 🎯 GSD (Get Shit Done) Workflow

When user asks for GSD or uses `gsd-*` commands:
- Use the `get-shit-done` skill
- Load matching file from `.github/skills/gsd-*`
- Prefer matching custom agent from `.github/agents`
- Do NOT apply GSD workflows unless explicitly requested

GSD directories:
- Phases: `.planning/phases/`
- Research: `.planning/research/`
- Roadmap: `.planning/ROADMAP.md`

---

## 🔗 Key Documentation Files

### Master Hubs (Start Here)
- **Architecture Diagrams**: `docs/ARCHITECTURE-DIAGRAMS.md` (system overview, ASCII diagrams)
- **Module Master Index**: `docs/MODULE_DOCS_INDEX.md` (all 19 modules + relationships)
- **Theme Master Index**: `docs/THEMES_DOCUMENTATION_INDEX.md` (Sixteen, TwentyOne + integration)
- **Documentation Ecosystem**: `docs/DOCUMENTATION_ECOSYSTEM.md` (complete navigation map)

### Framework & Standards
- **Framework Rules**: `laravel/CLAUDE.md` (comprehensive Laraxot guidelines, 38.7 KB)
- **Code Quality**: `docs/CODE_QUALITY_STANDARDS.md` (standards & best practices)
- **Issue Tracking**: `.github/README.md` (Design Comuni project tracking)

### Module & Theme Documentation
- **All Modules**: `laravel/Modules/{ModuleName}/docs/00-INDEX.md`
- **All Themes**: `laravel/Themes/{ThemeName}/docs/00-INDEX.md`
- **Component Catalog**: `laravel/Themes/Sixteen/docs/COMPONENT_CATALOG.md` (47 components, 38 pages)

---

## ⚠️ Gotchas & Anti-Patterns

1. **Document Root**: It's `public_html/`, NOT `public/`
2. **Filament Actions**: MUST use `array<string, Action>` with string keys, never indexed arrays
3. **Form Labels**: Don't use `->label()` — use translations instead
4. **Logging**: Excessive `Log::info()` kills performance (30-50% slowdown)
5. **Service Classes**: Don't create them — use QueueableActions instead
6. **Bash Scripts**: Don't put in project root or `laravel/` — use `bashscripts/`
7. **Temporal Strings**: Never add dates to docs — let git track history
8. **Type Safety**: PHPStan level 10 is strict — add types everywhere
9. **Trait Methods**: Must add `@method` annotations to classes using them
10. **Duplicate Content**: Each concept documented ONCE — use links instead

---

## 🤝 Multi-Agent Collaboration

This project supports **simultaneous work by multiple AI agents**. When working:

1. **Check** GitHub issues and discussions for active work
2. **Declare** your intentions clearly (comment on issues)
3. **Communicate** progress every 10-15 minutes
4. **Coordinate** via issues, PRD threads, and phase documentation
5. **Update** OpenViking context for important decisions

**Tools Used**:
- **BMAD**: Requirements & architecture (_bmad/)
- **GSD**: Phase execution (.planning/)
- **Ralph**: Autonomous loops (.ralph/)
- **OpenViking**: Global context (openviking command)

---

## 📞 When Stuck

1. Check `.github/README.md` for issue tracking guidelines
2. Review `laravel/CLAUDE.md` for detailed framework rules
3. Check module-specific docs in `Modules/*/docs/`
4. Run `./vendor/bin/phpstan analyse` to catch type issues early
5. Check GitHub discussions for architecture decisions (ADRs)

---

**Last Updated**: See git history for changelog  
**Version**: Copilot-native  
**Framework**: Laravel 12 + Filament 5 + Livewire 3 + nwidart/laravel-modules