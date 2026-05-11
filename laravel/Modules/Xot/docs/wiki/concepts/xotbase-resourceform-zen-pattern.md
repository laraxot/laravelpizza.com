---
title: "XotBaseResourceForm Zen Pattern"
type: concept
sources: []
confidence: high
created: 2026-05-06
updated: 2026-05-06
tags: [filament, xotbase, zen-pattern, form-schema]
related:
  - concepts/xotbase-resource-table-zen-pattern.md
  - concepts/filament-v5-hybrid-pattern.md
---

# XotBaseResourceForm Zen Pattern

## Zen Philosophy (2026-05-06)

**Core Rule**: `XotBaseResourceForm` base class owns the `configure()` method. Subclasses MUST NOT override it.

Subclasses only provide **static** methods:
- `getFormSchema(): array` — returns array of Schema components
- `getFormSchemaColumns(): int` — column count for form layout
- `getWizardSteps(): array` — wizard steps (if wizard)

## Base Class Magic

`XotBaseResourceForm::configure()` automatically calls:
```php
return $schema
    ->components(static::getFormSchema())
    ->columns(static::getFormSchemaColumns());
```

## Anti-Pattern (NEVER DO THIS)

```php
// WRONG: Non-static method doesn't match parent
class ActivityForm extends XotBaseResourceForm
{
    public function getFormSchema(): array  // FATAL: parent declares static
    {
        return [...];
    }
}
```

**Fatal Error**: `Cannot make static method XotBaseResourceForm::getFormSchema() non static`

## Correct Pattern

```php
// CORRECT: Static method matches parent declaration
class ActivityForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            // ...
        ];
    }
}
```

## Why Static?

- `XotBaseResourceForm::configure()` uses `static::getFormSchema()` (late static binding)
- Allows base class to call subclass methods without instantiation
- Matches Filament 5's fluent API pattern while keeping Xot's auto-label features

## Checklist for New Form Schemas

- [ ] Extends `XotBaseResourceForm`
- [ ] `getFormSchema()` is **static**
- [ ] Returns `array` of Filament Schema components
- [ ] No `->label()` calls (LangServiceProvider owns labels)
- [ ] No `configure()` override

## References

- Base class: `Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceForm.php`
- Example: `Modules/Activity/app/Filament/Resources/ActivityResource/Schemas/ActivityForm.php`
- Wiki: [[concepts/xotbase-resource-table-zen-pattern]]
