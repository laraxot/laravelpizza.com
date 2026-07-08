---
title: "Agent instructions"
type: reference
tags: [agents, coding-agent, llm-wiki]
created: 2026-07-01
updated: 2026-07-01
qmd: "istruzioni agenti LLM wiki modulo"
issues: []
discussions: []
related:
  - ./coding-agent-manifests.md
---

# FixCity Platform - AGENTS.md

This file contains comprehensive guidelines and commands for AI agents working on the FixCity Laravel application.

## 🚨 CRITICAL ARCHITECTURAL RULES

### NO SERVICES - USE SPATIE QUEUEABLE ACTIONS
- **NEVER** create Service classes
- **ALWAYS** use Spatie\QueueableAction pattern
- Create Actions using `create-action` skill

### NO ROUTES/CONTROLLERS - USE VOLT + FOLIO + FILAMENT
- **NEVER** create route files for module functionality
- **NEVER** create Controllers
- **ALWAYS** use: Volt, Folio, Filament, Laraxot

### VIEW PATTERN — view-string + viewParams
- Per view(): variabile con @phpstan-var view-string, $viewParams = [] esplicito
- return view($viewName, $viewParams)
- Logica: type safety, estensibilità, consistenza. Vedi docs/view-pattern.md

### PHPMD e PHPInsights — SOLO .phar
- **NON** installare con Composer
- Usare .phar: `php phpmd.phar`, `php phpinsights.phar`
- Logica: indipendenza, portabilità, leggerezza. Vedi docs/quality-tools-setup.md

### MIXED (tipo di dato) - SOLO COME ULTIMA SPIAGGIA
- Il tipo **mixed** deve essere usato **SOLO come ultima spiaggia**
- Preferire sempre: union types (`string|int|null`), generics (`Collection<int, User>`), interfacce
- Usare mixed solo quando non esiste alternativa (es. API esterne senza tipo garantito)

### LOGGING BEST PRACTICES - CRITICAL FOR PERFORMANCE
- **NEVER** use Log::info() for routine operations
- **ALWAYS** use Log::error() only for actual errors
- **PERFORMANCE IMPACT**: 30-50% slowdown

### FILAMENT ACTIONS - STRING KEYS REQUIRED
- getHeaderActions() MUST return array<string, Action|ActionGroup>
- NEVER use indexed arrays

### DRY PRINCIPLE - TRAIT METHODS
- **CRITICAL**: Trait methods (getJsonFile, loadExistingData, etc.) DEVONO essere implementati UNA SOLA VOLTA nel trait, NON in ogni modello
- I modelli che usano il trait ereditano automaticamente i metodi
- Aggiungere metodi ai singoli modelli crea duplicazione del codice e viola DRY

### DATABASE DIRECTORY NAMING - LARAVEL STANDARD
- **CORRETTO**: `database/factories/`, `database/migrations/`, `database/seeders/` (tutto minuscolo)
- **SBAGLIATO**: `database/Factories/`, `database/Migrations/`, `database/Seeders/` (iniziale maiuscola)
- **Motivo**: Laravel segue la convenzione snake_case per le directory
- **PSR-4**: I namespace possono avere iniziali maiuscole (`Database\Factories`) ma le path devono essere minuscole
- **Riferimento**: Vedi `docs/conventions/database-naming.md`

### GITATTRIBUTES REMOVED - USE GITIGNORE ONLY
- **REMOVED**: Tutti i file `.gitattributes` sono stati eliminati
- **CURRENT**: Usare solo `.gitignore` (root e modulo)
- **Motivo**: Semplificazione, `.gitattributes` non necessario per questo progetto
- **Riferimento**: Vedi `docs/gitattributes-cleanup.md`

### DOCUMENTATION STRUCTURE
- **ROOT**: `docs/` per documentazione progetto
- **MODULE**: `Modules/*/docs/` per documentazione modulo
- **BASHSCRIPTS**: `bashscripts/docs/` per script bash
- **INDEX**: Ogni docs deve avere `README.md` o `index.md`
- **CONVENTIONS**: Vedi `docs/conventions/README.md`

### SCRIPT ORGANIZATION - CRITICAL
- **ALL .sh FILES**: MUST be in `bashscripts/` subfolders
- **NEVER** in project root or `laravel/` root
- **Structure**: `bashscripts/<category>/<script-name>.sh`
- **Examples**:
  - `bashscripts/system/optimization/ollama-optimize-cpu.sh`
  - `bashscripts/ai/ai_init.sh`
  - `bashscripts/git/git-cleanup.sh`
- **Docs**: Always document in `bashscripts/docs/<category>/`
- **Rationale**: Centralized, organized, discoverable, maintainable

### AI INIT SCRIPT - ENHANCED V2.0
- **Script**: `bashscripts/ai/ai_init.sh`
- **Funzione**: Crea symlinks AI in root + laravel/
- **Doppi Symlinks**: Root (`.cursor`) + Laravel (`laravel/.cursor`)
- **.github**: Fisica (rsync), NON symlink
- **.gitignore**: Auto-aggiornato con symlinks creati
- **Usage**: `cd bashscripts && ./ai/ai_init.sh`
- **Docs**: `bashscripts/docs/ai/ai_init-guide.md`

### OLLAMA OPTIMIZATION
- **Script**: `bashscripts/system/optimization/ollama-optimize-cpu.sh`
- **Purpose**: Optimize Ollama for CPU (Intel i5-8400, 32GB RAM)
- **Features**: 
  - Creates `/etc/ollama/ollama.env` with optimized settings
  - Systemd service override for performance
  - Intel MKL library installation
  - Model recommendations guide
  - Verification tool (`ollama-check`)
- **Usage**: `sudo bash bashscripts/system/optimization/ollama-optimize-cpu.sh`
- **Verify**: `ollama-check`
- **Docs**: `bashscripts/docs/system/optimization/ollama-optimize-cpu.md`
- **Hardware Target**: Intel i5-8400 (4C/4T), 32GB RAM, No GPU
- **Expected Performance**: 8-15 tokens/sec (7B models), 15-25 tokens/sec (3B models)

### GITHUB ACTIONS - SUBTREE SYNC

#### Sync Remote Repo Workflow

- **Workflow**: `.github/workflows/sync-remote-repo.yml`
- **Trigger**: Push su branch `dev` (o manuale)
- **Purpose**: Sincronizzare git subtrees automaticamente
- **Script**: `bashscripts/git/subtrees/sync_remote_repo.sh`
- **Required Secrets**:
  - `BASHSCRIPTS_TOKEN`: GitHub PAT con scope `repo` (obbligatorio)
  - `GITHUB_TOKEN`: Automatico (opzionale, fallback)
- **Subtrees Synced**: 18+ (bashscripts, modules, etc.)
- **Docs**: `bashscripts/docs/git/sync-remote-repo-guide.md`
- **Coordination**: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`

#### Sync Subtrees Workflow

- **Workflow**: `.github/workflows/sync-subtrees.yml`
- **Trigger**: Push su branch `dev` (o `workflow_dispatch`)
- **Purpose**: Alternativa sync subtrees con checkout completo
- **Script**: Same script (`sync_remote_repo.sh`)
- **Difference**: Full checkout vs sparse-checkout
- **Docs**: Same as above

#### CRITICAL: Dual-Mode Script Design

The script `bashscripts/git/subtrees/sync_remote_repo.sh` MUST work in **TWO modes**:

**1. CLI Mode (Local Development)**:
```bash
cd /var/www/_bases/base_fixcity_fila5
bashscripts/git/subtrees/sync_remote_repo.sh laraxot
```

**2. CI Mode (GitHub Actions)**:
```yaml
- name: Run remote sync
  run: bashscripts/git/subtrees/sync_remote_repo.sh laraxot
  env:
    CI: true  # Critical: enables CI mode
    BASHSCRIPTS_TOKEN: ${{ secrets.BASHSCRIPTS_TOKEN }}
```

**Key Differences**:

| Feature | CLI Mode | CI Mode |
|---------|----------|---------|
| Backup | ✅ Creates backup | ❌ Skipped |
| Conflict Resolution | Interactive | Automatic (clean + reset) |
| Working Tree | Preserves changes | Clean (`git clean -fdx`) |
| Authentication | SSH/PAT | GitHub Token (HTTPS) |

**See**: `bashscripts/docs/git/sync-remote-repo-guide.md` for complete guide

#### Multi-Agent Coordination for Sync Script

**CRITICAL**: Multiple AI agents may work on this script simultaneously.

**BEFORE Making Changes**:
1. Read coordination log: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`
2. Check GitHub Issues: `gh issue list --repo laraxot/bashscripts_fila5`
3. Add your entry to coordination log
4. Create feature branch (never work on `dev` directly)

**DURING Work**:
1. Test BOTH modes: CLI and CI
2. Use feature branches
3. Update coordination log as you work

**AFTER Work**:
1. Commit and push immediately
2. Update coordination log with results
3. Create GitHub Issue if needed
4. Remove lock file if created

**Lock File Protocol**:
```bash
# Create lock (exclusive work)
echo "Agent-XYZ-$(date -I)" > bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md.lock

# Remove lock
rm bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md.lock
```

**Agent Teams**:
- **Script Core**: Main logic, bug fixes
- **CI/CD**: GitHub Actions workflow
- **Documentation**: Guides, examples
- **Testing**: Validation, edge cases

**See**: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md` for complete coordination guidelines

## 🚀 BUILD/LINT/TEST COMMANDS

### Frontend Quality Commands
```bash
# Run all quality checks
npm run quality

# Individual quality tools
npm run quality:biome      # Biome linter/formatter
npm run quality:eslint     # ESLint for JS/TS
npm run quality:htmlhint   # HTML validation
npm run quality:markdownlint  # Markdown validation

# Auto-fix issues
npm run fix
npm run fix:biome          # Biome auto-format
npm run fix:eslint         # ESLint auto-fix
```

### Backend Quality Commands
```bash
# PHPStan static analysis (LEVEL 10 - MAXIMUM)
./vendor/bin/phpstan analyse --level=10 --memory-limit=2G

# Run PHPStan on specific module
./vendor/bin/phpstan analyse laravel/Modules/User/ --level=10

# Code formatting (Laravel Pint)
composer pint

# Run tests (Pest)
php artisan test

# Run single test
php artisan test --filter=TestMethodName
php artisan test tests/Feature/UserTest.php

# Module-specific tests
php artisan test --filter=Modules\\User\\Tests\\
```

### Laravel Custom Commands
```bash
# Go script (update + migrate + optimize)
npm run go

# Individual steps
composer update -W
php artisan migrate
php artisan filament:upgrade
php artisan optimize
```

### Filament 5 Migration Commands
```bash
# Install upgrade script
composer require filament/upgrade:"^5.0" -W --dev

# Run automated upgrade
vendor/bin/filament-v5

# Follow script output for specific commands
composer require filament/filament:"^5.0" -W --no-update
composer update

# Remove upgrade script after completion
composer remove filament/upgrade --dev
```

## 📋 CODE STYLE GUIDELINES

### PHP Standards

#### File Headers
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExampleModel.
 *
 * @package Modules\Example\Models
 */
class ExampleModel extends BaseModel
{
    // Implementation
}
```

#### Strict Requirements
- **MUST** have `declare(strict_types=1);` in every PHP file
- **MUST** define return types for all methods
- **MUST** use type hints for parameters
- **MUST** follow PSR-12 coding standards
- **MUST** use short array syntax `[]` instead of `array()`

#### Class Structure
```php
class ExampleClass extends XotBaseClass
{
    /**
     * @return array<string, mixed>
     */
    public function getExampleData(): array
    {
        return [
            'key' => 'value',
        ];
    }

    public function processData(string $input): ?string
    {
        return null;
    }
}
```

### Import/Export Patterns

#### Import Order
1. Laravel framework imports
2. Third-party packages
3. Module imports (sorted alphabetically)
4. Aliases for conflict resolution

```php
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\XotBaseResource;
use function Safe\glob;
use Webmozart\Assert\Assert;
```

#### Namespace Conventions
- **Models**: `Modules\*\Models` (NOT `Modules\*\app\Models`)
- **Filament**: `Modules\*\Filament\Resources`
- **Controllers**: `Modules\*\Http\Controllers`
- **Services**: `Modules\*\Services`

### Naming Conventions

#### Classes
- **PascalCase**: `TicketResource`, `XotBaseMigration`
- **Suffixes**: Resource, Migration, Action, Trait, Contract
- **Base Classes**: Prefix with `XotBase`

#### Methods
- **camelCase**: `getFormSchema()`, `updateTimestamps()`
- **Verb-first**: `createTicket()`, `updateUser()`
- **Boolean**: `hasPermission()`, `isAdmin()`

#### Variables
- **camelCase**: `$ticketData`, `$userId`
- **Descriptive**: `$userPermissions`, `$ticketStatus`
- **Type-indicating**: `$userArray`, `$isActiveBool`

#### Database Fields
- **snake_case**: `created_at`, `updated_by`
- **Foreign Keys**: `user_id`, `team_id`
- **Timestamps**: Standard Laravel conventions

#### Database Folders (CRITICAL)
- **ALWAYS use lowercase**: `database/factories/`, `database/migrations/`, `database/seeders/`
- **NEVER use uppercase**: `Database/Factories/`, `Database/Migrations/`, `Database/Seeders/`
- This is a case-sensitive project - wrong casing breaks autoloading

## 🏛️ ARCHITECTURAL PATTERNS

### CRITICAL: No Services, No Routes/Controllers

#### Business Logic: Use Spatie Queueable Actions
- **NEVER** create Service classes
- **ALWAYS** use Spatie\QueueableAction pattern
- Create Actions using `create-action` skill
- Actions are single-purpose, testable, and queueable
- Actions should extend appropriate base classes from Xot module
- Example structure:
  ```
  Modules/ModuleName/app/Actions/
  ├── CreateUserAction.php
  ├── UpdateTicketStatusAction.php
  └── SendNotificationAction.php
  ```

#### Routing: Use Volt + Folio + Filament
- **NEVER** create route files (routes/*.php) for module functionality
- **NEVER** create Controllers for module functionality
- **ALWAYS** use:
  - **Volt** for single-file Livewire components
  - **Folio** for file-based routing in `resources/views/pages/`
  - **Filament** for admin panel resources and widgets
  - **Laraxot** patterns and base classes
- Only use `routes/` for module registration (route service providers)
- Reference implementation: Study `base_laravelpizza` Cms module

### Module Structure
```
Modules/ModuleName/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── assets/
│   └── views/
├── routes/
├── tests/
├── composer.json
└── module.json
```

### Base Class Extensions

#### Filament Resources
- **ALWAYS** extend `XotBaseResource` from `Modules\Xot\Filament\Resources`
- **NEVER** extend Filament base classes directly
- **USE** `getFormSchema()` instead of `form()`
- **DO NOT** define `table()` method in Resource classes

#### CRITICAL: Trait Method Implementation Pattern

**NEVER** duplicate trait methods in multiple classes!** This violates DRY (Don't Repeat Yourself).

**RULE**: If a trait calls a method that doesn't exist in models, implement that method **ONCE in the trait itself**, NOT in every model using the trait.

**WRONG Pattern** (What was done 2026-03-02):
```php
// ❌ WRONG - Duplicating getJsonFile() in 4 models (Attachment, Menu, PageContent, Section)
class Attachment extends BaseModel
{
    use SushiToJsons;

    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();
        return base_path('database/content/'.$tbl.'/'.$id.'.json');
    }
}

class Menu extends BaseModel
{
    use SushiToJsons;

    public function getJsonFile(): string  // DUPLICATE!
    {
        $tbl = $this->getTable();
        $id = $this->getKey();
        return base_path('database/content/'.$tbl.'/'.$id.'.json');
    }
}
```

**CORRECT Pattern**:
```php
// ✅ CORRECT - Implement method ONCE in the trait
trait SushiToJsons
{
    /**
     * Get the JSON file path for this model instance.
     *
     * @return string
     */
    protected function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();

        $stringId = is_string($id) || is_numeric($id) ? (string) $id : 'unknown';
        $stringTbl = is_string($tbl) ? $tbl : 'unknown';

        return base_path('database/content/'.$stringTbl.'/'.$stringId.'.json');
    }
}

// Models simply use the trait without duplicating methods
class Attachment extends BaseModel
{
    use SushiToJsons;
}

class Menu extends BaseModel
{
    use SushiToJsons;
}
```

**Why This Matters**:
1. **DRY Compliance**: Single source of truth
2. **Maintainability**: Bug fix in one place, not 4
3. **Type Safety**: Consistent implementation
4. **PHPStan Compliance**: Trait methods are properly discoverable
5. **Testing**: Test once, not per model

**When to Add Methods to Models vs Traits**:
- **Add to trait**: If the method is called by the trait and needed by all models using it
- **Add to model**: If the method is model-specific or needs different implementation per model
- **Add to interface**: If the method should be available via type hints and contracts

#### CRITICAL: Static Methods in Traits (SRP Principle)

**STATIC METHODS that operate on trait-managed properties MUST be in the trait itself!**

**RULE**: If a trait defines/manages a property (e.g., `$blocks`), any static method that processes/extracts data from that property belongs in the trait, NOT in individual models.

**WRONG Pattern** (2026-03-02 - getBlocksBySlug in Section model):
```php
// ❌ WRONG - getBlocksBySlug() operates on $blocks property managed by HasBlocks trait
// but is defined in Section model instead of the trait
trait HasBlocks
{
    public array $translatable = ['blocks'];
    protected $fillable = ['blocks'];
}

class Section extends BaseModel
{
    use HasBlocks;

    public static function getBlocksBySlug(string $slug, ?string $side = null): array
    {
        // Logic that processes $blocks property - SHOULD BE IN TRAIT!
        $section = self::where('slug', $slug)->first();
        $blocks = $section->blocks;
        // ... processing blocks
    }
}
```

**CORRECT Pattern**:
```php
// ✅ CORRECT - Static method in trait that manages $blocks property
trait HasBlocks
{
    public array $translatable = ['blocks'];
    protected $fillable = ['blocks'];

    /**
     * Get blocks by slug for a specific side.
     *
     * @param string $slug The model slug
     * @param string|null $side The side to filter blocks (null for all)
     * @return array<string, \Modules\Cms\Datas\BlockData>
     */
    public static function getBlocksBySlug(string $slug, ?string $side = null): array
    {
        $model = self::where('slug', $slug)->first();

        if (! $model instanceof self) {
            return [];
        }

        $blocks = $model->blocks;

        if (! is_array($blocks)) {
            return [];
        }

        $result = [];

        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $blockType = $block['type'] ?? 'text';
            $blockData = $block['data'] ?? [];
            $blockSlug = $block['slug'] ?? null;

            try {
                $blockDataObj = new \Modules\Cms\Datas\BlockData($blockType, $blockData, $blockSlug);

                if ($side === null) {
                    $result[$blockSlug ?? $blockType] = $blockDataObj;
                } elseif (isset($block['side']) && $block['side'] === $side) {
                    $result[$blockSlug ?? $blockType] = $blockDataObj;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $result;
    }
}

// Models simply use the trait and can call the static method
class Section extends BaseModel
{
    use HasBlocks;
}

class Page extends BaseModel
{
    use HasBlocks;
}

// Both models can now use: Section::getBlocksBySlug('header', 'left') or Page::getBlocksBySlug('home')
```

**Why This Matters**:
1. **SRP Compliance**: Single Responsibility - trait owns its properties and the logic to process them
2. **DRY Compliance**: Logic defined once, reused by all models using the trait
3. **Maintainability**: Bug fix in one place affects all models
4. **Type Safety**: Consistent return types across all models
5. **Discoverability**: Related functionality stays together
6. **PHPStan Compliance**: Methods are properly discoverable in their context

**When Static Methods Belong in Models**:
- Model-specific queries that use model-specific columns
- Methods that require model-specific relationships
- Methods that have different implementations per model

**When Static Methods Belong in Traits**:
- Methods that operate on trait-managed properties
- Methods that use trait-specific logic
- Methods needed by ALL models using the trait

#### List Pages
- **ALWAYS** extend `XotBaseListRecords`
- **USE** specific methods:
  - `getTableColumns(): array`
  - `getTableFilters(): array`
  - `getTableActions(): array` - MUST return `array<string, Action|ActionGroup>` with string keys
  - `getTableBulkActions(): array` - MUST return `array<string, Action|ActionGroup>` with string keys

#### CRITICAL: Action Methods MUST Return Associative Arrays with String Keys

All Filament action methods **MUST** return `array<string, Action|ActionGroup>`:
- `getHeaderActions(): array<string, Action|ActionGroup>`
- `getTableActions(): array<string, Action|ActionGroup>`
- `getTableBulkActions(): array<string, Action|ActionGroup>`
- `getTableHeaderActions(): array<string, Action|ActionGroup>`

**CORRECT Pattern**:
```php
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        'translate' => Action::make('translate')
            ->label('Translate')
            ->icon('heroicon-o-language'),
    ];
}
```

**WRONG Pattern** (NEVER DO THIS):
```php
// WRONG - indexed array
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
        Action::make('translate'),
    ];
}
```

**Why String Keys Are Required**:
1. **PHPStan Level 10** - Requires strict typing with string keys
2. **Type Safety** - Enables proper static analysis
3. **Testing** - Actions can be targeted by key in tests
4. **Customization** - Keys allow easier action manipulation
5. **Consistency** - Standard pattern across all Filament methods

#### Migrations
- **ALWAYS** extend `XotBaseMigration`
- **NEVER** override `down()` method (it's final)
- **USE** `tableCreate()` and `tableUpdate()` methods
- **USE** `updateTimestamps()` for standard fields

### Error Handling

#### Validation Patterns
```php
use Exception;
use Webmozart\Assert\Assert;

public function execute(array $data): array
{
    try {
        Assert::isArray($data);
        Assert::notEmpty($data, 'Data cannot be empty');
        
        return $this->processData($data);
    } catch (Exception $e) {
        logger()->error('Processing failed', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        
        return [];
    }
}
```

#### Null-Safe Operations
```php
$user = auth()->user();
$profile = $user?->profile;
$name = $profile?->name ?? 'Guest';
```

## 🧪 TESTING GUIDELINES

### Testing Framework: Pest PHP

#### Test Structure
```php
<?php

use Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/** @test */
public function it_can_create_user(): void
{
    $user = User::factory()->create();
    
    $this->assertInstanceOf(User::class, $user);
    $this->assertDatabaseHas('users', [
        'id' => $user->id
    ]);
}
```

#### Test Requirements
- **MUST** use Pest PHP testing framework
- **MUST** have `RefreshDatabase` trait for feature tests
- **MUST** target 90%+ code coverage
- **SHOULD** use factories for data creation
- **MUST** pass PHPStan level 10 analysis

### Running Tests
```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/UserTest.php

# Filter by test method
php artisan test --filter=it_can_create_user

# Coverage report
php artisan test --coverage
```

## 🔧 FILAMENT 5 MIGRATION

### Migration Steps
1. **Study Documentation**: Review all docs/ folders
2. **Backup Current State**: Create branch `filament-4-backup`
3. **Run Upgrade Script**: Use `filament/upgrade` package
4. **Update Dependencies**: Follow script-generated commands
5. **Test Thoroughly**: Run all tests and quality checks
6. **Update Documentation**: Record breaking changes

### Key Changes in Filament 5
- **PHP 8.2+ Required**
- **Livewire v4.0+ Required**
- **Tailwind CSS v4.0+ Required**
- **New Panel Configuration System**
- **Enhanced Type Safety**
- **Improved Performance**

### Critical Areas to Check
- Resource classes and their methods
- Form schema definitions
- Table configurations
- Action definitions
- Panel provider configurations
- Asset compilation

## 🎯 DRY PRINCIPLES (CRITICAL)

### Trait Usage Rules
- **MAI duplicare metodi nei modelli quando possono essere definiti nei trait**
- Se un trait (es. `SushiToJsons`) può fornire un metodo (es. `getJsonFile()`), aggiungerlo **SOLO nel trait**
- I trait devono essere **self-contained** secondo base_techplanner pattern
- Quando PHPStan non trova un metodo chiamato da un modello usando un trait, PRIMA verifica se può essere aggiunto al trait
- Non aggiungere lo stesso metodo a modelli diversi - viola DRY e crea manutenzione difficoltosa

**Example WRONG** (duplicating in models):
```php
// Attachment.php
public function getJsonFile(): string { /* ... */ }

// Menu.php  
public function getJsonFile(): string { /* ... */ }

// ❌ WRONG - Duplicate code!
```

**Example CORRECT** (in trait):
```php
// SushiToJsons.php (trait)
public function getJsonFile(): string { /* ... */ }

// Attachment.php
class Attachment extends BaseModel
{
    use SushiToJsons; // ✅ Method comes from trait
}

// Menu.php
class Menu extends BaseModel
{
    use SushiToJsons; // ✅ Method comes from trait
}
```

## 📦 COMPOSER MODULE MANAGEMENT

### Merge Plugin Configuration
This project uses `wikimedia/composer-merge-plugin` for modular dependency management.

#### Module composer.json Pattern
```json
{
    "name": "fixcity/module-name",
    "type": "laravel-module",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0"
    },
    "autoload": {
        "psr-4": {
            "Modules\\ModuleName\\": "laravel/Modules/ModuleName/app/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\ModuleName\\Providers\\ModuleNameServiceProvider"
            ]
        }
    }
}
```

### Module Creation Commands
```bash
# Create new module
php artisan module:make ModuleName

# Create module with specific components
php artisan module:make Blog --api --web --seed

# Publish module assets
php artisan module:publish ModuleName
```

## 🎯 QUALITY STANDARDS

### PHPStan Configuration
- **Level**: 10 (Maximum)
- **Memory Limit**: 2GB
- **Strict Rules**: Enabled
- **Safe Operations**: Required

### Code Coverage Targets
- **Overall**: 90%+
- **Critical Modules**: 95%+
- **Models**: 100%
- **Controllers**: 90%+

### Performance Metrics
- **Response Time**: <200ms (p95)
- **Memory Usage**: <128MB per request
- **Database Queries**: Minimal N+1 problems
- **Lighthouse Score**: >95

## 📚 IMPORTANT NOTES

### Before Making Changes
1. **Check docs/** folder for existing documentation
2. **Run PHPStan level 10** to understand current state
3. **Read .windsurfrules** for Laraxot framework rules
4. **Review existing patterns** in similar modules
5. **NEVER add Log::info() for routine operations**

### After Making Changes
1. **Run quality checks**: `npm run quality`
2. **Run PHPStan**: `./vendor/bin/phpstan analyse --level=10`
3. **Run tests**: `php artisan test`
4. **Update documentation** if needed
5. **Commit with descriptive messages**
6. **Verify no Log::info() added for routine operations**

### Critical Rules from .windsurfrules
- **NEVER** extend Laravel/Filament base classes directly
- **ALWAYS** use XotBase classes
- **USE** `getFormSchema()` instead of `form()`
- **DO NOT** use `->label()` method (handled by translations)
- **FOLLOW** namespace conventions strictly
- **NEVER** use `Log::info()` for routine operations (login, logout, profile update, notifications)

### 🚨 LOGGING PERFORMANCE RULES (CRITICAL)

**FORBIDDEN** - These cause 10-30% performance degradation:
```php
// ❌ NEVER log these routine operations
Log::info('User logged in');
Log::info('User logged out');
Log::info('Profile updated');
Log::info('Registration attempt');
Log::info('Notification sent');
Log::info('Activity logged');
```

**ALLOWED** - Only significant business events:
```php
// ✅ Log these important events
Log::info('User account created', ['user_id' => $user->id, 'email' => $user->email]);
Log::info('Payment processed', ['order_id' => $order->id, 'amount' => $order->amount]);
```

**Log Level Usage**:
- **DEBUG**: Development only (`if (config('app.debug'))`)
- **INFO**: Significant business events only
- **WARNING**: Potential issues (slow API, rate limit)
- **ERROR**: Runtime errors (always with context)
- **CRITICAL**: System down (database lost, security breach)

**Performance Impact**:
- Before (excessive logging): 20-30% overhead
- After (optimized logging): 5-10% overhead
- Log volume: 500MB/day → 50MB/day (90% reduction)

**See**: `laravel/Modules/Xot/docs/LOGGING_BEST_PRACTICES_2026-03-02.md`

## 🚨 BREAKING CHANGES FOR FILAMENT 5

### Deprecated Methods
- `form()` → `getFormSchema()`
- `table()` → Remove from Resource classes
- `label()` → Remove (handled by translations)

### New Requirements
- PHP 8.2+ strict typing mandatory
- Livewire v4.0+ migration required
- Tailwind CSS v4.0+ asset compilation
- Enhanced type safety throughout

### Migration Checklist
- [ ] Backup current codebase
- [ ] Review all Filament resources
- [ ] Update form schema methods
- [ ] Remove table() methods from resources
- [ ] Test all admin panels
- [ ] Verify asset compilation
- [ ] Update documentation

---

## 🔍 PHPSTAN LEVEL 10 COMPLIANCE GUIDE

### Critical Error Patterns and Prevention

Based on the comprehensive PHPStan analysis of 2026-03-02, these are the most common errors and how to prevent them.

#### 1. Interface Completeness (HIGHEST PRIORITY)

**Problem**: 39+ errors caused by accessing undefined properties/methods on `UserContract`

**Rule**: **ALWAYS** define ALL properties and methods in interfaces that will be accessed

**Correct Interface Definition**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

/**
 * User Contract Interface
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $type
 * @property bool $exists
 * @mixin \Illuminate\Auth\Authenticatable
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\User\Models\User query()
 * @method bool save(array $options = [])
 * @method bool update(array $attributes = [], array $options = [])
 * @method mixed getKey()
 */
interface UserContract extends
    \Illuminate\Contracts\Auth\Authenticatable,
    \Illuminate\Contracts\Auth\Access\Authorizable,
    \Illuminate\Contracts\Auth\CanResetPassword
{
    // All method signatures must be declared
    public function getAuthIdentifier(): mixed;
    public function getAuthPassword(): string;
    public function getRememberToken(): ?string;
    public function setRememberToken(string $value): void;
    public function getRememberTokenName(): string;
}
```

**Usage**:
```php
// ✅ CORRECT - All properties/methods defined in interface
public function handle(UserContract $user): void
{
    $user->email = 'new@example.com';
    $user->save();
}

// ❌ WRONG - Property/method not in interface causes PHPStan error
public function handle(UserContract $user): void
{
    $user->undefinedProperty = 'value';  // ERROR!
    $user->undefinedMethod();  // ERROR!
}
```

#### 2. Factory Classes (CRITICAL)

**Problem**: 12+ errors caused by missing factory classes

**Rule**: **EVERY** model MUST have a corresponding factory class

**Correct Factory Creation**:
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Example\Models\Example;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Example>
 */
class ExampleFactory extends Factory
{
    protected $model = Example::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the example is active.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
}
```

**Model with Factory**:
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Models;

use Modules\Example\Database\Factories\ExampleFactory;
use Modules\Xot\Models\XotBaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $status
 * @property-read \Modules\Example\Models\ExampleFactory $factory
 * @method static \Modules\Example\Database\Factories\ExampleFactory factory()
 */
class Example extends XotBaseModel
{
    protected $fillable = ['name', 'email', 'status'];

    /**
     * @return \Modules\Example\Database\Factories\ExampleFactory
     */
    protected static function newFactory(): \Modules\Example\Database\Factories\ExampleFactory
    {
        return \Modules\Example\Database\Factories\ExampleFactory::new();
    }
}
```

#### 3. Mixed Type Safety (IMPORTANT)

**Problem**: 21+ errors caused by working with `mixed` types

**Rule**: **NEVER** work with `mixed` types without type assertions

**Correct Array Access**:
```php
// ❌ WRONG - Array access on mixed
public function process(array $data): void
{
    $title = $data['title'];  // ERROR!
}

// ✅ CORRECT - Type assertion before access
public function process(array $data): void
{
    $title = isset($data['title']) && is_string($data['title'])
        ? $data['title']
        : throw new \InvalidArgumentException('Missing title');
}
```

**Correct Anonymous Functions**:
```php
// ❌ WRONG - No return type
$closure = fn () => $this->create();

// ✅ CORRECT - Explicit return type
$closure = static fn (): Example => Example::factory()->create();
```

**Correct Data Transfer Objects**:
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Datas;

use Spatie\LaravelData\Data;

/**
 * @property string $title
 * @property string $description
 */
class ExampleData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}
}

// Usage
$data = ExampleData::fromArray($array);
$title = $data->title;  // Type-safe!
```

#### 4. Relationship Type Annotations (CRITICAL)

**Problem**: Type errors in relationship definitions

**Rule**: **ALWAYS** specify generic type parameters for relationships

**Correct Relationships**:
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\User\Models\User;

class Example extends XotBaseModel
{
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<\Modules\Example\Models\Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(\Modules\Example\Models\Comment::class);
    }

    /**
     * @return BelongsToMany<\Modules\Example\Models\Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Example\Models\Tag::class);
    }
}
```

### 5. DRY Principle - Trait Methods (CRITICAL)

**Problem**: Duplicating trait methods in individual models

**Rule**: **NEVER** duplicate trait methods in individual models

**CRITICAL ERROR EXAMPLE**:
```php
// ❌ WRONG - Violates DRY
class Attachment extends BaseModel
{
    use SushiToJsons;
    
    public function getJsonFile(): string // DUPLICATE!
    {
        // implementation
    }
}

class Menu extends BaseModel
{
    use SushiToJsons;
    
    public function getJsonFile(): string // DUPLICATE!
    {
        // implementation
    }
}
```

**CORRECT PATTERN**:
```php
// ✅ CORRECT - Method in trait, inherited by all models
trait SushiToJsons
{
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();
        $filename = 'database/content/'.$tbl.'/'.$id.'.json';
        return TenantService::filePath($filename);
    }
}

// Models automatically inherit the method
class Attachment extends BaseModel
{
    use SushiToJsons;
    // getJsonFile() inherited from trait - NO duplication
}

class Menu extends BaseModel
{
    use SushiToJsons;
    // getJsonFile() inherited from trait - NO duplication
}
```

**WHY THIS IS CRITICAL**:
1. **DRY Violation**: Same code in multiple files
2. **Maintenance Hell**: Bug fix requires updating all models
3. **Type Inconsistency**: Different implementations cause PHPStan errors
4. **Architectural Violation**: Traits are meant for code reuse

#### 6. Static Methods vs Instance Methods

**Problem**: Missing static methods causing errors

**Rule**: **PREFER** instance methods over static methods for model operations

**Correct Pattern**:
```php
// ❌ WRONG - Static method hard to test and type
public static function getBlocksBySlug(string $slug): array
{
    return self::where('slug', $slug)->first()->blocks ?? [];
}

// ✅ CORRECT - Instance method or query scope
public function scopeBySlug(Builder $query, string $slug): Builder
{
    return $query->where('slug', $slug);
}

// Usage
$page = Page::bySlug('example')->first();
$blocks = $page->blocks;
```

#### 6. Property Type Annotations (REQUIRED)

**Problem**: Missing property types causing errors

**Rule**: **ALWAYS** declare property types with PHPDoc

**Correct Property Declaration**:
```php
<?php

declare(strict_types=1);

namespace Modules\Example\View\Components;

use Illuminate\View\Component;
use Modules\Example\Models\Example;

class ExampleComponent extends Component
{
    /** @var array<int, Example> */
    public array $examples = [];

    /** @var string|null */
    public ?string $title = null;

    /** @var bool */
    public bool $isActive = false;

    public function mount(): void
    {
        $this->examples = Example::all()->all();
    }

    public function render(): \Illuminate\View\View
    {
        return view('example::component');
    }
}
```

### PHPStan Error Resolution Checklist

Before committing code, ensure:

- [ ] All interfaces have complete property and method declarations
- [ ] All models have corresponding factory classes
- [ ] All array access has type assertions
- [ ] All anonymous functions have explicit return types
- [ ] All relationships have proper generic type parameters
- [ ] All properties have type annotations
- [ ] No mixed types without type guards
- [ ] All static methods are defined or converted to instance methods
- [ ] PHPStan level 10 passes with zero errors

### Common PHPStan Error Messages and Solutions

#### `Access to an undefined property`
**Solution**: Add property to interface with `@property` tag

#### `Call to an undefined method`
**Solution**: Add method to interface with `@method` tag or implement in class

#### `Parameter #1 expects X, mixed given`
**Solution**: Add type assertion before using the value

#### `Anonymous function should return X but returns mixed`
**Solution**: Add explicit return type to anonymous function

#### `Unable to resolve the template type`
**Solution**: Add generic type parameters to relationships

#### `Class not found`
**Solution**: Create the missing class or fix the namespace

#### `offsetAccess.nonOffsetAccessible`
**Solution**: Add type assertion before array access

### PHPStan Best Practices

1. **Run PHPStan frequently**: After every significant code change
2. **Fix errors immediately**: Don't let errors accumulate
3. **Use type assertions**: Before accessing array elements or mixed values
4. **Create DTOs**: For complex data structures instead of arrays
5. **Document interfaces**: Include all properties and methods in PHPDoc
6. **Test types**: Add type-specific tests for critical code paths

---

## 📖 DOCUMENTATION STANDARDS

### PHPDoc Requirements

**ALL** classes, methods, and properties MUST have PHPDoc annotations:

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

/**
 * Example Model
 *
 * Represents an example entity in the system.
 *
 * @property int $id The unique identifier
 * @property string $name The example name
 * @property string $email The example email
 * @property string $status The current status
 * @property \Illuminate\Support\Carbon|null $created_at Creation timestamp
 * @property \Illuminate\Support\Carbon|null $updated_at Last update timestamp
 * @property-read User|null $user Associated user
 * @method static \Modules\Example\Database\Factories\ExampleFactory factory()
 */
class Example extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
    ];

    /**
     * Get the user associated with this example.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the example as active.
     *
     * @return bool
     */
    public function markAsActive(): bool
    {
        $this->status = 'active';
        return $this->save();
    }
}
```

### Documentation Updates

When creating or modifying features:

1. **Update module README**: Describe the feature and usage
2. **Create/update roadmap**: Track progress and future work
3. **Document error fixes**: Record how PHPStan errors were resolved
4. **Update AGENTS.md**: Add new patterns and best practices
5. **Create examples**: Show correct usage patterns

---

## 📚 DOCUMENTATION GOVERNANCE

### CRITICAL: No Temporal Strings

**RULE**: NEVER include temporal strings in documentation files.

❌ **FORBIDDEN**:
```markdown
**Last Updated**: 2026-03-02
**Next Review**: 2026-03-16
Updated: January 2025
*Last Updated: March 12, 2026*
```

✅ **CORRECT**: Use git for temporal tracking
```bash
git log --follow docs/file.md
git blame docs/file.md
```

**Why**:
1. Timeless documentation - good docs are evergreen
2. Git history tracks when changes happened
3. No maintenance burden for date updates
4. Old dates discourage readers

### Documentation Structure

**Standard Module Structure**:
```
Modules/ModuleName/
├── docs/
│   ├── README.md              # Module overview & quick reference
│   ├── architecture/          # Architecture decisions
│   ├── guides/                # How-to guides
│   ├── references/            # API references
│   ├── best-practices/        # Best practices
│   └── troubleshooting/       # Troubleshooting
```

**Standard Theme Structure**:
```
Themes/ThemeName/
├── docs/
│   ├── README.md              # Theme overview
│   ├── getting-started/       # Installation & setup
│   ├── components/            # Component documentation
│   ├── customization/         # Customization guides
│   └── build-system/          # Build processes
```

### File Naming Conventions

✅ **CORRECT**:
- `user-authentication.md` (kebab-case, lowercase)
- `00-index.md` (numeric prefix for ordering)
- `README.md`, `CHANGELOG.md` (standards)

❌ **WRONG**:
- `UserAuthentication.md` (PascalCase)
- `USER_AUTHENTICATION.md` (UPPERCASE)
- `temp.md`, `test.md` (non-descriptive)

### Documentation Quality Standards

**Every Document Must Have**:
1. Clear purpose statement
2. Target audience defined
3. Prerequisites (if any)
4. Practical examples
5. Related documents linked
6. No duplicate content

**Content Requirements**:
- English primary (Italian only for AGID compliance)
- Active voice ("Do this" not "This should be done")

---

## 🤖 MULTI-AGENT COLLABORATION

### CRITICAL: Multiple AI Agents Working Simultaneously

**THIS IS A STRENGTH, NOT A WEAKNESS!** 🚀

Multiple AI agents (Qwen, Claude, Cursor, Copilot, etc.) work on this codebase simultaneously.

**Advantages**:
- ✅ Parallel work - multiple tasks completed simultaneously
- ✅ Diverse perspectives - different agents bring different insights
- ✅ Cross-verification - agents verify each other's work
- ✅ Specialization - agents focus on their strengths
- ✅ 24/7 progress - work continues even when one agent is offline

### Rules for Multi-Agent Collaboration

#### 0. YOLO Mode by Default

**DEFAULT OPERATING MODE FOR AI AGENTS: YOLO / AUTONOMY-FIRST**

When multiple AI agents work on this repository, the default behavior is:

- act without waiting for manual confirmation when the next step is clear
- prefer execution over discussion
- make reasonable assumptions and document them after acting
- keep momentum high with small, reversible increments
- ask for confirmation only for destructive actions, missing credentials, or unclear high-risk decisions

**Why**: multi-agent collaboration is strongest when each agent removes friction instead of creating coordination bottlenecks.

#### 1. CHECK BEFORE STARTING ⚠️

**ALWAYS** check what other agents are doing:

```bash
# Check recent commits
git log --oneline -20 --all

# Check open issues
gh issue list --state open

# Check recent activity
gh run list --limit 10
```

**Why**: Avoid duplicate work and conflicts.

#### 2. DECLARE YOUR INTENTIONS 📢

**BEFORE** starting work, declare on GitHub issue:

```markdown
🤖 **Agent**: [Your Name/Type]
**Task**: [What you'll work on]
**ETA**: [Estimated completion]
**Branch**: [Branch you'll use]
**Coordination**: [How you'll coordinate]
```

**Why**: Other agents can avoid conflicts and offer help.

#### 3. WORK IN SMALL INCREMENTS 🔄

**DO**:
- ✅ Small, focused commits
- ✅ Frequent pushes (every 5-10 minutes)
- ✅ Clear commit messages
- ✅ Test before each push

**DON'T**:
- ❌ Large, monolithic commits
- ❌ Work for hours without pushing
- ❌ Vague commit messages
- ❌ Push untested code

#### 4. COMMUNICATE PROGRESS 📡

**Every 10-15 minutes**:
```markdown
**Progress Update**:
- ✅ Completed: [what's done]
- 🔄 In Progress: [what you're working on]
- ⏳ Next: [what's next]
- 🆘 Help Needed: [if you need help]
```

**When Blocked**:
```markdown
🛑 **BLOCKED**:
- Issue: [what's blocking you]
- Tried: [what you've tried]
- Need: [what you need to unblock]
```

**When Complete**:
```markdown
✅ **COMPLETE**:
- Task: [what was completed]
- Files Changed: [list of files]
- Testing: [how it was tested]
- Next Steps: [what needs to be done next]
```

#### 5. DOCUMENT EVERYTHING 📚

**ALWAYS** document your work:

- **Scripts**: `bashscripts/docs/[category]/[script].md`
- **Workflows**: `.github/` AND `bashscripts/ai/.github/`
- **Rules**: `AGENTS.md`, `.windsurfrules`
- **Memories**: Save for future reference

**Why**: Other agents (and future you) need to understand your work.

### Agent Teams

| Team | Focus | Status |
|------|-------|--------|
| **Sync** | sync_remote_repo.sh | ✅ Stable |
| **Actions** | GitHub Actions fixes | 🔄 In Progress |
| **Docs** | Documentation | ✅ Active |
| **SemVer** | Semantic versioning | ⏳ Planned |

**Join a Team**: Comment on issue #12

### Resources

- **[docs/MULTI_AGENT_COLLABORATION.md](docs/MULTI_AGENT_COLLABORATION.md)** - Complete guide
- **[Issue #12](https://github.com/laraxot/base_fixcity_fila5/issues/12)** - AI Agent Collaboration
- **[docs/AI_AGENT_TEAMS.md](docs/AI_AGENT_TEAMS.md)** - Team organization

### Success Story: 2026-03-13 Sync Fix

**Challenge**: sync_remote_repo.sh had multiple errors

**Multi-Agent Solution**:
1. **Agent A** (Qwen): Fixed unbound variables
2. **Agent B** (Claude): Fixed SSH authentication
3. **Agent C** (Cursor): Created test plan
4. **All Agents**: Cross-verified and tested

**Result**: ✅ All errors fixed, bidirectional sync working!

**Key Success Factors**:
- Clear communication via issues
- Small, focused commits
- Frequent pushes
- Cross-verification
- Comprehensive documentation

---
- Simple sentences (one idea per sentence)
- Consistent terminology (use glossary)

### Documentation Types

1. **README.md**: Module/theme overview with quick reference
2. **Guides**: Step-by-step tutorials
3. **References**: API documentation, class signatures
4. **ADRs**: Architectural Decision Records
5. **Best Practices**: Coding standards and patterns
6. **Troubleshooting**: Common issues and solutions

### Before Creating Documentation

1. **Search Existing**: Check if topic already documented
2. **Define Purpose**: Why is this needed?
3. **Choose Location**: Correct directory structure
4. **Follow Template**: Use standard format
5. **Link to Index**: Add to module README

### After Creating Documentation

1. **Update Index**: Add to module README
2. **Cross-Reference**: Link from related docs
3. **Remove Duplicates**: Check for overlapping content
4. **Verify Links**: Test all internal links
5. **Git Commit**: Commit with clear message
6. **Git Push**: Push immediately after commit

### CRITICAL: COMMIT & PUSH RULE

**WHEN TO COMMIT & PUSH**:
- ✅ GitHub Action tested & working → **COMMIT & PUSH IMMEDIATELY**
- ✅ Script tested locally → **COMMIT & PUSH**
- ✅ Documentation created → **COMMIT & PUSH**
- ✅ Configuration changed → **COMMIT & PUSH**
- ✅ Bug fixed & verified → **COMMIT & PUSH**

**WHEN NOT TO COMMIT & PUSH**:
- ❌ Work in progress (not complete)
- ❌ Untested changes
- ❌ Breaking changes (coordinate first)

**COMMIT MESSAGE FORMAT**:
```bash
git commit -m "type: description"
# Types: feat, fix, docs, ci, refactor, test, chore
```

**EXAMPLES**:
```bash
# After GitHub Action success
git add .github/workflows/sync-remote-repo.yml
git commit -m "ci: Add sync remote repo GitHub Action"
git push origin dev

# After documentation created
git add docs/MY_DOC.md
git commit -m "docs: Add my feature documentation"
git push origin dev
```

**WHY THIS MATTERS**:
- Changes not pushed = lost work
- GitHub Actions need committed code
- Other AI agents can't see unpushed changes
- Working code ≠ saved code until pushed

**REFERENCE**: [Git Commit & Push Rule](docs/GIT_COMMIT_PUSH_RULE.md)

### Documentation Resources

- [Master Documentation Index](docs/MASTER_DOCUMENTATION_INDEX.md)
- [Documentation Governance](docs/DOCUMENTATION_GOVERNANCE.md)
- [Documentation Improvement Plan](docs/DOCUMENTATION_ANALYSIS_AND_IMPROVEMENT_PLAN.md)

---

## 📊 PROJECT STATUS

### Documentation Health

| Metric | Target | Status |
|--------|--------|--------|
| Temporal Strings | 0 | ✅ Complete (784 removed) |
| Master Index | Created | ✅ Complete |
| Governance | Documented | ✅ Complete |
| Duplicate Cleanup | In Progress | 🟡 Ongoing |
| Xot Audit | In Progress | 🟡 Ongoing |

### Recent Changes

- ✅ **2026-03-13**: Database directory naming fix (Factories→factories, etc.)
- ✅ **2026-03-13**: Removed all temporal strings from documentation
- ✅ **2026-03-13**: Created documentation governance framework
- ✅ **2026-03-13**: Created master documentation index

---

## 🚀 GITHUB ACTIONS - SYNC SUBTREES

### Overview
Due to `.gitignore` containing `bashscripts/`, the GitHub Actions need to re-clone the bashscripts repository to run the sync script.

### Required Secrets
- **BASHSCRIPTS_TOKEN**: GitHub PAT with `repo` scope

### Workflows

#### 1. Sync Remote Repo (`.github/workflows/sync-remote-repo.yml`)
- Uses sparse-checkout to avoid symlink errors
- Clones only needed directories: `git/`, `lib/`, `gitmodules.ini`
- Trigger: push to `dev` branch

#### 2. Sync Subtrees (`.github/workflows/sync-subtrees.yml`)
- Same functionality as above, updated to use HTTPS with token
- Trigger: push to `dev` branch

### Documentation
- Script: `bashscripts/docs/sync-remote-repo.md`
- Contains complete setup guide and troubleshooting

---

**Filament Version**: 4.x → 5.x Migration Target  
**PHPStan Level**: 10 (Maximum)  
**Test Coverage**: 90%+ Target  
**Logging Performance**: CRITICAL - NEVER use Log::info() for routine operations
