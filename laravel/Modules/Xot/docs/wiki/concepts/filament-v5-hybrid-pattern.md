# Filament v5 Hybrid Pattern (XotBase + configure())

**Status**: 🟡 Draft (Pending Story 8-91 Implementation)  
**Applies to**: All Laraxot Modules  
**Filament Version**: v5.x  
**Last Updated**: 2026-05-05

## Overview

This document defines the **hybrid pattern** that merges Filament v5's `configure()` approach with Laraxot's `XotBase*` extension classes. This pattern maintains backward compatibility while adopting modern Filament v5 conventions.

## The Problem

### Filament v5 Demo Pattern
```php
// Pure class, no extension
class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(2)->components([...]);
    }
}
```

### Current Laraxot Pattern
```php
// Extends XotBase, returns array
class TicketForm extends XotBaseResourceForm
{
    public static function getFormSchema(): array
    {
        return [...]; // Array of components
    }
}
```

### The Gap
- Filament v5 uses `configure(Schema): Schema` with fluent API
- Laraxot uses `getFormSchema(): array` for auto-label support
- We need both: fluent API + auto-label + XotBase features

## The Hybrid Solution

### Target Pattern (NEW)

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\ArticleResource\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextInput;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ArticleForm extends XotBaseResourceForm
{
    /**
     * Filament v5 style: Fluent Schema configuration.
     * 
     * **Philosophy**: Use fluent API for layout and structure.
     * **NO ->label() calls**: LangServiceProvider auto-resolves translations.
     * 
     * @see https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/HR/Departments/Schemas/DepartmentForm.php
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make()  // NO ->label()! Resolved from cms::article.form.sections.basic.label
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                            // NO ->label()! Resolved from cms::article.form.fields.title.label
                            
                        TextInput::make('slug')
                            ->required()
                            ->unique('articles', 'slug', ignoreRecord: true),
                    ]),
            ]);
    }
    
    /**
     * Legacy support: Array-style for backward compatibility.
     * 
     * **Deprecation**: Marked for removal in v6.0
     * **Current usage**: Resources still call getFormSchema()
     * 
     * @return array<int, Component>
     */
    public static function getFormSchema(): array
    {
        // Delegate to configure() to avoid duplication
        $schema = app(Schema::class);
        $configured = static::configure($schema);
        
        // Extract components from configured schema
        return $configured->getComponents();
    }
}
```

## Directory Structure

```
Modules/{Module}/app/Filament/Resources/{Resource}Resource/
├── Schemas/
│   ├── {Resource}Form.php          # Form schema (configure + getFormSchema)
│   ├── {Resource}Infolist.php      # Infolist schema
│   └── {Resource}Wizard.php         # Optional: Wizard-specific config
├── Tables/
│   └── {Resources}Table.php         # Table configuration
└── {Resource}Resource.php           # Resource class
```

### Naming Conventions

| Type | Singular/Plural | Example | Namespace Pattern |
|------|-----------------|---------|-------------------|
| **Form** | Singular | `ArticleForm.php` | `Modules\Cms\Filament\Resources\ArticleResource\Schemas\ArticleForm` |
| **Table** | Plural | `ArticlesTable.php` | `Modules\Cms\Filament\Resources\ArticleResource\Tables\ArticlesTable` |
| **Infolist** | Singular | `ArticleInfolist.php` | `Modules\Cms\Filament\Resources\ArticleResource\Schemas\ArticleInfolist` |
| **Wizard** | Singular | `ArticleWizard.php` | `Modules\Cms\Filament\Resources\ArticleResource\Schemas\ArticleWizard` |

## Critical Rules

### Rule 1: ZERO TOLERANCE for ->label()

```php
// ❌ FORBIDDEN - Never use ->label()
TextInput::make('name')
    ->label(__('cms::article.form.name.label'));  // VIOLATION!

// ✅ CORRECT - LangServiceProvider auto-resolves
TextInput::make('name')
    ->required()
    ->maxLength(255);
// Auto-resolves from: cms::article.form.fields.name.label
```

### Rule 2: Must Extend XotBase Classes

```php
// ✅ CORRECT - Extend XotBase for auto-label
class ArticleForm extends XotBaseResourceForm

// ❌ FORBIDDEN - Don't extend pure Filament
class ArticleForm extends \Filament\Forms\Form  // VIOLATION!
```

### Rule 3: Dual API Support (Transition Period)

During migration, both methods must work:

```php
class ArticleForm extends XotBaseResourceForm
{
    // NEW: Filament v5 style (primary)
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([...]);
    }
    
    // LEGACY: Array style (backward compatibility)
    public static function getFormSchema(): array
    {
        $schema = app(Schema::class);
        return static::configure($schema)->getComponents();
    }
}
```

### Rule 4: Schema vs Form Components

```php
// ✅ CORRECT for configure() - Use Schema components
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextInput;

// ❌ WRONG - Don't mix Form components in Schema
use Filament\Forms\Components\TextInput;  // Old namespace
```

## XotBase Class Updates

### XotBaseResourceForm (Updated)

```php
abstract class XotBaseResourceForm
{
    use TransTrait;  // Provides auto-label functionality
    
    /**
     * NEW: Filament v5 configure method.
     * Child classes MUST implement this.
     */
    abstract public static function configure(Schema $schema): Schema;
    
    /**
     * LEGACY: Array method with default implementation.
     * Can be overridden, but default delegates to configure().
     */
    public static function getFormSchema(): array
    {
        $schema = app(Schema::class);
        return static::configure($schema)->getComponents();
    }
    
    /**
     * Helper for wizard steps (optional override).
     */
    public static function getWizardSteps(): array
    {
        return [];
    }
}
```

### XotBaseResourceTable (Updated)

```php
abstract class XotBaseResourceTable
{
    use TransTrait;
    
    /**
     * NEW: Filament v5 configure method.
     */
    abstract public static function configure(Table $table): Table;
    
    /**
     * LEGACY: Array method with default implementation.
     */
    public static function table(Table $table): Table
    {
        return static::configure($table);
    }
}
```

### XotBaseResourceInfolist (Updated)

```php
abstract class XotBaseResourceInfolist
{
    use TransTrait;
    
    /**
     * NEW: Filament v5 configure method.
     */
    abstract public static function configure(Schema $schema): Schema;
    
    /**
     * LEGACY: Array method with default implementation.
     */
    public static function getInfolistSchema(): array
    {
        $schema = app(Schema::class);
        return static::configure($schema)->getComponents();
    }
}
```

## Resource Integration

### Option A: Using configure() (Preferred for new code)

```php
class ArticleResource extends XotBaseResource
{
    public static function schema(Schema $schema): Schema
    {
        return ArticleForm::configure($schema);
    }
    
    public static function table(Table $table): Table
    {
        return ArticlesTable::configure($table);
    }
}
```

### Option B: Using getFormSchema() (Legacy compatibility)

```php
class ArticleResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema(ArticleForm::getFormSchema());
    }
    
    public static function table(Table $table): Table
    {
        // Delegate to Table class
        return ArticlesTable::table($table);
    }
}
```

## Translation Resolution

### Key Structure

```
{module}::{resource}.{context}.{element}.{property}

Example: cms::article.form.fields.title.label
- module: cms
- resource: article
- context: form
- element: fields.title
- property: label
```

### Lang Files Location

```
Modules/{Module}/lang/{locale}/{resource}.php

// Example: Modules/Cms/lang/it/article.php
return [
    'form' => [
        'fields' => [
            'title' => [
                'label' => 'Titolo',
                'placeholder' => 'Inserisci il titolo',
                'help' => 'Il titolo dell\'articolo',
            ],
        ],
    ],
];
```

## Migration Checklist

### Per-Module Tasks

- [ ] Update XotBase classes (if not already done)
- [ ] Refactor {Resource}Form: add configure() method
- [ ] Refactor {Resources}Table: add configure() method
- [ ] Refactor {Resource}Infolist: add configure() method
- [ ] Verify no `->label()` calls in any file
- [ ] Verify translation keys exist in lang files
- [ ] Run PHPStan: `./vendor/bin/phpstan analyse Modules/{Module} --level=5`
- [ ] Run PHPMD: `./vendor/bin/phpmd.phar Modules/{Module} text cleancode,codesize,controversial,design,naming,unusedcode`
- [ ] Test visually in admin panel

### Quality Gates

| Gate | Command | Must Pass |
|------|---------|-----------|
| PHPStan | `./vendor/bin/phpstan analyse Modules/{Module} --level=5` | 0 errors |
| PHPMD | `./vendor/bin/phpmd.phar Modules/{Module} text ...` | 0 violations |
| Translations | `grep -r "->label(" Modules/{Module}/Filament/ \|\| echo "Clean"` | No output |

## Examples by Resource Type

### Simple Resource (No Wizard)

```php
class PageForm extends XotBaseResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('slug')->required()->unique(),
                    ]),
                Section::make()
                    ->schema([
                        RichEditor::make('content'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
```

### Wizard Resource (Multi-Step)

```php
class TicketForm extends XotBaseResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make(static::getWizardSteps())
                    ->skippable()
                    ->persistStepInQueryString(),
            ]);
    }
    
    public static function getWizardSteps(): array
    {
        return [
            Step::make('privacy')
                ->schema(static::getPrivacySchema()),
            Step::make('data')
                ->schema(static::getDataSchema()),
            Step::make('summary')
                ->schema(static::getSummarySchema()),
        ];
    }
    
    protected static function getPrivacySchema(): array
    {
        return [
            Checkbox::make('privacy_accepted')->accepted(),
        ];
    }
    
    // ... other step methods
}
```

### Table Configuration

```php
class ArticlesTable extends XotBaseResourceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('published_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ArticleStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
```

## References

### External
- Filament v5 Demo: https://github.com/filamentphp/demo/tree/5.x/app/Filament/Resources
- Filament Schemas Docs: https://filamentphp.com/docs/5.x/schemas

### Internal
- Story 8-91: `.planning/stories/8-91-filament-v5-schemas-structure-refactor.story.md`
- XotBase Classes: `Modules/Xot/app/Filament/Resources/Schemas/`
- Current TicketForm: `Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php`

## Migration Status

| Module | Status | Assigned Agent | Notes |
|--------|--------|------------------|-------|
| Xot | 🟡 In Progress | - | Base classes update |
| Cms | 🔴 Pending | Agent 1 | Pilot module |
| Blog | 🔴 Pending | Agent 2 | After Cms |
| User | 🔴 Pending | Agent 3 | Complex, many resources |
| Fixcity | 🟡 Partial | - | TicketForm already evolved |
| Geo | 🔴 Pending | Agent 4 | Map components |

---

**Next Steps**: See Story 8-91 for implementation details and agent assignments.
