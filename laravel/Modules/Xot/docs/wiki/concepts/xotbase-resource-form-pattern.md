---
title: "XotBaseResourceForm Pattern"
type: concept
sources: ["../../../../docs/wiki/concepts/filament-v5-architecture.md"]
confidence: high
created: 2026-05-05
updated: 2026-05-05
tags: [filament, schema, xot, architecture, resource-form]
related:
  - concepts/filament-v5-schema-pattern.md
  - entities/xotbaseresource.md
---

# XotBaseResourceForm Pattern

## Overview

The `XotBaseResourceForm` is an abstraction layer that wraps Filament 5's Schema pattern, providing module-specific hooks while maintaining DRY principles.

## Architecture Comparison

### Filament Demo Pattern (Reference)

From https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/HR/Departments/Schemas/DepartmentForm.php:

```php
class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                // ... more components
            ]);
    }
}
```

**Characteristics:**
- Pure static method returning Schema
- Direct Schema manipulation
- No intermediate abstraction
- Each Resource Form is independent

### Our Pattern: XotBaseResourceForm

From `Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceForm.php`:

```php
class XotBaseResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(static::getFormSchema())
            ->columns(static::getFormSchemaColumns());
    }

    public static function getFormSchema(): array
    {
        return [];
    }

    public static function getWizardSteps(): array
    {
        return [];
    }

    protected static function getStepByName(string $name): Step
    {
        // Convention: get{Name}Schema()
        $methodName = Str::of($name)->snake()->studly()->prepend('get')->append('Schema')->toString();
        // ...
    }
}
```

**Extensions in Modules:**

```php
// Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php
class TicketForm extends XotBaseResourceForm
{
    public static function getFormSchema(): array
    {
        $steps = static::getWizardSteps();
        $wizard = Wizard::make($steps)->skippable()->persistStepInQueryString();
        return [$wizard];
    }

    public static function getWizardSteps(): array
    {
        return [
            static::getStepByName('privacy'),
            static::getStepByName('data'),
            static::getStepByName('summary'),
        ];
    }

    public static function getPrivacySchema(): array { /* ... */ }
    public static function getDataSchema(): array { /* ... */ }
    public static function getSummarySchema(): array { /* ... */ }
}
```

## Philosophical Justification (Zen of the Pattern)

### 1. **Separation of Concerns (Dharma)**
- `XotBaseResourceForm`: Owns the **protocol** (how forms are structured)
- `TicketForm`: Owns the **content** (what fields/steps exist)
- Filament `Schema`: Owns the **rendering** (how things look)

### 2. **Convention over Configuration (The Middle Way)**
- `getStepByName('privacy')` → automatically calls `getPrivacySchema()`
- No manual wiring needed
- Reduces cognitive load: "What should privacy step contain?" → find `getPrivacySchema()`

### 3. **DRY + KISS (Non-Attachment to Repetition)**
- Wizard configuration logic lives ONCE in `XotBaseResourceForm`
- All modules reuse: `getWizardSteps()`, `getStepByName()`
- No copy-paste of wizard boilerplate

### 4. **LangServiceProvider Integration (Right Speech)**
- NO `->label()` or `->tooltip()` in form fields
- Labels come from `fixcity::ticket-wizard.steps.privacy.label`
- Single source of truth for translations

### 5. **Module Boundary (Universal Love)**
- `XotBaseResourceForm` = foundation (shared by all modules)
- `TicketForm` = specialization (Fixcity-specific)
- Clear separation: base vs concrete

## When to Use Which

| Scenario | Pattern |
|-----------|---------|
| Simple form (no wizard) | `getFormSchema()` returns array of components |
| Multi-step wizard | `getWizardSteps()` + `getStepByName()` + `get{X}Schema()` |
| Resource page form | Extend `XotBaseResourceForm` |
| Widget form (frontoffice) | Extend `XotBaseResourceForm` (reused!) |
| Pure Filament demo style | Only if NO module-specific logic needed |

## Key Insight

Our pattern is **NOT worse** than Filament demo - it's **complementary**:
- Demo: Good for standalone apps
- Ours: Good for **multi-module monoliths** with shared base behavior

The "extra layer" (`XotBaseResourceForm`) is not overhead - it's **infrastructure** that enables:
- Consistent wizard behavior across modules
- Automatic LangServiceProvider integration
- Step naming conventions
- Reusable wizard logic

## Related Patterns

- `XotBasePage` → for Resource Pages (extends Filament Page)
- `XotBaseWidget` → for Widgets (extends Filament Widget)
- `XotBaseWizardWidget` → for Wizard Widgets (frontoffice)

All follow the same Zen: **Base owns protocol, Child owns content.**
