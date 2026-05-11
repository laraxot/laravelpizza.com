# Why XotBaseResourceForm Pattern is Superior to Filament Demo Pure-Static Classes

**Date:** 2026-05-05
**Type:** architecture-decision
**Sources:** TicketForm.php, XotBaseResourceForm.php, Filament Demo DepartmentForm.php
**Confidence:** verified
**Tags:** filament5, xotbase, architecture, langserviceprovider, wizard
**Related:** xotbase-resource-form-architecture.md, ticketform-pattern-reference.md

## The Problem with Filament Demo Pattern

Filament demo uses pure static classes like:

```php
// DepartmentForm.php (Filament Demo)
class DepartmentForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make('name')->label('Name'), // ❌ Hardcoded label
            // ...
        ]);
    }
}
```

**Problems:**
1. **Hardcoded labels** - `->label('Parent department')` breaks i18n
2. **No wizard support** - pure static class can't dynamically resolve steps
3. **No translation centralization** - each component needs individual `->label()`
4. **No shared base logic** - every Form class duplicates common patterns

## Why TicketForm.php Pattern is Superior

```php
// TicketForm.php (Our Pattern)
class TicketForm extends XotBaseResourceForm {
    public static function getFormSchema(): array {
        return [
            TextInput::make('name'), // ✅ No label - LangServiceProvider owns it
            // Wizard integration built-in
        ];
    }
    
    public static function getWizardSteps(): array {
        return [static::getStepByName('privacy'), ...];
    }
}
```

**Advantages:**

### 1. LangServiceProvider Integration (NO `->label()`)
- All translations centralized in `fixcity::segnalazione.*` language files
- No `->label()` or `->tooltip()` in module code
- Single source of truth for all translations
- Easy to add new languages (it, en, etc.)

### 2. Wizard-Ready Architecture
- `getWizardSteps()` returns `array<int, Step>`
- `getStepByName()` dynamically resolves steps via `Str::of()` transformation
- Lang keys auto-generated: `fixcity::ticket-resource.steps.privacy.label`
- Supports multi-step flows out of the box

### 3. XotBaseResourceForm Provides Common Logic
```php
// XotBaseResourceForm.php
class XotBaseResourceForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components(static::getFormSchema())
            ->columns(static::getFormSchemaColumns());
    }
    
    protected static function getStepByName(string $name): Step {
        // Dynamic resolution with LangServiceProvider
        $labelKey = $module_low.'::'.$group.'.steps.'.$name.'.label';
        return Step::make(__($labelKey))->schema($schemaComponents);
    }
}
```

### 4. Infolist Entries for Summaries (Not SchemaView)
```php
// TicketForm.php - Summary schema
public static function getSummarySchema(): array {
    return [
        TextEntry::make('review_type')  // ✅ Infolist entry
            ->state(static fn (Get $get): string => ...),
        ImageEntry::make('review_images') // ✅ Not SchemaView
            ->disk('public'),
    ];
}
```

### 5. SafeStringCastAction for Translation Casting
```php
Section::make(SafeStringCastAction::cast(__('fixcity::segnalazione.fields.place.section.label')))
    ->description(SafeStringCastAction::cast(__('fixcity::segnalazione.sections.place.description')))
```

### 6. Dynamic Values with Get $get / Set $set
```php
TextEntry::make('review_type')
    ->state(static fn (Get $get): string => static::formatTicketTypeSummary($get('type_id')))
```

## Architectural Decision

**KEEP and PROPAGATE the TicketForm pattern:**

1. ✅ All Form classes MUST extend `XotBaseResourceForm`
2. ✅ NO `->label()` or `->tooltip()` in module code
3. ✅ Use `getWizardSteps()` + `getStepByName()` for multi-step forms
4. ✅ Use Infolist entries (`TextEntry`, `ImageEntry`) for summaries
5. ✅ Use `SafeStringCastAction::cast()` for translation casting
6. ✅ Use `Get $get` and `Set $set` for dynamic values

## Filament Demo Pattern is ANTI-PATTERN for Our Project

- ❌ Breaks LangServiceProvider centralization
- ❌ No wizard support
- ❌ Hardcoded labels break i18n
- ❌ No shared base logic

## Conclusion

**TicketForm pattern is superior** because it integrates:
- Wizard dynamics
- LangServiceProvider translations
- Infolist entries for summaries
- SafeStringCastAction
- Dynamic state with Get/Set

This is the pattern to document and propagate to ALL modules.
