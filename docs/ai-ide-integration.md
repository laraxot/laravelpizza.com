# AI/IDE Integration Guide - Xot Module

## Overview

The Xot module, as the core engine of the Laraxot framework, plays a crucial role in defining and enforcing architectural patterns that AI assistants and IDEs must understand and follow.

This guide explains how to leverage AI/IDE configurations to work effectively with the Xot module and the broader Laraxot ecosystem.

## AI-Aware Development

### Why AI Configuration Matters for Xot

The Xot module introduces several **critical architectural patterns** that deviate from standard Laravel:

1. **XotBase Pattern**: All Filament classes must extend `XotBase*` classes, not Filament classes directly
2. **Model Inheritance Chain**: `Model → Module BaseModel → XotBaseModel`
3. **Connection Auto-Discovery**: Database connections extracted from namespace
4. **Translation-First Components**: Never hardcode labels/placeholders
5. **Magic Property Awareness**: Never use `property_exists()` with Eloquent models

**Without proper AI configuration**, assistants will:
- Generate code extending Filament classes directly ❌
- Create duplicate casts already in XotBaseModel ❌
- Use `property_exists()` for model attribute checks ❌
- Hardcode labels instead of using translations ❌

**With proper AI configuration**, assistants will:
- Always extend XotBase classes ✅
- Follow DRY principles for model casts ✅
- Use `isset()` for magic property checks ✅
- Auto-resolve labels from translation files ✅

## Configuration Files for Xot Development

### 1. CLAUDE.md (Project Root)

The primary instruction file for Claude Code contains comprehensive Xot module guidelines:

**Key Sections**:
- XotBase Pattern (CRITICAL section)
- Model Inheritance rules
- Service Provider conventions
- Type Safety Rules
- Magic Properties Warning

**Location**: `CLAUDE.md`

### 2. Cursor Rules (`.cursor/rules/`)

Cursor-specific rules for Xot patterns:

**Recommended Rules**:
```
.cursor/rules/
├── laravel.md                        # Laravel core patterns
├── filament-xotbase.md               # XotBase extension rules
├── eloquent-magic-properties.md      # property_exists() prohibition
├── translations.md                   # Translation-first approach
└── namespace-structure.mdc           # Namespace conventions
```

### 3. Windsurf Rules (`.windsurf/rules/`)

Windsurf Cascade rules for Xot:

**Recommended Rules**:
```
.windsurf/rules/
├── laraxot-rules-complete.mdc        # Complete Laraxot guidelines
├── namespace-structure.mdc           # Namespace patterns
└── widget-filament-rules.mdc         # Filament widget patterns
```

### 4. Cursor Memories (`.cursor/memories/`)

Persistent context about common Xot patterns:

**Current Memories**:
```
.cursor/memories/
├── filament-xotbase-complete-rules.md    # Complete XotBase rules
├── property-exists-eloquent-prohibition.md
├── filament-resources.md
├── service-providers.md
└── migration-patterns.md
```

## Critical Rules for AI Assistants

### Rule 1: XotBase Extension (HIGHEST PRIORITY)

**Rule**: NEVER extend Filament classes directly. ALWAYS extend XotBase classes.

**Correct Pattern**:
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class PostResource extends XotBaseResource
{
    // ...
}
```

**Incorrect Pattern**:
```php
use Filament\Resources\Resource;  // ❌ WRONG

class PostResource extends Resource  // ❌ WRONG
{
    // ...
}
```

**How to Configure**:

`.cursor/rules/filament-xotbase.md`:
```markdown
# CRITICAL: XotBase Extension Rule

NEVER extend Filament classes directly. ALWAYS extend XotBase classes from Modules\Xot.

| ❌ WRONG | ✅ CORRECT |
|----------|-----------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
```

### Rule 2: Magic Properties Awareness

**Rule**: Laravel models use magic properties via `__get()`. NEVER use `property_exists()`.

**Correct Pattern**:
```php
// ✅ CORRECT
if (isset($model->email)) { }
if ($model->getAttribute('email') !== null) { }
```

**Incorrect Pattern**:
```php
// ❌ WRONG - property_exists() doesn't work with magic properties
if (property_exists($model, 'email')) { }
```

**How to Configure**:

`.cursor/rules/eloquent-magic-properties.md`:
```markdown
# CRITICAL: Eloquent Magic Properties

Laravel/Eloquent models use magic properties via `__get()` and `__set()`.

**NEVER use `property_exists()`** to check model attributes.

Always use:
- `isset($model->attribute)` for existence checks
- `$model->getAttribute('attribute')` for explicit checks
- `array_key_exists('attribute', $model->getAttributes())` for raw checks
```

### Rule 3: Model Inheritance Chain

**Rule**: Modules must have their own BaseModel extending XotBaseModel.

**Correct Pattern**:
```php
namespace Modules\YourModule\Models;

class YourModel extends BaseModel  // ✅ Module's BaseModel
{
    // Connection auto-discovered as 'yourmodule'
    // No need to duplicate casts from parent
}
```

**Incorrect Pattern**:
```php
namespace Modules\YourModule\Models;

use Modules\Xot\Models\XotBaseModel;

class YourModel extends XotBaseModel  // ❌ WRONG - skip module BaseModel
{
    // ...
}
```

**How to Configure**:

`.cursor/rules/model-inheritance.md`:
```markdown
# Model Inheritance Chain

Every module MUST have its own BaseModel:

Modules\{Module}\Models\YourModel
  └─ extends Modules\{Module}\Models\BaseModel
       └─ extends Modules\Xot\Models\XotBaseModel
            └─ extends Illuminate\Database\Eloquent\Model

**Never extend XotBaseModel directly.**
```

### Rule 4: Translation-First Components

**Rule**: NEVER hardcode labels, placeholders, or tooltips. Use translation files.

**Correct Pattern**:
```php
// ✅ CORRECT - Labels auto-resolved from translation files
TextInput::make('name');
// Resolves from: {locale}/{module}::field.name.label
```

**Incorrect Pattern**:
```php
// ❌ WRONG - Hardcoded text
TextInput::make('name')
    ->label('Full Name')
    ->placeholder('Enter your name');
```

**How to Configure**:

`.cursor/rules/translations.md`:
```markdown
# Translation-First Components

NEVER hardcode labels, placeholders, or tooltips in Filament components.

The LangServiceProvider automatically resolves translations from:
- `{locale}/{module}::field.{name}.label`
- `{locale}/{module}::field.{name}.placeholder`
- `{locale}/{module}::field.{name}.tooltip`

Just use: `TextInput::make('name')` and translations are automatic.
```

### Rule 5: Connection Auto-Discovery

**Rule**: Database connections are auto-discovered from namespace. Don't set manually unless needed.

**Correct Pattern**:
```php
namespace Modules\User\Models;

class Tenant extends BaseModel
{
    // Connection auto-discovered as 'user'
    // No $connection property needed
}
```

**Incorrect Pattern**:
```php
namespace Modules\User\Models;

class Tenant extends BaseModel
{
    protected $connection = 'user';  // ❌ Redundant (auto-discovered)
}
```

**How to Configure**:

`.cursor/rules/connection-auto-discovery.md`:
```markdown
# Connection Auto-Discovery

XotBaseModel automatically extracts connection name from namespace:
- `Modules\User\Models\*` → connection 'user'
- `Modules\Geo\Models\*` → connection 'geo'

Only set `protected $connection = 'custom';` if you need a different connection.
```

## AI Assistant Workflows

### When Creating a New Filament Resource

**AI Workflow**:
1. ✅ Check if extending `XotBaseResource`
2. ✅ Implement `getFormSchema()` method
3. ✅ Implement `getInfolistSchema()` method
4. ❌ DO NOT implement `getTableColumns()` (handled by XotBase)
5. ❌ DO NOT override `form()` or `infolist()` methods

**Example Prompt for AI**:
```
Create a Filament resource for Product model in the Catalog module.
Follow XotBase pattern: extend XotBaseResource, implement getFormSchema() only.
```

### When Creating a New Model

**AI Workflow**:
1. ✅ Extend module's `BaseModel`
2. ✅ Only add casts NOT in parent
3. ✅ Use `isset()` for attribute checks, never `property_exists()`
4. ❌ DO NOT set `$connection` unless different from module name

**Example Prompt for AI**:
```
Create a Product model in Modules/Catalog/Models/.
Extend BaseModel, auto-discover connection, only add custom casts.
```

### When Creating a Migration

**AI Workflow**:
1. ✅ Extend `XotBaseMigration`
2. ✅ Use `tableCreate()` method (idempotent)
3. ✅ Connection auto-discovered from namespace
4. ❌ DO NOT create multiple `create_table` migrations for same table

**Example Prompt for AI**:
```
Create migration for products table in Catalog module.
Extend XotBaseMigration, use tableCreate() method.
```

## MCP Integration with Xot

### Laravel Boost MCP Server

The project uses **Laravel Boost MCP** to enhance AI understanding of the Xot module:

**Available Commands**:
```bash
# Get module structure and versions
mcp__laravel-boost__application-info

# Search Filament v4 documentation
mcp__laravel-boost__search-docs query="Filament resources"

# Execute tinker to test Xot classes
mcp__laravel-boost__tinker code="Modules\Xot\Models\XotBaseModel::class"
```

**Configuration**: See `.claude/mcp.json`, `.cursor/mcp.json`, `.windsurf/mcp.json`

## Testing AI Configuration

### Verification Checklist

After updating AI configurations, verify with these prompts:

**Test 1: XotBase Extension**
```
Prompt: "Create a Filament resource for User model"
Expected: Extends XotBaseResource ✅
```

**Test 2: Magic Properties**
```
Prompt: "Check if user model has email attribute"
Expected: Uses isset(), not property_exists() ✅
```

**Test 3: Translation-First**
```
Prompt: "Add a name field to the form"
Expected: TextInput::make('name') without ->label() ✅
```

**Test 4: Model Inheritance**
```
Prompt: "Create a new model in Geo module"
Expected: Extends Modules\Geo\Models\BaseModel ✅
```

## Common AI Mistakes and Fixes

### Mistake 1: Direct Filament Extension

**AI Generates**:
```php
use Filament\Resources\Resource;

class PostResource extends Resource { }
```

**Fix Configuration**:
Add to `.cursor/rules/critical-rules.md`:
```markdown
# HIGHEST PRIORITY RULE
BEFORE writing ANY Filament class, CHECK:
- Are you extending XotBase or Filament directly?
- If Filament direct: STOP and use XotBase instead
```

### Mistake 2: property_exists() Usage

**AI Generates**:
```php
if (property_exists($user, 'email')) { }
```

**Fix Configuration**:
Add to `.cursor/memories/critical-errors.md`:
```markdown
# NEVER USE property_exists() WITH MODELS
This is a CRITICAL error. Models use magic properties.
Always use isset($model->attr) instead.
```

### Mistake 3: Hardcoded Labels

**AI Generates**:
```php
TextInput::make('name')->label('Full Name')
```

**Fix Configuration**:
Add to `.windsurf/rules/translation-first.mdc`:
```markdown
# Translation-First Rule
BEFORE adding ->label() to ANY component:
1. Remove it
2. Let LangServiceProvider auto-resolve from translation files
```

## Advanced: Custom Xot Patterns in AI Config

### Pattern: XotBaseWidget Form Initialization

**Pattern**: `XotBaseWidget` auto-initializes `$this->data` in `form()` method when using `statePath('data')`.

**AI Configuration**:

`.cursor/memories/widget-form-initialization.md`:
```markdown
# XotBaseWidget Form Auto-Initialization

XotBaseWidget automatically initializes $this->data in form() method:
- Widgets without model: $this->data initialized with schema keys
- Widgets with model: $this->data populated from getFormFill()

NEVER initialize $this->data in mount() for simple form widgets.
Only use mount() for specific non-form logic.
```

### Pattern: XotBasePage Navigation Properties

**Pattern**: Pages extending `XotBasePage` should NOT define navigation properties.

**AI Configuration**:

`.cursor/rules/xotbase-page-rules.md`:
```markdown
# XotBasePage Navigation Properties

Pages extending XotBasePage MUST NOT define:
- protected static ?string $navigationIcon
- protected static ?string $title
- protected static ?string $navigationLabel

These are handled automatically by XotBasePage.
Only add page-specific logic, not configuration.
```

## Maintenance and Updates

### When Xot Module Changes

**Checklist**:
1. [ ] Update `CLAUDE.md` with new patterns
2. [ ] Add rules to `.cursor/rules/`
3. [ ] Add rules to `.windsurf/rules/`
4. [ ] Update memories in `.cursor/memories/`
5. [ ] Test with AI prompts
6. [ ] Update this documentation

### Keeping AI Config in Sync

**Tools**:
```bash
# Check for inconsistencies
grep -r "XotBase" .cursor/rules/ .windsurf/rules/ CLAUDE.md

# Verify all critical rules exist
./bashscripts/ai/verify-rules.sh  # (create if needed)
```

## Resources

### Documentation

- **Main Guide**: `/docs/ai-ide-configurations.md`
- **CLAUDE.md**: Project root
- **Xot Module Docs**: `laravel/Modules/Xot/docs/`
- **MCP Configuration**: `laravel/Modules/Xot/docs/mcp-servers.md`

### Example Configurations

- **Cursor**: `.cursor/rules/filament-xotbase-complete-rules.md`
- **Windsurf**: `.windsurf/rules/laraxot-rules-complete.mdc`
- **Claude**: `CLAUDE.md` (Section: "Key Architecture Principles")

### Community

- [Cursor Directory](https://cursor.directory) - Share Xot patterns
- [Windsurf Rules Directory](https://windsurf.com/editor/directory)
- [Claude Code Documentation](https://code.claude.com/docs)

---


**Module**: Xot (Core Engine)
**Maintainer**: Laraxot Team

*This guide is part of the Laraxot PTVX Framework documentation standard.*
