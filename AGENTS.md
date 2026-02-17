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
- **ALWAYS use short array syntax `[]` instead of `array()`**
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
    'navigation' => [
        'label' => 'Label',
        'plural_label' => 'Labels',
        'group' => 'ModuleName',
        'icon' => 'heroicon-o-icon',
        'sort' => 10,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Field Label',
            'placeholder' => 'Placeholder text',
            'helper_text' => 'Helper text description',
        ],
    ],
    'actions' => [...],
    'validation' => [...],
    'messages' => [...],
];
```

**⚠️ CRITICAL: NEVER replace structured translations with flat keys!**

❌ WRONG - Flat keys only:
```php
return [
    'name' => 'Nome',
    'description' => 'Descrizione',
    'title' => 'Titolo',
    // ... hundreds of flat keys
];
```

✅ CORRECT - Full structure:
```php
return [
    'navigation' => [...],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo',
        ],
    ],
    // ... full structure
];
```

**🔴 HOW TO DETECT THE PROBLEM:**

Look for these warning signs in translation files:
- Comment: `// Chiavi di base - da completare`
- Missing `navigation` array at top level
- Missing `fields` as multidimensional array
- Only single-level flat keys at top level

**TO FIX:** Rewrite the file with the complete structure template above.

**🔴 CRITICAL: NEVER LEAVE MANDATORY NODES EMPTY!**

The following top-level keys MUST NEVER be empty or missing:
- `navigation` → MUST contain label, plural_label, group, icon, sort
- `label` → MUST contain a value (e.g., 'User', 'Profile')
- `plural_label` → MUST contain a value (e.g., 'Users', 'Profiles')
- `fields` → MUST contain field definitions (not empty array)
- `actions` → MUST contain action definitions (not empty array)

**PROHIBITED:**
```php
// ❌ WRONG - Empty nodes
'navigation' => []           // EMPTY!
'label' => ''                // EMPTY!
'plural_label' => ''         // EMPTY!
'fields' => []               // EMPTY!
'actions' => []              // EMPTY!
```

**REQUIRED:**
```php
// ✅ CORRECT - All nodes filled
'navigation' => [
    'label' => 'User',
    'plural_label' => 'Users',
    'group' => 'Management',
    'icon' => 'heroicon-o-user',
    'sort' => 1,
],
'label' => 'User',
'plural_label' => 'Users',
'fields' => [
    'name' => ['label' => 'Name'],
],
'actions' => [
    'create' => ['label' => 'Create'],
],
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

### Theme Translations - pub_theme Namespace (CRITICAL!)

**Theme translations use `pub_theme::` namespace and MUST follow this pattern:**

```blade
{{-- ALWAYS use .label suffix --}}
{{ __('pub_theme::event.back_to_events.label') }}
{{ __('pub_theme::event.date.label') }}
{{ __('pub_theme::event.about_this_event.label') }}
```

**Translation File Structure (Themes):**
```php
// Themes/Meetup/lang/{locale}/event.php
return [
    'navigation' => [...],
    'back_to_events' => [
        'label' => 'Back to Events',
    ],
    'date' => [
        'label' => 'Date',
    ],
    'about_this_event' => [
        'label' => 'About this event',
    ],
    // ...
];
```

**NEVER use flat keys:**
```php
// ❌ WRONG
'back_to_events' => 'Back to Events',

// ✅ CORRECT
'back_to_events' => [
    'label' => 'Back to Events',
],
```

### Frontend (Frontoffice) - NO Controllers! NO Routes!
**ALWAYS use:**
- ✅ **Laravel Folio** (file-based routing) - automatico da file in `resources/views/pages/`
- ✅ **CMS-Driven Pages** (JSON files in `config/local/laravelpizza/database/content/pages/`)
- ✅ **Volt in Folio** per componenti dinamici

**NEVER use:**
- ❌ **Controllers** - Non esistono nel frontoffice!
- ❌ **Route::** in web.php - Le pagine sono gestite da Folio/JSON
- ❌ **Route::** in api.php - Solo API endpoints, non pagine web
- ❌ **Named routes con route()** - Folio genera URL automaticamente

**Come funziona Folio:**
- Pagina in `resources/views/pages/about.blade.php` → URL `/about`
- Pagina in `resources/views/pages/[slug].blade.php` → URL `/{slug}`
- CMS page in `config/local/.../pages/home.json` → renderizzata dal componente

**Per i link nel frontend:**
```blade
{{-- CORRETTO - Folio genera automaticamente --}}
<a href="{{ url('/dashboard') }}">
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">

{{-- SBAGLIATO - Non usare route() nel frontoffice! --}}
<a href="{{ route('dashboard') }}">  {{-- NO! --}}
```

### URL Localization in Alpine.js Components (CRITICAL!)

When using Alpine.js to render dynamic content (e.g., event lists), ALWAYS use the pre-computed localized URL from the data:

```blade
{{-- WRONG - Missing locale prefix --}}
<a :href="'/events/' + event.slug">  {{-- Results in /events/slug! --}}

{{-- CORRECT - Use pre-computed URL from model --}}
<a :href="event.url">  {{-- event.url already contains /it/events/slug --}}
```

The `toBlockArray()` method in models should generate localized URLs:
```php
// In Event model
'url' => LaravelLocalization::localizeUrl('/events/'.$this->slug),
```

### Backend (Admin) - Filament Only
- All admin resources extend XotBase classes
- NO raw Filament extensions

### XotBaseListRecords - CRITICAL RULE

When creating List pages that extend XotBaseListRecords:

**✅ REQUIRED: Implement getTableColumns()**
```php
class ListEvents extends XotBaseListRecords
{
    protected static string $resource = EventResource::class;

    // ✅ REQUIRED - Must be public with #[Override]
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable(),
            // ... more columns
        ];
    }
}
```

**❌ WRONG - Missing getTableColumns()**
```php
class ListEvents extends XotBaseListRecords
{
    // ❌ WRONG - Will fail without getTableColumns()
}
```

**Other common methods:**
- `getTableFilters()` - Use #[Override] attribute (must be public)
- `getHeaderActions()` - Use #[Override] attribute (must be public)
- `getHeaderWidgets()` - Add stats/chart widgets
- `getDefaultTableSortColumn()` - Default sort column
- `getDefaultTableSortDirection()` - Default sort direction (asc/desc)

### ⚠️ CRITICAL RULE: Always Use Filament Widgets, NOT Livewire Pure!

For ANY dynamic component that needs server interaction (forms, dropdowns, modals, etc.):
- **✅ ALWAYS use Filament Widgets** in `Modules/ModuleName/app/Filament/Widgets/`
- **❌ NEVER use pure Livewire components** (except for Volt in Folio pages)

### Registration Validation Rules
When implementing user registration:
- ALWAYS validate email uniqueness BEFORE hitting the database
- Use Laravel Validator with `unique:table,column` rule
- Throw `ValidationException` with clear error messages
- Example:
```php
if ($userModel->on('user')->where('email', $email)->exists()) {
    throw ValidationException::withMessages([
        'email' => [__('validation.unique', ['attribute' => 'email'])],
    ]);
}
```

**When you need interactivity:**
- Create a **Filament Widget** (extends XotBaseWidget)
- NOT a Livewire component

**Example - User Dropdown:**
- ✅ CORRECT: `Modules/Meetup/app/Filament/Widgets/UserDropdownWidget.php`
- ❌ WRONG: `Modules/Meetup/app/Http/Livewire/UserDropdown.php`

**For Alpine.js only interactivity (no server calls):**
- Plain Blade + Alpine.js is OK for UI-only interactions
- But for anything needing data/auth, use Filament Widget

### Module Structure
```
Modules/{ModuleName}/
├── app/
│   ├── Actions/       # Spatie QueueableAction (NO constructor DI!)
│   ├── Datas/         # Spatie Data DTOs
│   ├── Filament/      # Admin resources (extend XotBase)
│   ├── Models/        # Eloquent models (extend BaseModel)
│   └── Services/      # (AVOID - use Actions instead)
├── database/migrations/
├── docs/
├── tests/
└── composer.json
```

**⚠️ IMPORTANT: Actions - NO constructor DI!**
```php
// ❌ WRONG - Don't use constructor DI
public function __construct(
    private readonly SomeAction $someAction,
) {}

// ✅ CORRECT - Use app() to resolve actions
app(SomeAction::class)->execute($data);

// ❌ WRONG - Don't call custom methods
app(CreateClientAction::class)->createPersonalAccessClient();

// ✅ CORRECT - Always call execute() directly
app(CreateClientAction::class)->execute($data);
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
- **NEVER add module connections to tenant configs** - TenantServiceProvider creates them automatically!
- Module connections added dynamically via `TenantServiceProvider::registerDB()`

### ⚠️ CRITICAL RULE: Never Add Database Connections to Tenant Configs!

**This is a GRAVE error:**
```php
// ❌ NEVER DO THIS in config/local/laravelpizza/database.php!
'gdpr' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    // ...
],
```

**CORRECT:**
- Module connections (gdpr, notify, geo, etc.) → `config/database.php` (main)
- Tenant-specific configs → `config/local/{tenant}/database.php` should ONLY have:
  - `mysql` (default)
  - `user` (tenant users)
  - `sqlite` (optional)
- TenantServiceProvider dynamically adds module connections based on .env variables (DB_DATABASE_GDPR, etc.)

**WHY:**
- TenantServiceProvider reads .env and registers connections automatically
- Adding manually to tenant configs causes conflicts and breaks the system
- Only the main config/database.php should have module connections

### Testing Database Config - CRITICAL RULE
**.env.testing must be a CARBON COPY of .env with only "_test" added to database names!**

**STRICT RULE - NEVER modify these variables:**
- APP_URL - MUST be IDENTICAL to .env (e.g., if .env has `http://laravelpizza.local`, .env.testing MUST have `http://laravelpizza.local`)
- APP_NAME, APP_KEY, APP_ENV, APP_DEBUG - MUST be IDENTICAL to .env
- All other variables EXCEPT database names - MUST be IDENTICAL to .env

**WRONG APPROACH (NEVER DO THIS):**
```bash
# ❌ WRONG - Changing APP_URL breaks the app!
APP_URL=http://127.0.0.1  # WRONG! Must match .env

# ❌ WRONG - Inventing new variables that don't exist in .env
NOTIFY_DB_DATABASE=laravelpizza_data_test
NOTIFY_DB_USERNAME=marco
NOTIFY_DB_PASSWORD=marco

GEO_DB_DATABASE=laravelpizza_data_test
GEO_DB_USERNAME=marco
GEO_DB_PASSWORD=marco

# ... etc for all modules
```

**CORRECT APPROACH:**
```bash
# ✅ CORRECT - Copy .env exactly, only change database names
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelpizza_data_test  # ← Only add _test here
DB_USERNAME=marco
DB_PASSWORD=marco

# If DB_DATABASE_USER exists in .env, also add _test
DB_DATABASE_USER=laravelpizza_user_test  # ← Only if it exists in .env
DB_USERNAME_USER=marco
DB_PASSWORD_USER=marco
```

**WHY:** The `CreatesApplication` trait automatically maps all module connections (notify, geo, media, job, activity, cms, gdpr, lang, meetup, seo, tenant, xot) to the test MySQL connection. DO NOT duplicate this logic in .env.testing or TestCase!

**AUTOMATIC GENERATION SCRIPT:** Use the provided script to generate .env.testing safely:
```bash
# Generate .env.testing from .env (never edit manually!)
./generate-env-testing.sh
```
This ensures APP_URL and all other variables remain identical to .env.

**CRITICAL RULE FOR TestCase:** NEVER duplicate database connection configuration in setUp() because CreatesApplication already handles it automatically.

---

## 5.1. Theme & pub_theme Namespace - CRITICAL RULE

**ALWAYS use `pub_theme::` namespace for theme components, NOT the theme name!**

The current active theme is configured via `config('xra.pub_theme')` which returns `'Meetup'`. However, the Blade namespace is ALWAYS `pub_theme::` - never use the theme name directly.

**CORRECT:**
```blade
@include('pub_theme::components.ui.particles')
<x-pub_theme::components.layouts.main>
{{ view('pub_theme::path.to.view') }}
```

**WRONG:**
```blade
@include('meetup::components.ui.particles')   {{-- NEVER use theme name! --}}
<x-Meetup::components.layouts.main>             {{-- WRONG! --}}
```

**Why:**
- `pub_theme` is a dynamic namespace that points to the configured theme
- The theme name could change (Meetup, One, etc.) but `pub_theme` always works
- This ensures the code works regardless of which theme is active

**How to find theme views:**
- `pub_theme::components.ui.particles` → `Themes/Meetup/resources/views/components/ui/particles.blade.php`
- Resolution: `pub_theme` → `config('xra.pub_theme')` → `Meetup` → `Themes/Meetup/`

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

### Documentation Standards (CRITICAL)
**All .md files MUST be inside existing docs/ folders only - NEVER create new docs directories!**

**File Naming Conventions:**
- **ALL filenames**: lowercase with kebab-case (dashes)
- **Exceptions**: Only `README.md` and `CHANGELOG.md` can have uppercase letters
- **Pattern**: `filename-with-kebab-case.md` ✅
- **Pattern**: `README.md` ✅ (exception)
- **Pattern**: `CHANGELOG.md` ✅ (exception)

**Module Documentation Structure:**
```
Modules/{ModuleName}/docs/
├── 00-index.md              # Main documentation index (CRITICAL)
├── README.md               # Module overview and main documentation
├── 01-getting-started/     # Quick start guides
├── 02-architecture/        # Architecture documentation
├── 03-development/         # Development guides
├── 04-features/           # Feature documentation
├── 05-api/                # API documentation
├── 06-integration/        # Integration guides
├── 07-troubleshooting/    # Troubleshooting
├── actions/               # Action-specific docs
├── charts/                # Chart-related docs
├── database/              # Database documentation
├── development/           # Development guides
├── filament/              # Filament-specific docs
├── quality/               # Quality assurance docs
├── testing/               # Testing documentation
└── ...                     # Feature-specific subdirectories
```

**Theme Documentation Structure:**
```
Themes/Meetup/docs/
├── 00-index.md              # Main documentation index
├── README.md               # Theme overview
└── ...                      # Same subfolders as modules
```

**Key Principles:**
- **DRY + KISS + SOLID** - No duplication, keep it simple, follow SOLID principles
- **Cross-referencing** - Use relative paths for internal links
- **Git integration** - All documentation changes tracked via Git
- **PHPStan Level 10** - Compliance status documented
- **Update workflow** - PRIMA del codice: aggiornare docs, DOPO il codice: verificare docs

**Documentation Workflow:**
1. **Before coding**: Update/verify docs in existing docs/ folders
2. **After coding**: Verify and improve docs
3. **No new docs directories** - always use existing ones
4. **Consistent structure** - follow the same patterns across all modules

---

## 12. MCP (Model Context Protocol) for Autonomous AI Agents

LaravelPizza project includes complete MCP configuration for autonomous AI agent capabilities across multiple development environments (Claude Desktop, Cursor, Windsurf, Antigravity).

### MCP Server Infrastructure

**Location**: `bashscripts/ai/` and `bashscripts/mcp/`

**Available MCP Servers:**
1. **Filesystem Server** (port 8080) - Read/write files in LaravelPizza project
2. **Git Server** (port 8081) - Version control operations
3. **Memory Server** (port 8082) - Persistent memory for context preservation
4. **Puppeteer Server** (port 8083) - Web browser automation and testing
5. **Sequential Thinking Server** (port 8084) - Complex reasoning and problem solving
6. **Time Server** (port 8085) - Time and date operations
7. **Fetch Server** (port 8086) - HTTP requests and web scraping
8. **MySQL Server** (port 3306) - Database queries and operations
9. **Redis Server** (port 6379) - Cache and queue operations
10. **GitHub Server** (HTTP API) - GitHub integration (issues, PRs, releases)

### Starting MCP Servers

```bash
# Start all MCP servers
bashscripts/mcp/start-all-mcp.sh

# Stop all MCP servers
bashscripts/mcp/stop-all-mcp.sh
```

### AI Agent Configurations

Each AI agent has its own MCP configuration:

- **Claude Desktop**: `bashscripts/ai/.claude/mcp.json`
- **Cursor IDE**: `bashscripts/ai/.cursor/mcp.json`
- **Windsurf IDE**: `bashscripts/ai/.windsurf/mcp.json`
- **Antigravity (Custom)**: `bashscripts/ai/.antigravity/mcp.json`

### MCP Documentation

Complete MCP setup and usage guide:
- **Location**: `docs/mcp-configuration.md`
- **Contents**: Server details, configuration examples, troubleshooting, security considerations

### MCP Usage Examples

```bash
# Check MCP server status
lsof -i :8080  # Filesystem
lsof -i :8081  # Git
lsof -i :8082  # Memory
lsof -i :8083  # Puppeteer

# View MCP logs
tail -f bashscripts/ai/logs/filesystem-mcp.log
tail -f bashscripts/ai/logs/git-mcp.log
tail -f bashscripts/ai/logs/memory-mcp.log
```

### MCP Database Configuration

MySQL MCP server uses:
- Host: `127.0.0.1`
- Port: `3306`
- User: `marco`
- Password: `marco`
- Database: `laravelpizza_data` (production) or `laravelpizza_data_test` (testing)

### MCP Security Rules

1. **NEVER commit MCP configs with credentials** - use environment variables
2. **ALWAYS test database operations** on test database first
3. **USE read-only operations** where possible
4. **MONITOR MCP logs** for unauthorized access
5. **RESTRICT filesystem access** to project directory only
6. **STOP servers gracefully** using stop script

### MCP Autonomous Capabilities

With MCP, AI agents can:
- **Read and write files** autonomously
- **Execute Git operations** (commit, branch, merge, push)
- **Query databases** and retrieve data
- **Run automated browser tests** with Puppeteer
- **Perform complex reasoning** with sequential thinking
- **Preserve context** across sessions using memory server
- **Fetch external data** via HTTP requests
- **Integrate with GitHub** for issue/PR management

---

## 13. Pre-Commit Checklist

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

## 14. Theme Translations - CRITICAL RULE

**ALWAYS use `pub_theme::` namespace for theme translations, NEVER the theme name!**

The ThemeServiceProvider registers translations with the namespace `pub_theme`, which is the value of `config('xra.pub_theme')`. This is DIFFERENT from how modules work!

**Translation File Locations:**
- `pub_theme::home.hero.subtitle` → `Themes/Meetup/lang/it/home.php`
- `pub_theme::home.hero.description` → `Themes/Meetup/lang/en/home.php`
- `pub_theme::home.features.title` → `Themes/Meetup/lang/de/home.php`

**ThemeServiceProvider Registration:**
```php
// In Themes/Meetup/app/Providers/ThemeServiceProvider.php
$this->loadTranslationsFrom(__DIR__.'/../../lang', 'pub_theme');
$this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
```

**Usage in Blade:**
```blade
{{-- CORRECT --}}
{{ __('pub_theme::home.hero.subtitle') }}
@include('pub_theme::components.ui.particles')
<x-pub_theme::components.layouts.main>

{{-- WRONG - NEVER use theme name! --}}
{{ __('meetup::home.hero.subtitle') }}      {{-- WRONG! --}}
@include('meetup::components.ui.particles')   {{-- WRONG! --}}
<x-Meetup::components.layouts.main>           {{-- WRONG! --}}
```

**Key Differences from Modules:**
- **Modules**: Use module name → `gdpr::register.title`
- **Themes**: Use `pub_theme::` → `pub_theme::home.hero.subtitle`
- **Theme Files**: Located in `Themes/Meetup/lang/{locale}/`, NOT `laravel/lang/{locale}/`

**Why `pub_theme` instead of theme name:**
- Dynamic namespace that works with any theme
- Theme name can change (Meetup, One, etc.) but `pub_theme` always works
- Ensures compatibility across different theme configurations

**Translation Pattern:**
```
pub_theme::{file}.{key}.{subkey}
```

Examples:
- `pub_theme::home.title`
- `pub_theme::home.hero.subtitle`
- `pub_theme::home.features.title`
- `pub_theme::home.cta.cta_primary_label`

**Available Translation Files:**
- `Themes/Meetup/lang/it/home.php` - Italian
- `Themes/Meetup/lang/en/home.php` - English
- `Themes/Meetup/lang/de/home.php` - German
- `Themes/Meetup/lang/fr/home.php` - French
- `Themes/Meetup/lang/es/home.php` - Spanish
- `Themes/Meetup/lang/ru/home.php` - Russian

**NEVER use theme-specific namespace like 'meetup::' for translations! ALWAYS use 'pub_theme::'!**
